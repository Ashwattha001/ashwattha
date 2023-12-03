<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CompanyProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ConsultantController;
use App\Http\Controllers\ProjectEnquiryController;
use App\Http\Controllers\ConvertedProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\CalendarController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LoginController::class, 'login'])->name('login.page');


Route::post('/checkLogin', [LoginController::class, 'check_login']);
Route::group(['middleware' => 'login'], function () 
{
    // DASHBOARD
    Route::get('/dashboard', [LoginController::class, 'index'])->name('dashboard');

    Route::get('/logout', function(){

        Session::flush(); // removes all session data
        Auth::logout(); // logs out the user
        return redirect()->route('login.page');
    })->name('admin.logout');

    //Profile Management
    Route::get('/profile', [LoginController::class, 'profile'])->name('profile.page');
    Route::post('/profile_edt', [LoginController::class, 'profile_edit']);
    Route::post('/check_pass', [LoginController::class, 'check_pass']);

    //Company Management
    Route::get('/company', [CompanyProfileController::class, 'company_profile'])->name('company.profile.page')->middleware('check');
    Route::post('/edit_company', [CompanyProfileController::class, 'edit_company'])->middleware('check');

    //User Management
    Route::get('/users', [UserController::class, 'user_list'])->name('user.page')->middleware('check');
    Route::post('/post_user', [UserController::class, 'postUser'])->middleware('check');
    Route::post('/edit_users', [UserController::class, 'edit_users'])->middleware('check');
    Route::get('/change_status/{id}', [UserController::class, 'change_status'])->middleware('check');
    Route::get('/user_del', [UserController::class, 'user_delete'])->middleware('check');
    Route::get('/res_pass', [UserController::class, 'resPass']);

    //Project Status
    Route::get('/project_status', [ProjectController::class, 'projectStatusList'])->name('project_status.page');
    Route::post('/post_pro_status', [ProjectController::class, 'postProjectStatus']);
    Route::get('/get_pro_status', [ProjectController::class, 'getProjectStatus']);
    Route::get('/delete_pro_status', [ProjectController::class, 'DeleteProjectStatus']);

    //Project Type
    Route::get('/project_type', [ProjectController::class, 'projectTypeList'])->name('project_type.page');
    Route::post('/post_pro_type', [ProjectController::class, 'postProjectType']);
    Route::get('/get_pro_type', [ProjectController::class, 'getProjectType']);
    Route::get('/delete_pro_type', [ProjectController::class, 'DeleteProjectType']);

    //Consultant
    Route::get('/consultant', [ConsultantController::class, 'ConsultantList'])->name('consultant.page');
    Route::post('/post_consultant', [ConsultantController::class, 'postConsultant']);
    Route::get('/get_consultant', [ConsultantController::class, 'getConsultant']);
    Route::get('/delete_consultant', [ConsultantController::class, 'DeleteConsultant']);

    //Project Enquiry
    Route::get('/project_enquiry', [ProjectEnquiryController::class, 'projectEnquiry'])->name('project_enquiry.page');
    Route::get('/get_enq', [ProjectEnquiryController::class, 'getEnq']);
    Route::post('/post_enq', [ProjectEnquiryController::class, 'postEnq']);
    Route::get('/delete_enq', [ProjectEnquiryController::class, 'deleteEnq']);

    //Converted Project
    Route::get('/coverted_projects', [ConvertedProjectController::class, 'covertedProjects'])->name('coverted_projects.page');
    Route::get('/get_converted_pr', [ConvertedProjectController::class, 'getConvertedPr']);
    Route::post('/post_converted_pr', [ConvertedProjectController::class, 'postConvertedPr']);  

    //Enquiry Task
    Route::get('/enq_tasks', [TaskController::class, 'enqTasks'])->name('enq_tasks.page');
    Route::get('/get-enq-project', [TaskController::class, 'getEnqProject']);
    Route::get('/get-team-member', [TaskController::class, 'getTeamMember']);
    Route::post('/post_task', [TaskController::class, 'postTask']);  
    Route::get('/get_tasks', [TaskController::class, 'getTasks']);
    Route::get('/delete-task', [TaskController::class, 'deleteTask']);

    //Coonverted Task
    Route::get('/conv_tasks', [TaskController::class, 'convTasks'])->name('conv_tasks.page');
    Route::get('/get-conv-project', [TaskController::class, 'getConvProject']);
    Route::get('/get-convteam-member', [TaskController::class, 'getConvTeamMember']);
    Route::post('/post_conv_task', [TaskController::class, 'postConvTask']);  
    Route::get('/get-conv-tasks', [TaskController::class, 'getConvTasks']);
    Route::get('/delete-conv-task', [TaskController::class, 'deleteConvTask']);

    //Visit Management
    Route::get('/visit_manage', [VisitController::class, 'visitManage'])->name('visit_manage.page');
    Route::post('/post_visit_report', [VisitController::class, 'postVisitReport']);  
    Route::get('/add_visit/{id}', [VisitController::class, 'addVisit'])->name('add.visit.instruction'); 
    Route::get('/get_visits', [VisitController::class, 'getVisits']);
    Route::get('/edit_visit/{id}', [VisitController::class, 'editVisit']); 
    Route::post('/post_instruction', [VisitController::class, 'postInstruction']);
    Route::get('/get-istructions', [VisitController::class, 'getInstructions']);
    Route::get('/delete-instruc', [VisitController::class, 'deleteInstruc']);
    Route::post('/generate_visit_pdf/{id}', [VisitController::class, 'generateVisitPDF']);

    //Schedular
    Route::post('/create_schedule', [CalendarController::class, 'createSchedule']);  
    Route::get('/get_schedules', [CalendarController::class, 'getSchedules']);
    Route::post('/delete_schedules', [CalendarController::class, 'deleteSchedule']);  


}); 
