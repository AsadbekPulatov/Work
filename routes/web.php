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
    Route::resource('students', App\Http\Controllers\StudentController::class)->middleware('adminuser');
    Route::resource('replace', \App\Http\Controllers\ReplaceController::class)->middleware('adminuser');
    Route::resource('rooms', App\Http\Controllers\RoomController::class)->middleware('adminuser');
    Route::resource('floors', App\Http\Controllers\FloorController::class)->middleware('adminuser');
    Route::resource('binos', App\Http\Controllers\BinoController::class)->middleware('admin');
    Route::resource('facultets', App\Http\Controllers\FacultetController::class)->middleware('admin');
    Route::resource('attendances', AttendanceController::class)->middleware('adminuser');
});
