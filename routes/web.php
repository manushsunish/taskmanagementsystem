<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\UserController;
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
    return redirect('/login');
});

Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/user/update/{id}', [UserController::class, 'makeProjectManager'])->name('users.update');

    Route::resource('projects', ProjectController::class);

    Route::resource('tasks', TaskController::class)->except(['create', 'store', 'show']);

    Route::controller(ProjectController::class)->group(function () {
        Route::post('projects/task-store', 'taskStore')->name('projects.task.store');
        Route::post('projects/discussion-store', 'discussionStore')->name('projects.discussion.store');
    });

});

Route::middleware('auth')
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {

    Route::controller(\App\Http\Controllers\Staff\ProjectController::class)->group(function () {
        Route::get('assigned-projects', 'assignedProjects')->name('assigned.projects');
    });
    Route::controller(\App\Http\Controllers\Staff\TaskController::class)->group(function () {
        Route::get('assigned-tasks', 'assignedTasks')->name('assigned.tasks');
    });

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
