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
        View::Composer('wit.home','App\Http\Composers\WitViewComposer');
        View::Composer('wit.profile','App\Http\Composers\WitViewComposer');
        View::Composer('wit.Account.information-account','App\Http\Composers\WitViewComposer');
        View::Composer('wit.Account.delete-account','App\Http\Composers\WitViewComposer');
    }
}
