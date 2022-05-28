<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::Composer(['wit.tags','wit.home-modals'],'App\Http\Composers\WitViewComposer');
        //View::composer > View::creator > view呼び出し時の引数(Controller)　の優先順位で変数渡される
    }
}
