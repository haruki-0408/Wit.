<?php 
namespace App\Http\Composers;

use illuminate\View\View;
use App\Http\Controllers\TagController;
use App\Http\Controllers\RoomController;

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
        $view->with('trend_tags' , $trend_tags);
        $view->with('post_rooms' , $post_rooms);
    }
}