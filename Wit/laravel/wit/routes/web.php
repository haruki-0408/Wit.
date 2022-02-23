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
Route::get('/ShowUser', [App\Http\Controllers\UserController::class,'index'])->name('ShowUser');
Route::get('/ShowRoom', [App\Http\Controllers\RoomController::class,'index'])->name('ShowRoom');
Route::get('/ShowTag', [App\Http\Controllers\TagController::class,'index'])->name('ShowTag');
Route::get('/ShowRoomTag', [App\Http\Controllers\TagController::class,'relationGet'])->name('ShowRoomTag');
Route::get('/ShowRoomUser', [App\Http\Controllers\RoomController::class,'userGet'])->name('ShowRoomUser');
Route::get('/ShowRoomImage', [App\Http\Controllers\RoomController::class,'imageGet'])->name('ShowRoomImage');


Auth::routes();
