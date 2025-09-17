<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the 'web' middleware group. Now create something great!
|
*/

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\LeadsController;

Auth::routes();

Route::get('/', [HomeController::class, 'index']);
Route::get('portfolio/{slug}', [HomeController::class, 'view_portfolio_details']);
Route::post('send-enquiry', [HomeController::class, 'send_enquiry'])->middleware(['XSS']);
Route::get('sitemap.xml', [HomeController::class, 'sitemap']);
Route::get('googlee322960410f149b5.html', [HomeController::class, 'google']);

Route::view('admin/login', 'admin.login');
Route::get('test', [HomeController::class, 'test']);

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/', [AdminController::class, 'index']);
    Route::get('my-account', [AdminController::class, 'my_account']);
    Route::get('edit-profile', [AdminController::class, 'edit_profile']);
    Route::post('update-profile', [AdminController::class, 'update_profile']);
    Route::post('upload-profile-image', [AdminController::class, 'upload_profile_image'])->name('profile-image-upload');
    
    Route::get('personal-vault', [AdminController::class, 'read_personal_vault']);
    Route::post('read-personal-vault-ajax', [AdminController::class, 'read_personal_vault_ajax']);
    Route::post('add-new-personal-vault', [AdminController::class, 'create_personal_vault']);
    Route::get('edit-personal-vault/{id}', [AdminController::class, 'edit_personal_vault']);
    Route::post('update-personal-vault/{id}', [AdminController::class, 'update_personal_vault']);
    Route::get('delete-personal-vault/{id}', [AdminController::class, 'delete_personal_vault']);

    Route::get('enquiries', [AdminController::class, 'read_enquiries']);
    Route::post('read-enquiries-ajax', [AdminController::class, 'read_enquiries_ajax']);
    Route::get('delete-enquiry/{id}', [AdminController::class, 'delete_enquiry']);
    Route::get('edit-enquiry/{id}', [AdminController::class, 'edit_enquiry']);
    Route::post('update-enquiry/{id}', [AdminController::class, 'update_enquiry']);

    Route::get('resume', [AdminController::class, 'read_resume']);
    // Route::post('read-resume-ajax', [AdminController::class, 'read_resume_ajax']);
    Route::post('add-new-resume', [AdminController::class, 'create_resume']);
    Route::get('edit-resume/{id}', [AdminController::class, 'edit_resume']);
    Route::post('update-resume/{id}', [AdminController::class, 'update_resume']);
    Route::get('delete-resume/{id}', [AdminController::class, 'delete_resume']);

    Route::post('add-certification-category', [AdminController::class, 'create_certification_category']);
    Route::post('update-certification-category/{id}', [AdminController::class, 'update_certification_category']);
    Route::get('edit-certification-category/{id}', [AdminController::class, 'edit_certification_category']);
    Route::get('delete-certification-category/{id}', [AdminController::class, 'delete_certification_category']);
    Route::post('read-certification-categories-ajax', [AdminController::class, 'read_certification_category_ajax']);

    Route::get('certifications', [AdminController::class, 'read_certifications']);
    Route::post('read-certifications-ajax', [AdminController::class, 'read_certifications_ajax']);
    Route::post('add-new-certification', [AdminController::class, 'create_certification']);
    Route::get('edit-certification/{id}', [AdminController::class, 'edit_certification']);
    Route::post('update-certification/{id}', [AdminController::class, 'update_certification']);
    Route::get('delete-certification/{id}', [AdminController::class, 'delete_certification']);
    Route::post('upload-certification-image/{type}/{id}', [AdminController::class, 'upload_certification_image'])->name('certification-image-upload');
    
    Route::get('fetch-clients', [ClientsController::class, 'fetch_clients']);
    Route::get('clients', [ClientsController::class, 'read_clients']);
    Route::post('read-clients-ajax', [ClientsController::class, 'read_clients_ajax']);
    Route::get('generate-fake-clients', [ClientsController::class, 'generate_fake_clients']);
    Route::get('add-client', [ClientsController::class, 'add_client']);
    Route::post('create-client', [ClientsController::class, 'create_client'])->middleware(['XSS']);
    Route::post('update-client/{id}', [ClientsController::class, 'update_client'])->middleware(['XSS']);
    Route::get('delete-client/{id}', [ClientsController::class, 'delete_client']);

    Route::get('projects', [ProjectController::class, 'read_projects']);
    Route::post('read-projects-ajax', [ProjectController::class, 'read_projects_ajax']);
    Route::get('project-details/{id}', [ProjectController::class, 'read_project_details']);
    Route::get('add-project', [ProjectController::class, 'add_project']);
    Route::post('add-new-project', [ProjectController::class, 'create_project']);
    Route::get('edit-project/{id}', [ProjectController::class, 'edit_project']);
    Route::post('update-project/{id}', [ProjectController::class, 'update_project']);
    Route::get('delete-project/{id}', [ProjectController::class, 'delete_project']);
    Route::post('upload-thumbnail-image/{id}', [ProjectController::class, 'upload_thumbnail_image'])->name('thumbnail-image-upload');
    Route::post('upload-portfolio-image/{id}', [ProjectController::class, 'upload_portfolio_image'])->name('portfolio-image-upload');
    Route::post('change-gallery-position', [ProjectController::class, 'change_gallery_position']);
    Route::get('delete-portfolio-image/{id}', [ProjectController::class, 'delete_portfolio_image']);

    Route::get('project-categories', [ProjectController::class, 'read_project_categories']);
    Route::post('add-project-category', [ProjectController::class, 'create_project_category']);

    Route::get('project-technologies', [ProjectController::class, 'read_project_technologies']);
    Route::post('add-project-technology', [ProjectController::class, 'create_project_technology']);
    Route::post('update-project-technology/{id}', [ProjectController::class, 'update_project_technology']);
    Route::post('add-technology-category', [ProjectController::class, 'create_technology_category']);
    Route::post('update-technology-category/{id}', [ProjectController::class, 'update_technology_category']);
    Route::get('delete-technology-category/{id}', [ProjectController::class, 'delete_technology_category']);
    Route::get('delete-technology/{id}', [ProjectController::class, 'delete_technology']);

    Route::get('vault-categories', [ProjectController::class, 'read_vault_categories']);
    Route::post('add-vault-category', [ProjectController::class, 'create_vault_category']);

    Route::get('vault/{id}', [ProjectController::class, 'read_vault']);
    Route::get('read-vault-ajax/{id}/{category_id?}', [ProjectController::class, 'read_vault_ajax']);
    Route::post('add-new-vault/{id}', [ProjectController::class, 'create_vault']);
    Route::get('edit-vault/{id}', [ProjectController::class, 'edit_vault']);
    Route::post('update-vault/{id}', [ProjectController::class, 'update_vault']);
    Route::get('delete-vault/{id}', [ProjectController::class, 'delete_vault']);

    Route::post('add-milestone/{id}', [ProjectController::class, 'create_milestone']);
    Route::get('read-milestone/{id}', [ProjectController::class, 'read_milestone']);
    Route::get('update-milestone/{id}/{type}', [ProjectController::class, 'update_milestone']);

    Route::get('project-tasks/{id}', [ProjectController::class, 'view_tasks']);
    Route::post('add-task/{id}', [ProjectController::class, 'create_task']);
    Route::get('update-task/{id}/{type}', [ProjectController::class, 'update_task']);

    Route::get('estimates', [AccountsController::class, 'read_estimates']);
    Route::post('estimates-ajax', [AccountsController::class, 'read_estimates_ajax']);
    Route::get('add-estimate', [AccountsController::class, 'add_estimate']);
    Route::post('create-estimate', [AccountsController::class, 'create_estimate']);
    Route::get('view-estimate/{id}', [AccountsController::class, 'view_estimate']);
    Route::get('edit-estimate/{id}', [AccountsController::class, 'edit_estimate']);
    Route::post('update-estimate/{id}', [AccountsController::class, 'update_estimate']);
    Route::get('delete-estimate/{id}', [AccountsController::class, 'delete_estimate']);
    Route::get('send-estimate/{id}', [AccountsController::class, 'send_estimate']);

    Route::get('invoices', [AccountsController::class, 'read_invoices']);
    Route::post('invoices-ajax', [AccountsController::class, 'read_invoices_ajax']);
    Route::get('add-invoice', [AccountsController::class, 'add_invoice']);
    Route::post('create-invoice', [AccountsController::class, 'create_invoice']);
    Route::get('view-invoice/{id}', [AccountsController::class, 'view_invoice']);
    Route::get('edit-invoice/{id}', [AccountsController::class, 'edit_invoice']);
    Route::post('update-invoice/{id}', [AccountsController::class, 'update_invoice']);
    Route::get('delete-invoice/{id}', [AccountsController::class, 'delete_invoice']);
    Route::get('send-invoice/{id}', [AccountsController::class, 'send_invoice']);

    Route::get('payments', [AccountsController::class, 'read_payments']);
    Route::post('payments-ajax', [AccountsController::class, 'read_payments_ajax']);
    Route::get('add-payment', [AccountsController::class, 'add_payment']);
    Route::post('create-payment', [AccountsController::class, 'create_payment']);
    Route::get('edit-payment/{id}', [AccountsController::class, 'edit_payment']);
    Route::post('update-payment/{id}', [AccountsController::class, 'update_payment']);
    Route::get('delete-payment/{id}', [AccountsController::class, 'delete_payment']);

    Route::get('lead-categories', [LeadsController::class, 'read_leads_categories']);
    Route::post('add-lead-category', [LeadsController::class, 'create_leads_category']);
    Route::get('leads', [LeadsController::class, 'read_leads']);
    Route::post('leads-ajax', [LeadsController::class, 'read_leads_ajax']);
    Route::get('add-lead', [LeadsController::class, 'add_lead']);
    Route::post('create-lead', [LeadsController::class, 'create_lead']);
    Route::get('edit-lead/{id}', [LeadsController::class, 'edit_lead']);
    Route::post('update-lead/{id}', [LeadsController::class, 'update_lead']);
    Route::get('delete-lead/{id}', [LeadsController::class, 'delete_lead']);
    Route::get('leads-status-ajax/{id}', [LeadsController::class, 'read_leads_status_ajax']);
    Route::post('create-lead-status', [LeadsController::class, 'create_lead_status']);
    Route::get('delete-lead-status/{id}', [LeadsController::class, 'delete_lead_status']);
    Route::post('import-leads', [LeadsController::class, 'import_leads']);
    Route::post('bulk-action-leads', [LeadsController::class, 'bulk_action_leads']);
});

Route::get('/getmacexec', function() {
    $shellexec = exec('getmac'); 
    dd($shellexec);
});


Route::post('show-cities/{state_id}', [AdminController::class, 'show_cities'])->middleware(['XSS']);

Route::get('clear-cache', function () {
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
});