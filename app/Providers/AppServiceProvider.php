<?php

namespace App\Providers;

use App\Models\Inventory\ItemIncomingDetail;
use App\Models\Master\IngradiantDetail;
use App\Models\POS\SaleDetail;
use App\Models\Sistem\Company;
use App\Observers\CompanyObserver;
use App\Observers\Inventory\ItemIncomingDetailObserver;
use App\Observers\Master\IngradiantDetailObserver;
use App\Observers\Pos\SaleDetailObserver;
use Carbon\Carbon;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(UrlGenerator $url): void
    {
        if(session()->get('applocale') != null){
            Carbon::setLocale(session()->get('applocale'));
        }else{
            Carbon::setLocale('id');
        }

        if (env('APP_FORCE_TLS')) {
            if (strpos(env('APP_URL'), 'https') === 0) {
                $url->forceScheme('https');
            } else {
                Log::debug("'APP_FORCE_TLS' is set to true, but 'APP_URL' does not start with 'https://'. Will not force TLS on connections.");
            }
        }

        // TODO - isn't it somehow 'gauche' to check the environment directly; shouldn't we be using config() somehow?
        if ( ! env('APP_ALLOW_INSECURE_HOSTS')) {  // unless you set APP_ALLOW_INSECURE_HOSTS, you should PROHIBIT forging domain parts of URL via Host: headers
            $url_parts = parse_url(config('app.url'));
            if ($url_parts && array_key_exists('scheme', $url_parts) && array_key_exists('host', $url_parts)) { // check for the *required* parts of a bare-minimum URL
                URL::forceRootUrl(config('app.url'));
            } else {
                Log::error("Your APP_URL in your .env is misconfigured - it is: ".config('app.url').". Many things will work strangely unless you fix it.");
            }
        }

        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        \Illuminate\Pagination\Paginator::useBootstrap();

        Schema::defaultStringLength(191);
        Blade::withoutDoubleEncoding();

        //Observer
        Company::observe(CompanyObserver::class);

        //Master
        IngradiantDetail::observe(IngradiantDetailObserver::class);

        //POS
        SaleDetail::observe(SaleDetailObserver::class);

        //Inventory
        ItemIncomingDetail::observe(ItemIncomingDetailObserver::class);
    }
}
