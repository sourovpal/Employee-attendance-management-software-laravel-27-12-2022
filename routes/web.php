<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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

// Clear application cache:
Route::get('/clear', function() {
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('queue:clear');
    Artisan::call('event:clear');
    Artisan::call('optimize:clear');
    Artisan::call('cache:clear');
    return __('Application cache has been cleared ✔️');
});
Route::get('/run', function() {
    return view('commend');
});

Route::post('/run', function() {
    
    if(request()->commend != ''){
        Artisan::call(request()->commend);
    }
    if(request()->select_commend != ''){
        Artisan::call(request()->select_commend);
    }
    
    return view('commend', [
        
            'successMessage' => "Commend run successful [ ".request()->commend." ]-[ ".request()->select_commend." ]"
        ]);
});





// Permission Route
Route::prefix('permission')->as('permission.')->group(function(){
    Route::get('/', [PermissionController::class, 'index'])->name('index');
    Route::get('/create', [PermissionController::class, 'create'])->name('create');
    Route::post('/create', [PermissionController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [PermissionController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [PermissionController::class, 'update'])->name('update');
    Route::get('/delete/{id}', [PermissionController::class, 'delete'])->name('delete');
});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Employee Route
Route::prefix('employee')->as('employee.')->group(function(){
    Route::get('/', [App\Http\Controllers\EmployeeController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\EmployeeController::class, 'create'])->name('create');
    Route::post('/create', [App\Http\Controllers\EmployeeController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [App\Http\Controllers\EmployeeController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [App\Http\Controllers\EmployeeController::class, 'update'])->name('update');
    Route::get('/delete/{id}', [App\Http\Controllers\EmployeeController::class, 'delete'])->name('delete');
    Route::get('/profile/{id?}', [App\Http\Controllers\EmployeeController::class, 'profile'])->name('profile');
    Route::post('/profile', [App\Http\Controllers\EmployeeController::class, 'profile_update'])->name('profile.update');
    Route::post('/password', [App\Http\Controllers\EmployeeController::class, 'password'])->name('profile.password');
});


// Branch Route
Route::prefix('branch')->as('branch.')->group(function(){
    Route::get('/', [App\Http\Controllers\BranchController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\BranchController::class, 'create'])->name('create');
    Route::post('/create', [App\Http\Controllers\BranchController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [App\Http\Controllers\BranchController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [App\Http\Controllers\BranchController::class, 'update'])->name('update');
    Route::get('/delete/{id}', [App\Http\Controllers\BranchController::class, 'delete'])->name('delete');
});


// Attendance Route
Route::prefix('attendance')->as('attendance.')->group(function(){
    Route::get('/', [App\Http\Controllers\AttendanceController::class, 'index'])->name('index');
    Route::get('/create/{id?}', [App\Http\Controllers\AttendanceController::class, 'create'])->name('create');
    Route::post('/create', [App\Http\Controllers\AttendanceController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [App\Http\Controllers\AttendanceController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [App\Http\Controllers\AttendanceController::class, 'update'])->name('update');
    Route::get('/delete/{id}', [App\Http\Controllers\AttendanceController::class, 'delete'])->name('delete');
    Route::get('/clock', [App\Http\Controllers\AttendanceController::class, 'clock'])->name('clock');
    Route::post('/clock', [App\Http\Controllers\AttendanceController::class, 'clock_submit'])->name('clock.submit');
});


// Schedule Route
Route::prefix('schedule')->as('schedule.')->group(function(){
    Route::get('/', [App\Http\Controllers\ScheduleController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\ScheduleController::class, 'create'])->name('create');
    Route::post('/create', [App\Http\Controllers\ScheduleController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [App\Http\Controllers\ScheduleController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [App\Http\Controllers\ScheduleController::class, 'update'])->name('update');
    Route::get('/delete/{id}', [App\Http\Controllers\ScheduleController::class, 'delete'])->name('delete');
});


// Leave Route
Route::prefix('leave')->as('leave.')->group(function(){
    Route::get('/{id}', [App\Http\Controllers\LeaveController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\LeaveController::class, 'create'])->name('create');
    Route::post('/create/{id}', [App\Http\Controllers\LeaveController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [App\Http\Controllers\LeaveController::class, 'edit'])->name('edit');
    Route::get('/update/{id}/{status}', [App\Http\Controllers\LeaveController::class, 'update'])->name('update');
    Route::get('/delete/{id}', [App\Http\Controllers\LeaveController::class, 'delete'])->name('delete');
});





