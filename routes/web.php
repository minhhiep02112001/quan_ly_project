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

Route::group(['prefix' => ''], function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('task', \App\Http\Controllers\Admin\TaskController::class);
    Route::resource('target', \App\Http\Controllers\Admin\TargetController::class);
    Route::resource('project', \App\Http\Controllers\Admin\ProjectController::class);
    Route::resource('contract', \App\Http\Controllers\Admin\ContractController::class);
    Route::resource('schedule', \App\Http\Controllers\Admin\ScheduleController::class);
    Route::resource('expense-management', \App\Http\Controllers\Admin\ExpenseManagementController::class);
    Route::resource('people-involved', \App\Http\Controllers\Admin\PeopleInvolvedController::class);
});
