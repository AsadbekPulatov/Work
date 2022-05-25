<?php

use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Auth;
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
    return redirect()->route('login');
});

Auth::routes([
    'confirm' => false,
    'login' => true,
    'logout' => true,
    'register' => false,
    'reset' => false,
    'verify' => false
]);
Route::prefix('admin')->name('admin.')->middleware(['web', 'auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::get('user/status/{user}', [\App\Http\Controllers\UserController::class, 'status'])->name('user.status')->middleware('super_admin');
    Route::resource('students', App\Http\Controllers\StudentController::class);
    Route::resource('universities', \App\Http\Controllers\UnivertyController::class)->middleware('super_admin');
    Route::resource('facultets', App\Http\Controllers\FacultetController::class)->middleware('super_admin');
    Route::resource('groups', \App\Http\Controllers\GroupController::class)->middleware('super_admin');
    Route::resource('works', \App\Http\Controllers\WorkController::class)->middleware('student');
    Route::post('graduate', \App\Http\Controllers\GraduateController::class)->name('graduate.status')->middleware('user');
    Route::get('statistic', [\App\Http\Controllers\StatisticController::class, 'index'])->name('statistic')->middleware('user');
});
