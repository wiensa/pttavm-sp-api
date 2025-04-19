<?php

namespace PttavmApi\PttavmSpApi\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \PttavmApi\PttavmSpApi\Services\ProductService product()
 * @method static \PttavmApi\PttavmSpApi\Services\OrderService order()
 * @method static \PttavmApi\PttavmSpApi\Services\CategoryService category()
 * @method static \PttavmApi\PttavmSpApi\Services\ShippingService shipping()
 * @method static \PttavmApi\PttavmSpApi\Services\VariantService variant()
 * @method static \PttavmApi\PttavmSpApi\Services\CommissionService commission()
 * @method static \PttavmApi\PttavmSpApi\Services\BrandService brand()
 * @method static \PttavmApi\PttavmSpApi\Services\ReportService report()
 * @method static \PttavmApi\PttavmSpApi\Services\StoreService store()
 * @method static \PttavmApi\PttavmSpApi\Contracts\ApiServiceInterface api()
 * 
 * @see \PttavmApi\PttavmSpApi\Services\PttAvm
 */
class PttAvm extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'pttavm';
    }
}
