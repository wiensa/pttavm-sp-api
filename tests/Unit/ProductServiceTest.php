<?php

namespace PttavmApi\PttavmSpApi\Tests\Unit;

use PHPUnit\Framework\TestCase;
use PttavmApi\PttavmSpApi\Contracts\ApiServiceInterface;
use PttavmApi\PttavmSpApi\Exceptions\PttAvmException;
use PttavmApi\PttavmSpApi\Services\ProductService;

class ProductServiceTest extends TestCase
{
    private $apiService;
    private $productService;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        // Mock ApiServiceInterface
        $this->apiService = $this->createMock(ApiServiceInterface::class);
        $this->productService = new ProductService($this->apiService);
    }
    
    public function testCreate(): void
    {
        $productData = [
            'barcode' => '1234567890123',
            'title' => 'Test Ürün',
            'price' => 100.00,
            'stock' => 10,
            'category_id' => 123,
            'description' => 'Test ürün açıklaması',
        ];
        
        $expectedResponse = [
            'status' => 'success',
            'message' => 'Ürün başarıyla oluşturuldu',
            'data' => [
                'product_id' => 1,
                'barcode' => '1234567890123',
            ],
        ];
        
        $this->apiService
            ->expects($this->once())
            ->method('post')
            ->with('product/create', $productData)
            ->willReturn($expectedResponse);
        
        $result = $this->productService->create($productData);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testCreateWithMissingRequiredFields(): void
    {
        $this->expectException(PttAvmException::class);
        
        $invalidProductData = [
            'title' => 'Test Ürün',
            'price' => 100.00,
            // barcode, stock ve category_id eksik
        ];
        
        $this->productService->create($invalidProductData);
    }
    
    public function testUpdate(): void
    {
        $productData = [
            'barcode' => '1234567890123',
            'title' => 'Güncellenmiş Ürün',
            'price' => 150.00,
        ];
        
        $expectedResponse = [
            'status' => 'success',
            'message' => 'Ürün başarıyla güncellendi',
            'data' => [
                'barcode' => '1234567890123',
            ],
        ];
        
        $this->apiService
            ->expects($this->once())
            ->method('put')
            ->with('product/update', $productData)
            ->willReturn($expectedResponse);
        
        $result = $this->productService->update($productData);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testUpdateWithMissingBarcode(): void
    {
        $this->expectException(PttAvmException::class);
        
        $invalidProductData = [
            'title' => 'Güncellenmiş Ürün',
            'price' => 150.00,
            // barcode eksik
        ];
        
        $this->productService->update($invalidProductData);
    }
    
    public function testUpdatePrice(): void
    {
        $barcode = '1234567890123';
        $price = 199.99;
        
        $expectedResponse = [
            'status' => 'success',
            'message' => 'Ürün fiyatı başarıyla güncellendi',
        ];
        
        $this->apiService
            ->expects($this->once())
            ->method('put')
            ->with('product/update/price', [
                'barcode' => $barcode,
                'price' => $price,
            ])
            ->willReturn($expectedResponse);
        
        $result = $this->productService->updatePrice($barcode, $price);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testUpdateStock(): void
    {
        $barcode = '1234567890123';
        $stock = 25;
        
        $expectedResponse = [
            'status' => 'success',
            'message' => 'Ürün stoğu başarıyla güncellendi',
        ];
        
        $this->apiService
            ->expects($this->once())
            ->method('put')
            ->with('product/update/stock', [
                'barcode' => $barcode,
                'stock' => $stock,
            ])
            ->willReturn($expectedResponse);
        
        $result = $this->productService->updateStock($barcode, $stock);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testBatchUpdate(): void
    {
        $products = [
            [
                'barcode' => '1234567890123',
                'price' => 99.99,
                'stock' => 5,
            ],
            [
                'barcode' => '1234567890124',
                'price' => 149.99,
                'stock' => 10,
            ],
        ];
        
        $expectedResponse = [
            'status' => 'success',
            'message' => 'Ürünler başarıyla güncellendi',
        ];
        
        $this->apiService
            ->expects($this->once())
            ->method('put')
            ->with('product/batch/update', ['products' => $products])
            ->willReturn($expectedResponse);
        
        $result = $this->productService->batchUpdate($products);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetDetail(): void
    {
        $barcode = '1234567890123';
        
        $expectedResponse = [
            'status' => 'success',
            'message' => 'İşlem başarılı',
            'data' => [
                'product' => [
                    'barcode' => '1234567890123',
                    'title' => 'Test Ürün',
                    'price' => 100.00,
                    'stock' => 10,
                    'category_id' => 123,
                ],
            ],
        ];
        
        $this->apiService
            ->expects($this->once())
            ->method('get')
            ->with('product/detail', ['barcode' => $barcode])
            ->willReturn($expectedResponse);
        
        $result = $this->productService->getDetail($barcode);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetList(): void
    {
        $filters = [
            'status' => 'active',
            'page' => 1,
            'limit' => 10,
        ];
        
        $expectedResponse = [
            'status' => 'success',
            'message' => 'İşlem başarılı',
            'data' => [
                'products' => [
                    [
                        'barcode' => '1234567890123',
                        'title' => 'Test Ürün 1',
                    ],
                    [
                        'barcode' => '1234567890124',
                        'title' => 'Test Ürün 2',
                    ],
                ],
                'total' => 2,
                'page' => 1,
                'limit' => 10,
            ],
        ];
        
        $this->apiService
            ->expects($this->once())
            ->method('get')
            ->with('product/list', $filters)
            ->willReturn($expectedResponse);
        
        $result = $this->productService->getList($filters);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testDeactivate(): void
    {
        $barcode = '1234567890123';
        
        $expectedResponse = [
            'status' => 'success',
            'message' => 'Ürün pasif duruma getirildi',
        ];
        
        $this->apiService
            ->expects($this->once())
            ->method('put')
            ->with('product/deactivate', ['barcode' => $barcode])
            ->willReturn($expectedResponse);
        
        $result = $this->productService->deactivate($barcode);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testActivate(): void
    {
        $barcode = '1234567890123';
        
        $expectedResponse = [
            'status' => 'success',
            'message' => 'Ürün aktif duruma getirildi',
        ];
        
        $this->apiService
            ->expects($this->once())
            ->method('put')
            ->with('product/activate', ['barcode' => $barcode])
            ->willReturn($expectedResponse);
        
        $result = $this->productService->activate($barcode);
        
        $this->assertEquals($expectedResponse, $result);
    }
} 