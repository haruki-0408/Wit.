<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Crypt;

use function Ramsey\Uuid\v1;

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
})->name('index');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home/profile/image/{user_id}', [App\Http\Controllers\UserController::class, 'showProfileImage'])->name('showProfileImage');
Route::get('/home/profile/{user_id}', [App\Http\Controllers\UserController::class, 'showProfile'])->name('showProfile');
Route::get('/home/profile/settings', [App\Http\Controllers\UserController::class, 'settings'])->name('settings');
Route::post('/home/profile/settings/authUserPassword', [App\Http\Controllers\UserController::class, 'authUserPassword'])->name('authUserPassword');
Route::post('/home/profile/settings/changeProfile', [\App\Http\Controllers\UserController::class, 'changeProfile'])->name('changeProfile');
Route::post('/home/profile/settings/changePassword', [\App\Http\Controllers\UserController::class, 'changePassword'])->name('changePassword');
Route::get('/home/profile/settings/deleteAccount', [App\Http\Controllers\UserController::class, 'deleteAccount'])->name('deleteAccount');
Route::get('/ShowUser', [App\Http\Controllers\UserController::class,'index'])->name('showUser');
Route::get('/ShowRoom', [App\Http\Controllers\RoomController::class,'index'])->name('showRoom');
Route::get('/ShowTag', [App\Http\Controllers\TagController::class,'index'])->name('showTag');
Route::get('/ShowRoomTag', [App\Http\Controllers\TagController::class,'relationGet'])->name('showRoomTag');
Route::get('/ShowRoomUser', [App\Http\Controllers\RoomController::class,'userGet'])->name('showRoomUser');
//Route::get('/ShowRoomImage', [App\Http\Controllers\RoomController::class,'imageGet'])->name('showRoomImage');
Route::get('/ShowRoomChat', [App\Http\Controllers\RoomController::class,'chatGet'])->name('showRoomChat');
Route::get('/home/Room:{id}', [App\Http\Controllers\RoomController::class,'enterRoom'])->name('enterRoom');
Route::get('/home/Room:{room_id}/showRoomImage:{number}', [App\Http\Controllers\RoomController::class, 'showRoomImage'])->name('showRoomImage');
Route::post('/home/authRoomPassword', [App\Http\Controllers\RoomController::class,'authRoomPassword'])->name('authRoomPassword');
Route::post('/home/create', [App\Http\Controllers\RoomController::class,'create'])->name('createRoom');
Route::get('/getUser',[App\Http\Controllers\RoomController::class,'getUser'])->name('getUser');
Route::get('/getRoomInfo{room_id?}',[App\Http\Controllers\RoomController::class,'getRoomInfo'])->middleware('auth')->name('getRoomInfo');
//Route::get('/getFirstRoomInfo',[App\Http\Controllers\RoomController::class,'getFirstRoomInfo'])->middleware('auth')->name('getFirstRoomInfo');
Route::get('/home/search',[App\Http\Controllers\UserController::class,'searchUser'])->middleware('auth')->name('searchUser');


