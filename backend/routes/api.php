<?php

use App\Http\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Api\MainApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('authenticate', [LoginController::class, 'login_api']);


Route::prefix('v1')->group(function () {

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('main', [MainApiController::class, 'index']);
        Route::get('/user/details', [MainApiController::class, 'userDetails']);
        Route::get('/user/resumes', [MainApiController::class, 'resumes']);
        Route::get('/user/skills', [MainApiController::class, 'skills']);
        Route::get('/user/projects', [MainApiController::class, 'projects']);
        Route::get('/user/certifications', [MainApiController::class, 'certifications']);
        Route::get('project-details/{id}', [MainApiController::class, 'getProjectDetails']);
    });

        // Route::apiResource('clients', 'Api\ClientsApiController');

        // Route::get('projects', 'Api\ProjectsApiController@read_projects');
        // Route::post('add-new-project', 'Api\ProjectsApiController@create_project');
        // Route::get('read-project/{id}', 'Api\ProjectsApiController@read_project_details');

        // Route::get('project-categories', 'Api\ProjectsApiController@read_project_categories');
        // Route::post('add-project-category', 'Api\ProjectsApiController@create_project_category');

        // Route::get('project-technologies', 'Api\ProjectsApiController@read_project_technologies');
        // Route::post('add-project-technology', 'Api\ProjectsApiController@create_project_technology');
});