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
    return view('wit.index');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home/profile', [App\Http\Controllers\HomeController::class, 'showProfile'])->name('show_profile');
Route::get('/home/room/{id?}', [App\Http\Controllers\HomeController::class, 'enterRoom'])->name('enter_room');


Auth::routes();
