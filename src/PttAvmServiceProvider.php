<?php

namespace PttavmApi\PttavmSpApi;

use Illuminate\Support\ServiceProvider;
use PttavmApi\PttavmSpApi\Services\ApiService;
use PttavmApi\PttavmSpApi\Services\BrandService;
use PttavmApi\PttavmSpApi\Services\CategoryService;
use PttavmApi\PttavmSpApi\Services\CommissionService;
use PttavmApi\PttavmSpApi\Services\OrderService;
use PttavmApi\PttavmSpApi\Services\ProductService;
use PttavmApi\PttavmSpApi\Services\PttAvm;
use PttavmApi\PttavmSpApi\Services\ReportService;
use PttavmApi\PttavmSpApi\Services\ShippingService;
use PttavmApi\PttavmSpApi\Services\StoreService;
use PttavmApi\PttavmSpApi\Services\VariantService;

class PttAvmServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/pttavm.php' => config_path('pttavm.php'),
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/pttavm.php', 'pttavm');

        // API servisini kaydet
        $this->app->singleton('pttavm.api', function () {
            return new ApiService(
                config('pttavm.username'),
                config('pttavm.password'),
                config('pttavm.shop_id'),
                config('pttavm.api_url'),
                config('pttavm.timeout', 30),
                config('pttavm.debug', false)
            );
        });

        // PttAvmApi'yi kaydet
        $this->app->singleton('pttavm', function ($app) {
            return new PttAvmApi($app->make('pttavm.api'));
        });

        // Diğer servisleri kaydet
        $this->app->singleton('pttavm.product', function ($app) {
            return new ProductService($app->make('pttavm.api'));
        });

        $this->app->singleton('pttavm.order', function ($app) {
            return new OrderService($app->make('pttavm.api'));
        });

        $this->app->singleton('pttavm.category', function ($app) {
            return new CategoryService($app->make('pttavm.api'));
        });

        $this->app->singleton('pttavm.shipping', function ($app) {
            return new ShippingService($app->make('pttavm.api'));
        });

        $this->app->singleton('pttavm.variant', function ($app) {
            return new VariantService($app->make('pttavm.api'));
        });

        $this->app->singleton('pttavm.commission', function ($app) {
            return new CommissionService($app->make('pttavm.api'));
        });

        $this->app->singleton('pttavm.brand', function ($app) {
            return new BrandService($app->make('pttavm.api'));
        });

        $this->app->singleton('pttavm.report', function ($app) {
            return new ReportService($app->make('pttavm.api'));
        });

        $this->app->singleton('pttavm.store', function ($app) {
            return new StoreService($app->make('pttavm.api'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<string>
     */
    public function provides(): array
    {
        return [
            'pttavm',
            'pttavm.api',
            'pttavm.product',
            'pttavm.order',
            'pttavm.category',
            'pttavm.shipping',
            'pttavm.variant',
            'pttavm.commission',
            'pttavm.brand',
            'pttavm.report',
            'pttavm.store',
        ];
    }
}
