<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Controllers
|--------------------------------------------------------------------------
|
*/

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\BasicInfoController;
use App\Http\Controllers\admin\SliderController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\SubChildController;
use App\Http\Controllers\admin\MessageController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\AdminController; 
use App\Http\Controllers\admin\CouponController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\ReviewController;
use App\Http\Controllers\admin\HomeFeatureController;
use App\Http\Controllers\admin\DealController;
use App\Http\Controllers\admin\BlogCategoryController;
use App\Http\Controllers\admin\BlogController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\AboutUsController;
use App\Http\Controllers\admin\ServiceController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\TraineeController;
use App\Http\Controllers\admin\TrainerController;
use App\Http\Controllers\admin\CourseController;
use App\Http\Controllers\admin\BatchController;
use App\Http\Controllers\admin\ScheduleController;
use App\Http\Controllers\admin\EnrollController;
use App\Http\Controllers\admin\AttendanceController;
use App\Http\Controllers\admin\EvaluationController;
use App\Http\Controllers\admin\DepartmentController;
use App\Http\Controllers\admin\DesignationController;
use App\Http\Controllers\admin\ExpenseHeadController;
use App\Http\Controllers\admin\ExpenseController;


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
*/
// Route::get('myrts', function () {
//     $routeCollection = Route::getRoutes();

//     echo "<table style='width:100%'>";
//     echo "<tr>";
//     echo "<td width='10%'><h4>Name</h4></td>";
//     echo "</tr>";
//     foreach ($routeCollection as $value) {
//         echo "<tr>";
//         echo "<td>" . $value->getName() . "</td>";
//         echo "</tr>";
//     }
//     echo "</table>";
// });


Route::get('/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return 'View cache has been cleared';
});

Route::get('/', function() {
    return redirect('admin/login');
});

Route::prefix('admin')->namespace('App\Http\Controllers\admin')->group(function () {
    Route::match(['get', 'post'],'login', [AdminController::class , 'login']);
    Route::middleware('admin')->group(function (){
        Route::post('logout', [AdminController::class ,'logout']);
        Route::prefix('profile')->group(function(){  
            Route::post('check-admin-password', [AdminController::class ,'checkAdminPassword']);
            Route::match(['get', 'post'],'update-admin-details/{id?}', [AdminController::class ,'updateAdminDetails'])->name('admins.update.details');
            Route::match(['get', 'post'],'update-admin-password/{id?}', [AdminController::class ,'updateAdminPassword'])->name('admins.update.password');
        });
        Route::resource('dashboard', DashboardController::class);
        Route::resource('basic-infos', BasicInfoController::class);
        Route::prefix('admin')->group(function () {
            Route::resource('roles', RoleController::class);
            Route::resource('admins', AdminController::class);
        });

        Route::resource('trainees', TraineeController::class);
        Route::get('trainees-create-or-edit/{id?}', [TraineeController::class,'createOrEdit']);
        Route::resource('trainers', TrainerController::class);
        Route::get('trainers-create-or-edit/{id?}', [TrainerController::class,'createOrEdit']);
        Route::resource('courses', CourseController::class);
        Route::get('courses-create-or-edit/{id?}', [CourseController::class,'createOrEdit']);
        Route::resource('batches', BatchController::class);
        Route::get('batches-create-or-edit/{id?}', [BatchController::class,'createOrEdit']);

        Route::prefix('schedule')->group(function(){
            Route::resource('schedules', ScheduleController::class);
            Route::get('schedules-create-or-edit/{id?}', [ScheduleController::class,'createOrEdit']);
            Route::get('calendar', [ScheduleController::class,'calendar']);
            Route::get('all-schedule', [ScheduleController::class,'allSchedule']);
        });

        Route::resource('enrolles', EnrollController::class);
        Route::get('enrolles-create-or-edit/{id?}', [EnrollController::class,'createOrEdit']);
        
        Route::resource('attendances', AttendanceController::class);
        Route::get('attendances-create-or-edit/{id?}', [AttendanceController::class,'createOrEdit']);
        Route::get('get-schedule-trainee/{id?}', [AttendanceController::class,'getScheduleTrainee']);

        Route::prefix('result')->group(function(){
            Route::resource('result-entries', EvaluationController::class);
            Route::get('result-entries-create-or-edit/{id?}', [EvaluationController::class,'createOrEdit']);
            Route::get('certificates', [EvaluationController::class,'certificates']);
            Route::get('certificate-print', [EvaluationController::class,'certificatePrint']);
        });
    
        Route::resource('departments', DepartmentController::class);
        Route::get('departments-create-or-edit/{id?}', [DepartmentController::class,'createOrEdit']);

        Route::resource('designations', DesignationController::class);
        Route::get('designations-create-or-edit/{id?}', [DesignationController::class,'createOrEdit']);
        
        Route::prefix('expense')->group(function(){
            Route::resource('expense-heads', ExpenseHeadController::class);
            Route::get('expense-heads-create-or-edit/{id?}', [ExpenseHeadController::class,'createOrEdit']);
            Route::resource('expenses', ExpenseController::class);
            Route::get('expenses-create-or-edit/{id?}', [ExpenseController::class,'createOrEdit']);
        });

        Route::prefix('reports')->controller('App\Http\Controllers\admin\ReportController')->group(function(){

            Route::get('training-reports', 'trainingReports');
            Route::get('dept-trainees/{id}', 'deptTrainees');
            Route::post('training-reports-data', 'trainingReportsData');
            Route::get('training-reports-print', 'trainingReportsPrint');
            
            Route::get('training-expense-reports', 'trainingExpenseReports');
            Route::post('training-expense-reports-data', 'trainingExpenseReportsData');
            Route::get('get-batches', 'getBatches');
            Route::get('training-expense-reports-print', 'trainingExpenseReportsPrint');

        });
        
    });

});

require __DIR__.'/auth.php';
