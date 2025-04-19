<?php

namespace PttavmApi\PttavmSpApi;

use Illuminate\Support\ServiceProvider;
use PttavmApi\PttavmSpApi\Services\ApiService;
use PttavmApi\PttavmSpApi\Services\ProductService;
use PttavmApi\PttavmSpApi\Services\OrderService;
use PttavmApi\PttavmSpApi\Services\CategoryService;
use PttavmApi\PttavmSpApi\Services\ShippingService;
use PttavmApi\PttavmSpApi\Services\VariantService;
use PttavmApi\PttavmSpApi\Services\CommissionService;
use PttavmApi\PttavmSpApi\Services\BrandService;
use PttavmApi\PttavmSpApi\Services\ReportService;
use PttavmApi\PttavmSpApi\Services\StoreService;
use PttavmApi\PttavmSpApi\Services\PttAvm;

class PttAvmServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        // Publish config
        $this->publishes([
            __DIR__ . '/../config/pttavm.php' => config_path('pttavm.php'),
        ], 'config');
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        // Merge config
        $this->mergeConfigFrom(__DIR__ . '/../config/pttavm.php', 'pttavm');

        // Register ApiService
        $this->app->singleton('pttavm.api', function ($app) {
            return new ApiService(
                config('pttavm.username'),
                config('pttavm.password'),
                config('pttavm.shop_id'),
                config('pttavm.api_url'),
                config('pttavm.timeout'),
                config('pttavm.debug')
            );
        });

        // Register PttAvm main service
        $this->app->singleton('pttavm', function ($app) {
            return new PttAvm($app['pttavm.api']);
        });

        // Register Service modules
        $this->app->bind('pttavm.product', function ($app) {
            return new ProductService($app['pttavm.api']);
        });

        $this->app->bind('pttavm.order', function ($app) {
            return new OrderService($app['pttavm.api']);
        });

        $this->app->bind('pttavm.category', function ($app) {
            return new CategoryService($app['pttavm.api']);
        });

        $this->app->bind('pttavm.shipping', function ($app) {
            return new ShippingService($app['pttavm.api']);
        });

        // Register new service modules
        $this->app->bind('pttavm.variant', function ($app) {
            return new VariantService($app['pttavm.api']);
        });

        $this->app->bind('pttavm.commission', function ($app) {
            return new CommissionService($app['pttavm.api']);
        });

        $this->app->bind('pttavm.brand', function ($app) {
            return new BrandService($app['pttavm.api']);
        });

        $this->app->bind('pttavm.report', function ($app) {
            return new ReportService($app['pttavm.api']);
        });

        $this->app->bind('pttavm.store', function ($app) {
            return new StoreService($app['pttavm.api']);
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
