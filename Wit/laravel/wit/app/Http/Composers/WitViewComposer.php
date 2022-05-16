<?php 
namespace App\Http\Composers;

use illuminate\View\View;
use App\Http\Controllers\TagController;

class WitViewComposer
{

    /**
     * @param View $view
     * @return void
     */


    public function compose(View $view)
    {
        $trend_tags = TagController::getTrend();
        $view->with('trend_tags' , $trend_tags);
    }
}