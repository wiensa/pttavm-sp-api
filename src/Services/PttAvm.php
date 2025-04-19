<?php

namespace PttavmApi\PttavmSpApi\Services;

use PttavmApi\PttavmSpApi\Contracts\ApiServiceInterface;

class PttAvm
{
    /**
     * API servisi
     *
     * @var \PttavmApi\PttavmSpApi\Contracts\ApiServiceInterface
     */
    protected ApiServiceInterface $api;

    /**
     * PttAvm constructor.
     *
     * @param \PttavmApi\PttavmSpApi\Contracts\ApiServiceInterface $api
     */
    public function __construct(ApiServiceInterface $api)
    {
        $this->api = $api;
    }

    /**
     * Ürün servisi örneğini döndürür.
     *
     * @return \PttavmApi\PttavmSpApi\Services\ProductService
     */
    public function product(): ProductService
    {
        return app('pttavm.product');
    }

    /**
     * Sipariş servisi örneğini döndürür.
     *
     * @return \PttavmApi\PttavmSpApi\Services\OrderService
     */
    public function order(): OrderService
    {
        return app('pttavm.order');
    }

    /**
     * Kategori servisi örneğini döndürür.
     *
     * @return \PttavmApi\PttavmSpApi\Services\CategoryService
     */
    public function category(): CategoryService
    {
        return app('pttavm.category');
    }

    /**
     * Kargo servisi örneğini döndürür.
     *
     * @return \PttavmApi\PttavmSpApi\Services\ShippingService
     */
    public function shipping(): ShippingService
    {
        return app('pttavm.shipping');
    }

    /**
     * Varyant servisi örneğini döndürür.
     *
     * @return \PttavmApi\PttavmSpApi\Services\VariantService
     */
    public function variant(): VariantService
    {
        return app('pttavm.variant');
    }

    /**
     * Komisyon servisi örneğini döndürür.
     *
     * @return \PttavmApi\PttavmSpApi\Services\CommissionService
     */
    public function commission(): CommissionService
    {
        return app('pttavm.commission');
    }

    /**
     * Marka servisi örneğini döndürür.
     *
     * @return \PttavmApi\PttavmSpApi\Services\BrandService
     */
    public function brand(): BrandService
    {
        return app('pttavm.brand');
    }

    /**
     * Rapor servisi örneğini döndürür.
     *
     * @return \PttavmApi\PttavmSpApi\Services\ReportService
     */
    public function report(): ReportService
    {
        return app('pttavm.report');
    }

    /**
     * Mağaza servisi örneğini döndürür.
     *
     * @return \PttavmApi\PttavmSpApi\Services\StoreService
     */
    public function store(): StoreService
    {
        return app('pttavm.store');
    }

    /**
     * API servisi örneğini döndürür.
     *
     * @return \PttavmApi\PttavmSpApi\Contracts\ApiServiceInterface
     */
    public function api(): ApiServiceInterface
    {
        return $this->api;
    }
} 