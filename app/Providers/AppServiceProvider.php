<?php

namespace App\Providers;

use App\Models\Invoice;
use App\Models\Setting;
use App\Models\User;
use App\Observers\InvoiceObserver;
use Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        Schema::defaultStringLength(191);
        View()->share([
          'setting' => auth('auction')->check() 
          ? Setting::where('auction_id' , auth('auction')->user()->id)->first() 
          : Setting::where('auction_id' , null)->first(),
          //'user'    => User::where('id', auth()->user()->id)->first()
        ]);
        
        Paginator::useBootstrap();
        Invoice::observe(InvoiceObserver::class);
    }
    
}
