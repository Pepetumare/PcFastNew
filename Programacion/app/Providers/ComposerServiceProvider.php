<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class ComposerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer(['layouts.guest', 'layouts.navigation'], function ($view) {
            $logoPath = Cache::rememberForever('logo_path', function () {
                return DB::table('settings')->where('key', 'logo_path')->value('value');
            });
            $view->with('logoPath', $logoPath);
        });
    }
}
