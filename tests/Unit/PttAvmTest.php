<?php

namespace PttavmApi\PttavmSpApi\Tests\Unit;

use PHPUnit\Framework\TestCase;
use PttavmApi\PttavmSpApi\Contracts\ApiServiceInterface;
use PttavmApi\PttavmSpApi\Services\PttAvm;
use PttavmApi\PttavmSpApi\Services\ProductService;
use PttavmApi\PttavmSpApi\Services\OrderService;
use PttavmApi\PttavmSpApi\Services\CategoryService;
use PttavmApi\PttavmSpApi\Services\ShippingService;
use PttavmApi\PttavmSpApi\Services\VariantService;
use PttavmApi\PttavmSpApi\Services\CommissionService;
use PttavmApi\PttavmSpApi\Services\BrandService;
use PttavmApi\PttavmSpApi\Services\ReportService;
use PttavmApi\PttavmSpApi\Services\StoreService;

use GuzzleHttp\Client;

class PttAvmTest extends TestCase
{
    private $apiService;
    private $pttAvm;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        // Mock ApiServiceInterface
        $this->apiService = $this->createMock(ApiServiceInterface::class);
        
        // Mock service sınıfları için app() fonksiyonunu taklit edelim
        $GLOBALS['pttavm_services'] = [
            'pttavm.product' => $this->createMock(ProductService::class),
            'pttavm.order' => $this->createMock(OrderService::class),
            'pttavm.category' => $this->createMock(CategoryService::class),
            'pttavm.shipping' => $this->createMock(ShippingService::class),
            'pttavm.variant' => $this->createMock(VariantService::class),
            'pttavm.commission' => $this->createMock(CommissionService::class),
            'pttavm.brand' => $this->createMock(BrandService::class),
            'pttavm.report' => $this->createMock(ReportService::class),
            'pttavm.store' => $this->createMock(StoreService::class),
        ];
        
        if (!function_exists('app')) {
            function app($service = null) {
                if ($service === null) {
                    return null;
                }
                
                return $GLOBALS['pttavm_services'][$service] ?? null;
            }
        }
        
        $this->pttAvm = new PttAvm($this->apiService);
    }
    
    protected function tearDown(): void
    {
        parent::tearDown();
        unset($GLOBALS['pttavm_services']);
    }
    
    public function testGetApiService(): void
    {
        $this->assertSame($this->apiService, $this->pttAvm->getApiService());
    }
    
    public function testGetHttpClient(): void
    {
        $client = $this->createMock(Client::class);
        
        $this->apiService
            ->expects($this->once())
            ->method('getClient')
            ->willReturn($client);
        
        $this->assertSame($client, $this->pttAvm->getHttpClient());
    }
    
    public function testProducts(): void
    {
        $productService = $this->pttAvm->products();
        $this->assertInstanceOf(ProductService::class, $productService);
        // İkinci çağrıda aynı örneğin dönmesi gerekir (önbellekleme)
        $this->assertSame($productService, $this->pttAvm->products());
    }
    
    public function testOrders(): void
    {
        $orderService = $this->pttAvm->orders();
        $this->assertInstanceOf(OrderService::class, $orderService);
        // İkinci çağrıda aynı örneğin dönmesi gerekir (önbellekleme)
        $this->assertSame($orderService, $this->pttAvm->orders());
    }
    
    public function testCategories(): void
    {
        $categoryService = $this->pttAvm->categories();
        $this->assertInstanceOf(CategoryService::class, $categoryService);
        // İkinci çağrıda aynı örneğin dönmesi gerekir (önbellekleme)
        $this->assertSame($categoryService, $this->pttAvm->categories());
    }
    
    public function testShipping(): void
    {
        $shippingService = $this->pttAvm->shipping();
        $this->assertInstanceOf(ShippingService::class, $shippingService);
        // İkinci çağrıda aynı örneğin dönmesi gerekir (önbellekleme)
        $this->assertSame($shippingService, $this->pttAvm->shipping());
    }
    
    public function testVariants(): void
    {
        $variantService = $this->pttAvm->variants();
        $this->assertInstanceOf(VariantService::class, $variantService);
        // İkinci çağrıda aynı örneğin dönmesi gerekir (önbellekleme)
        $this->assertSame($variantService, $this->pttAvm->variants());
    }
    
    public function testCommissions(): void
    {
        $commissionService = $this->pttAvm->commissions();
        $this->assertInstanceOf(CommissionService::class, $commissionService);
        // İkinci çağrıda aynı örneğin dönmesi gerekir (önbellekleme)
        $this->assertSame($commissionService, $this->pttAvm->commissions());
    }
    
    public function testBrands(): void
    {
        $brandService = $this->pttAvm->brands();
        $this->assertInstanceOf(BrandService::class, $brandService);
        // İkinci çağrıda aynı örneğin dönmesi gerekir (önbellekleme)
        $this->assertSame($brandService, $this->pttAvm->brands());
    }
    
    public function testReports(): void
    {
        $reportService = $this->pttAvm->reports();
        $this->assertInstanceOf(ReportService::class, $reportService);
        // İkinci çağrıda aynı örneğin dönmesi gerekir (önbellekleme)
        $this->assertSame($reportService, $this->pttAvm->reports());
    }
    
    public function testStores(): void
    {
        $storeService = $this->pttAvm->stores();
        $this->assertInstanceOf(StoreService::class, $storeService);
        // İkinci çağrıda aynı örneğin dönmesi gerekir (önbellekleme)
        $this->assertSame($storeService, $this->pttAvm->stores());
    }
} 