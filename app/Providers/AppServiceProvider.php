<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Barangay;   // ✅ correct namespace for model
use App\Models\Disease;    // ✅ same here

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

   public function boot()
        {
            View::composer(['dashboard', 'superadmin.*'], function ($view) {
                $view->with('barangays', Barangay::all());
                $view->with('diseases', Disease::all());
            });
        }
}
