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

class MainApiController extends Controller {
    protected $thumbnail_path, $portfolio_path;

    public function __construct() {
        $this->thumbnail_path = 'images/projects/thumbnail/';
        $this->portfolio_path = 'images/projects/';
    }

    public function index() {
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

        return response()->json(['status' => 'success', 'data' => $data], 200);

        // $data = [];

        // $data['details'] = UserDetail::read_user_details(auth()->id());

        // $data['resume'] = $this->getResumes();
        // $data['skills'] = $this->getSkills();
        // $data['projects'] = $this->getProjects();
        // $data['certifications'] = $this->getCertifications();

        // $users = Cache::remember('users.all', 600, function () {
        //     return User::all();
        // });

        // return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    protected function getResumes(): array {
        $all = Resume::all()->map(function ($r) {
            return [
                'id' => $r->id,
                'category' => $r->type,
                'title' => $r->title,
                'company' => $r->organization,
                'location' => $r->location ?? null,
                'start' => $r->from_year ?? null,
                'end' => $r->to_year ?? null,
                'description' => $r->description ?? null,
                'image' => $r->icon ?? null,
                'created_at' => $this->formatDate($r->created_at),
                'updated_at' => $this->formatDate($r->updated_at),
            ];
        });

        $grouped = $all->groupBy('category')->map(function (Collection $group) {
            $sorted = $group->sort(function ($a, $b) {
                // Descending by start year, then end year (nulls last)
                $aStart = $this->yearSortValue($a['start']);
                $bStart = $this->yearSortValue($b['start']);
                if ($aStart === $bStart) {
                    $aEnd = $this->yearSortValue($a['end']);
                    $bEnd = $this->yearSortValue($b['end']);
                    return $bEnd <=> $aEnd;
                }
                return $bStart <=> $aStart;
            });

            return $sorted->values();
        });

        return $grouped->toArray();
    }

    protected function getSkills(): array {
        $categories = TechnologyCategory::all();
        $technologies = Technology::all()->groupBy('category_id');

        $skills = $categories->map(function ($cat) use ($technologies) {
            $techs = $technologies->get($cat->id, collect())->map(function ($t) {
                return [
                    'id' => $t->id,
                    'name' => $t->name,
                    'logo' => $t->logo ?? null,
                ];
            })->values()->toArray();

            return [
                'id' => $cat->id,
                'name' => $cat->name,
                'technologies' => $techs,
            ];
        })->values();

        return $skills->toArray();
    }

    protected function getProjects(): array {
        return Project::with('technologies', 'projects_category')
            ->where('show_on_home', 1)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'title' => $p->name,
                    'description' => $p->meta_description ?? null,
                    'image' => $this->buildImageUrl($p->thumbnail_image, $this->thumbnail_path),
                    'category_id' => $p->projects_category_id ?? null,
                    'category' => $p->projects_category->name ?? null,
                    'project_url' => $p->project_url ?? null,
                    'demo_url' => $p->url ?? null,
                    'technologies' => ($p->technologies ?? collect())->pluck('name')->values()->toArray(),
                ];
            })->values()->toArray();
    }

    protected function getCertifications(): array {
        return Certification::with('category')
            ->orderBy('year', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($c) {
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