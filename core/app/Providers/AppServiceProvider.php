<?php

namespace App\Providers;

use App\Models\Frontend;
use App\Models\GeneralSetting;
use App\Models\Language;
use App\Models\Page;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        $activeTemplate = activeTemplate();
        $general = GeneralSetting::first();
        $viewShare['general'] = $general;
        $viewShare['activeTemplate'] = $activeTemplate;
        $viewShare['activeTemplateTrue'] = activeTemplate(true);
        $viewShare['language'] = Language::all();
        $viewShare['pages'] = Page::where('tempname',$activeTemplate)->where('slug','!=','home')->get();
        view()->share($viewShare);

        view()->composer('partials.seo', function ($view) {
            $seo = Frontend::where('data_keys', 'seo.data')->first();
            $view->with([
                'seo' => $seo ? $seo->data_values : $seo,
            ]);
        });

        $policy_pages  = Frontend::where('data_keys', 'policy_pages.element')->get();
        view()->composer([$activeTemplate.'partials.footer'], function ($view) use($policy_pages){
            $view->with([
                'policy_pages' => $policy_pages
            ]);
        });

        if($general->force_ssl){
            \URL::forceScheme('https');
        }

    }
}
