<?php

namespace PttavmApi\PttavmSpApi\Services;

use PttavmApi\PttavmSpApi\Contracts\ApiServiceInterface;

/**
 * @method ProductService products()
 * @method OrderService orders()
 * @method CategoryService categories()
 * @method ShippingService shipping()
 * @method VariantService variants()
 * @method CommissionService commissions()
 * @method BrandService brands()
 * @method ReportService reports()
 * @method StoreService stores()
 */
class PttAvm
{
    /**
     * API servisi
     *
     * @var \PttavmApi\PttavmSpApi\Contracts\ApiServiceInterface
     */
    protected ApiServiceInterface $api;

    /**
     * Servis örnekleri
     *
     * @var array
     */
    protected array $services = [];

    /**
     * PttAvmApi constructor.
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
    public function products(): ProductService
    {
        if (!isset($this->services['product'])) {
            $this->services['product'] = app('pttavm.product');
        }
        
        return $this->services['product'];
    }

    /**
     * Sipariş servisi örneğini döndürür.
     *
     * @return \PttavmApi\PttavmSpApi\Services\OrderService
     */
    public function orders(): OrderService
    {
        if (!isset($this->services['order'])) {
            $this->services['order'] = app('pttavm.order');
        }
        
        return $this->services['order'];
    }

    /**
     * Kategori servisi örneğini döndürür.
     *
     * @return \PttavmApi\PttavmSpApi\Services\CategoryService
     */
    public function categories(): CategoryService
    {
        if (!isset($this->services['category'])) {
            $this->services['category'] = app('pttavm.category');
        }
        
        return $this->services['category'];
    }

    /**
     * Kargo servisi örneğini döndürür.
     *
     * @return \PttavmApi\PttavmSpApi\Services\ShippingService
     */
    public function shipping(): ShippingService
    {
        if (!isset($this->services['shipping'])) {
            $this->services['shipping'] = app('pttavm.shipping');
        }
        
        return $this->services['shipping'];
    }

    /**
     * Varyant servisi örneğini döndürür.
     *
     * @return \PttavmApi\PttavmSpApi\Services\VariantService
     */
    public function variants(): VariantService
    {
        if (!isset($this->services['variant'])) {
            $this->services['variant'] = app('pttavm.variant');
        }
        
        return $this->services['variant'];
    }

    /**
     * Komisyon servisi örneğini döndürür.
     *
     * @return \PttavmApi\PttavmSpApi\Services\CommissionService
     */
    public function commissions(): CommissionService
    {
        if (!isset($this->services['commission'])) {
            $this->services['commission'] = app('pttavm.commission');
        }
        
        return $this->services['commission'];
    }

    /**
     * Marka servisi örneğini döndürür.
     *
     * @return \PttavmApi\PttavmSpApi\Services\BrandService
     */
    public function brands(): BrandService
    {
        if (!isset($this->services['brand'])) {
            $this->services['brand'] = app('pttavm.brand');
        }
        
        return $this->services['brand'];
    }

    /**
     * Rapor servisi örneğini döndürür.
     *
     * @return \PttavmApi\PttavmSpApi\Services\ReportService
     */
    public function reports(): ReportService
    {
        if (!isset($this->services['report'])) {
            $this->services['report'] = app('pttavm.report');
        }
        
        return $this->services['report'];
    }

    /**
     * Mağaza servisi örneğini döndürür.
     *
     * @return \PttavmApi\PttavmSpApi\Services\StoreService
     */
    public function stores(): StoreService
    {
        if (!isset($this->services['store'])) {
            $this->services['store'] = app('pttavm.store');
        }
        
        return $this->services['store'];
    }

    /**
     * API servisini döndürür.
     *
     * @return \PttavmApi\PttavmSpApi\Contracts\ApiServiceInterface
     */
    public function getApiService(): ApiServiceInterface
    {
        return $this->api;
    }
    
    /**
     * HTTP istemcisini döndürür.
     *
     * @return \GuzzleHttp\Client
     */
    public function getHttpClient()
    {
        return $this->api->getClient();
    }
} 