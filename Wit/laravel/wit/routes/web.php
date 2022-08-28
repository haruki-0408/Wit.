<?php

use App\Events\UserSessionChanged;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Crypt;


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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/home/profile:{user_id}', [App\Http\Controllers\UserController::class, 'showProfile'])->name('showProfile');
    Route::get('/home/profile/settings', [App\Http\Controllers\UserController::class, 'settings'])->name('settings');
    Route::post('/home/profile/settings/authUserPassword', [App\Http\Controllers\UserController::class, 'authUserPassword'])->name('authUserPassword');
    Route::post('/home/profile/settings/changeProfile', [\App\Http\Controllers\UserController::class, 'changeProfile'])->name('changeProfile');
    Route::post('/home/profile/settings/changePassword', [\App\Http\Controllers\UserController::class, 'changePassword'])->name('changePassword');
    Route::get('/home/profile/settings/deleteAccount', [App\Http\Controllers\UserController::class, 'deleteAccount'])->name('deleteAccount');
    Route::get('/home/room:{room_id}', [App\Http\Controllers\RoomController::class, 'enterRoom'])->name('enterRoom');
    Route::post('/home/save/room:{room_id}', [App\Http\Controllers\RoomController::class, 'saveRoom'])->name('saveRoom');
    Route::get('/home/post_room:{room_id}', [App\Http\Controllers\RoomController::class, 'showPostRoom'])->name('showPostRoom');
    Route::get('/home/room:{room_id}/showRoomImage:{number}', [App\Http\Controllers\RoomController::class, 'showRoomImage'])->name('showRoomImage');
    Route::post('/home/authRoomPassword', [App\Http\Controllers\RoomController::class, 'authRoomPassword'])->name('authRoomPassword');
    Route::post('/home/exitRoom',[App\Http\Controllers\RoomController::class, 'exitRoom'])->name('exitRoom');
    Route::post('/home/createRoom', [App\Http\Controllers\RoomController::class, 'createRoom'])->name('createRoom');
    Route::get('/getTrendTags', [App\Http\Controllers\TagController::class, 'getTrend'])->name('getTrendTags');
    
    Route::get('/home/removeRoom:{room_id}', [App\Http\Controllers\RoomController::class, 'removeRoom'])->name('removeRoom');
    Route::get('/home/addListRoom:{room_id}', [App\Http\Controllers\RoomController::class, 'actionAddListRoom'])->name('actionAddListRoom');
    Route::get('/home/removeListRoom:{room_id}', [App\Http\Controllers\RoomController::class, 'actionRemoveListRoom'])->name('actionRemoveListRoom');
    Route::get('/home/addListUser:{user_id}', [App\Http\Controllers\UserController::class, 'actionAddListUser'])->name('actioAddListUser');
    Route::get('/home/removeListUser:{user_id}', [App\Http\Controllers\UserController::class, 'actionRemoveListUser'])->name('actionRemoveListUser');
    //api
    Route::post('/home/room/chat/message', [App\Http\Controllers\RoomController::class, 'receiveMessage'])->name('receiveMessage');
    Route::post('/home/room/ban/', [App\Http\Controllers\RoomController::class, 'receiveBanUser'])->name('receiveBanUser');
    Route::post('/home/room/ban/lift', [App\Http\Controllers\RoomController::class, 'receiveLiftBanUser'])->name('receiveLiftBanUser');
    Route::get('/getRoomInfo:{room_id?}', [App\Http\Controllers\RoomController::class, 'getRoomInfo'])->name('getRoomInfo');
    Route::get('/getPostRoom:{room_id?}/{user_id?}', [App\Http\Controllers\RoomController::class, 'getPostRoom'])->name('getPostRoom');
    Route::get('/getListUser:{favorite_user_id?}/{user_id?}', [App\Http\Controllers\UserController::class, 'getListUser'])->name('getListUser');
    Route::get('/getListRoom:{room_id?}/{user_id?}', [App\Http\Controllers\RoomController::class, 'getListRoom'])->name('getListRoom');
    Route::get('/home/searchUser', [App\Http\Controllers\UserController::class, 'searchUser'])->name('searchUser');
    Route::post('/home/searchRoom', [App\Http\Controllers\RoomController::class, 'searchRoom'])->name('searchRoom');

});


