<?php

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

Route::get('/', function () {
    return view('admin.layout');
});
Route::get('login', [\App\Http\Controllers\AuthController::class , 'login'])->name('login');
Route::post('login', [\App\Http\Controllers\AuthController::class , 'postLogin'])->name('post.login');
Route::any('logout', [\App\Http\Controllers\AuthController::class , 'logout'])->name('logout');
Route::any('forgot-password', [\App\Http\Controllers\AuthController::class , 'forgotPassword'])->name('forgot.password');
//Route::post('forgot-password', [\App\Http\Controllers\AuthController::class , 'postForgotPassword'])->name('post.forgot.password');
Route::any('reset-password/{token}', [\App\Http\Controllers\AuthController::class,'reset'])->name('reset_password');

Route::group(['prefix' => '' , 'middleware' => ['login']], function () {
    Route::any('/profile', [\App\Http\Controllers\AuthController::class, 'profile'])->name('profile');
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('task', \App\Http\Controllers\Admin\TaskController::class);
    Route::resource('target', \App\Http\Controllers\Admin\TargetController::class);
    Route::resource('project', \App\Http\Controllers\Admin\ProjectController::class);
    Route::resource('contract', \App\Http\Controllers\Admin\ContractController::class);
    Route::resource('schedule', \App\Http\Controllers\Admin\ScheduleController::class);
    Route::resource('expense-management', \App\Http\Controllers\Admin\ExpenseManagementController::class);
    Route::resource('people-involved', \App\Http\Controllers\Admin\PeopleInvolvedController::class);
    Route::resource('employee', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('customer', \App\Http\Controllers\Admin\CustomerController::class);
    Route::resource('progress', \App\Http\Controllers\Admin\ProgressController::class)->only('show','update');
//
    Route::post('upload-file',[\App\Http\Controllers\UploadController::class, 'upload'])->name('upload.file');
});
