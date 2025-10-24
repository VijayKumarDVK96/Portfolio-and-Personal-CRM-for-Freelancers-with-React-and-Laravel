<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Models\Certification;
use App\Http\Models\Project;
use App\Http\Models\Resume;
use App\Http\Models\Technology;
use App\Http\Models\TechnologyCategory;
use App\Http\Models\UserDetail;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MainApiController extends Controller {
    protected $thumbnail_path, $portfolio_path;

    public function __construct() {
        $this->thumbnail_path = 'images/projects/thumbnail/';
        $this->portfolio_path = 'images/projects/';
    }

    public function index() {
        
        // DB::enableQueryLog();
        $userId = auth()->id();
        
        $data = Cache::remember("user.data.{$userId}", 600, function () use ($userId) {
            return [
                'details' => UserDetail::read_user_details($userId),
                'resume' => $this->getResumes(),
                'skills' => $this->getSkills(),
                'projects' => $this->getProjects(),
                'certifications' => $this->getCertifications(),
            ];
        });

        // $data['details'] = UserDetail::read_user_details($userId);
        // $data['resume'] = $this->getResumes();
        // $data['skills'] = $this->getSkills();
        // $data['projects'] = $this->getProjects();
        // $data['certifications'] = $this->getCertifications();

        // Log::info(DB::getQueryLog());

        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    // --- USER DETAILS ---
    public function userDetails() {
        $userId = auth()->id();
        $details = UserDetail::read_user_details($userId);

        return response()->json(['data' => $details], 200);
    }

    // --- RESUMES ---
    public function resumes() {
        return response()->json([
            'data' => $this->getResumes()
        ], 200);
    }

    // --- SKILLS ---
    public function skills() {
        return response()->json([
            'data' => $this->getSkills()
        ], 200);
    }

    // --- PROJECTS ---
    public function projects() {
        return response()->json([
            'data' => $this->getProjects()
        ], 200);
    }

    // --- CERTIFICATIONS ---
    public function certifications() {
        return response()->json([
            'status' => 'success',
            'data' => $this->getCertifications()
        ], 200);
    }

    protected function getResumes(): array {
        $resumes = Resume::select(
            'id',
            'type as category',
            'title',
            'organization as company',
            'location',
            'from_year as start',
            'to_year as end',
            'description',
            'icon as image',
            'created_at',
            'updated_at'
        )
        // Sort in DB: newest start year first, then newest end year
        ->orderByDesc(DB::raw('COALESCE(from_year, 0)'))
        ->orderByDesc(DB::raw('COALESCE(to_year, 0)'))
        ->get();
        
        $grouped = $resumes->groupBy('category')->map(function (Collection $items) {
            return $items->map(function ($r) {
                return [
                    'id' => $r->id,
                    'category' => $r->category,
                    'title' => $r->title,
                    'company' => $r->company,
                    'location' => $r->location,
                    'start' => $r->start,
                    'end' => $r->end,
                    'description' => $r->description,
                    'image' => $r->image,
                    'created_at' => $this->formatDate($r->created_at),
                    'updated_at' => $this->formatDate($r->updated_at),
                ];
            })->values();
        });

        return $grouped->toArray();
    }

    protected function getSkills(): array {
        $categories = TechnologyCategory::with([
            'technologies:id,category_id,name,logo'
        ])->select('id', 'name')->get();
        
        return $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'technologies' => $category->technologies->map(function ($tech) {
                    return [
                        'id' => $tech->id,
                        'name' => $tech->name,
                        'logo' => $tech->logo,
                    ];
                })->values()->toArray(),
            ];
        })->values()->toArray();
    }

    protected function getProjects(): array {
        $projects = Project::with([
            'projects_category:id,name',
            'technologies:id,name'
        ])
            ->select([
                'id',
                'name',
                'meta_description',
                'thumbnail_image',
                'projects_category_id',
                'project_url',
                'url',
                'show_on_home',
                'created_at'
            ])
            ->where('show_on_home', 1)
            ->latest('created_at')
            ->get();

        return $projects->map(function ($p) {
            return [
                'id' => $p->id,
                'title' => $p->name,
                'description' => $p->meta_description,
                'image' => $this->buildImageUrl($p->thumbnail_image, $this->thumbnail_path),
                'category_id' => $p->projects_category_id,
                'category' => optional($p->projects_category)->name,
                'project_url' => $p->project_url,
                'demo_url' => $p->url,
                'technologies' => $p->technologies->pluck('name')->values()->toArray(),
            ];
        })->toArray();
    }

    protected function getCertifications(): array {
        $certifications = Certification::with(['category:id,name'])
            ->select([
                'id',
                'title',
                'organization',
                'year',
                'category_id',
                'image',
                'credentials',
                'description',
                'created_at'
            ])
            ->orderBy('year', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return $certifications->map(function ($c) {
            return [
                'id' => $c->id,
                'title' => $c->title,
                'organization' => $c->organization ?? null,
                'year' => $c->year ?? null,
                'category_id' => $c->category_id ?? null,
                'category' => $c->category->name ?? null,
                'image' => $this->buildImageUrl($c->image),
                'credentials' => $c->credentials ?? null,
                'description' => $c->description ?? null,
                'created_at' => $this->formatDate($c->created_at),
            ];
        })->values()->toArray();
    }

    protected function buildImageUrl($image, string $localPathPrefix = ''): ?string {
        if (empty($image)) {
            return null;
        }

        // If already absolute URL, return as-is.
        if (preg_match('#^https?://#i', $image)) {
            return $image;
        }

        $prefix = $localPathPrefix !== '' ? trim($localPathPrefix, '/') . '/' : '';
        $image = ltrim($image, '/');

        return rtrim(url('/'), '/') . '/' . $prefix . $image;
    }

    protected function formatDate($dt): ?string {
        return isset($dt) ? (method_exists($dt, 'toDateTimeString') ? $dt->toDateTimeString() : (string) $dt) : null;
    }

    protected function yearSortValue($year): int {
        // For descending sort: treat null/missing as very small value so they appear last.
        return isset($year) && $year !== null && $year !== '' ? (int) $year : PHP_INT_MIN;
    }

    protected function getProjectDetails($id): array {
        $p = Project::with('technologies', 'projects_category', 'galleries')
            ->orderBy('created_at', 'desc')
            ->where('id', $id)
            ->first();

        if (!$p) {
            return [];
        }

        return [
            'id' => $p->id,
            'name' => $p->name,
            'description' => $p->description ?? null,
            'image' => $this->buildImageUrl($p->thumbnail_image, $this->thumbnail_path),
            'category_id' => $p->projects_category_id ?? null,
            'category' => $p->projects_category->name ?? null,
            'project_url' => $p->project_url ?? null,
            'demo_url' => $p->url ?? null,
            'created_at' => $this->formatDate($p->created_at),
            'technologies' => ($p->technologies ?? collect())->pluck('name')->values()->toArray(),
            'galleries'   => ($p->galleries ?? collect())->map(function ($g) {
                return [
                    'id'       => $g->id,
                    'image'    => $this->buildImageUrl($g->name, $this->portfolio_path),
                    'position' => $g->position,
                ];
            })->values()->toArray(),
        ];
    }
}