<?php 
namespace App\Http\Composers;

use illuminate\View\View;
use App\Http\Controllers\TagController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;

class WitViewComposer
{

    /**
     * @param View $view
     * @return void
     */


    public function compose(View $view)
    {
        $trend_tags = TagController::getTrend();
        $post_rooms = RoomController::getPostRoom();
        
        $list_rooms = RoomController::getListRoom();
        $list_users = UserController::getListUser();
        $rooms = RoomController::getRoomInfo();
        $view->with('rooms', $rooms);
        $view->with('trend_tags' , $trend_tags);
        $view->with('post_rooms' , $post_rooms);
        $view->with('list_rooms' , $list_rooms);
        $view->with('list_users' , $list_users);
    }
}