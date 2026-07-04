<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * AppServiceProvider - مزود خدمات التطبيق الأساسي.
 *
 * يُهيئ الإعدادات المشتركة بين جميع العروض (Views)
 * ويضبط إعدادات CORS في بيئة التطوير.
 */
class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (env('APP_ENV') !== 'production') {
            $this->app->make('config')->set('cors.supports_credentials', true);
        }

        try {
            $settings = \App\Models\Setting::first();
            \Illuminate\Support\Facades\View::share('settings', $settings);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\View::share('settings', null);
        }
    }
}
