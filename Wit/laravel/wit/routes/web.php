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
Route::get('/home/profile', [App\Http\Controllers\HomeController::class, 'showProfile'])->name('showProfile');
Route::get('/home/room/{id}', [App\Http\Controllers\HomeController::class, 'enterRoom'])->name('enterRoom');
Route::get('/ShowUser', [App\Http\Controllers\UserController::class,'index'])->name('showUser');
Route::get('/ShowRoom', [App\Http\Controllers\RoomController::class,'index'])->name('showRoom');
Route::get('/ShowTag', [App\Http\Controllers\TagController::class,'index'])->name('showTag');
Route::get('/ShowRoomTag', [App\Http\Controllers\TagController::class,'relationGet'])->name('showRoomTag');
Route::get('/ShowRoomUser', [App\Http\Controllers\RoomController::class,'userGet'])->name('showRoomUser');
Route::get('/ShowRoomImage', [App\Http\Controllers\RoomController::class,'imageGet'])->name('showRoomImage');
Route::get('/ShowRoomChat', [App\Http\Controllers\RoomController::class,'chatGet'])->name('showRoomChat');
Route::get('/Room{id}', [App\Http\Controllers\RoomController::class,'getRoomInfo'])->name('getRoom');
Route::post('/home/create', [App\Http\Controllers\RoomController::class,'create'])->name('createRoom');



Auth::routes();
