<?php

namespace App\Http\Models;
use DB;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model {

    public static function counts_summary() {
        return DB::select("select count(id) as clients, (select count(id) from projects) as projects, (select count(id) from projects where status=1) as completed_projects, (select count(id) from projects where status=0) as pending_projects from clients")[0];
    }

    public static function monthly_summary() {
        $summary = DB::select("SELECT 
                    month(created_at) as months, count(id) as count FROM account_statements 
                    WHERE YEAR(created_at) = YEAR(CURDATE()) AND statement_type=1 
                    GROUP BY month(created_at)");

        // echo '<pre>';print_r($candidates);exit;

        for ($a = 0; $a < 12; $a++) {
            $monthly_summary[$a]['month'] = date("Y-m", mktime(0, 0, 0, $a+1));
            $monthly_summary[$a]['amount'] = 0;

            foreach ($summary as $value) {
                if($a+1 == $value->months)
                $monthly_summary[$a]['amount'] = $value->count;
            }
        }

        return $monthly_summary;
    }
    
    public static function categories_summary() {
        return DB::table('projects')
            ->selectRaw('COUNT(projects.id) as count, projects_categories.name as category')
            ->leftJoin('projects_categories', 'projects.projects_category_id', '=', 'projects_categories.id')
            ->groupBy('projects.projects_category_id', 'projects_categories.name')
            ->get();

    }

}