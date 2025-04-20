<?php

namespace PttavmApi\PttavmSpApi\Tests\Unit;

use PHPUnit\Framework\TestCase;
use PttavmApi\PttavmSpApi\Contracts\ApiServiceInterface;
use PttavmApi\PttavmSpApi\Services\OrderService;

class OrderServiceTest extends TestCase
{
    private $apiService;
    private $orderService;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        // Mock ApiServiceInterface
        $this->apiService = $this->createMock(ApiServiceInterface::class);
        $this->orderService = new OrderService($this->apiService);
    }
    
    public function testGetList(): void
    {
        $filters = [
            'status' => 'waiting',
            'start_date' => '2023-01-01',
            'end_date' => '2023-01-31',
            'page' => 1,
            'limit' => 10,
        ];
        
        $expectedResponse = [
            'status' => 'success',
            'message' => 'İşlem başarılı',
            'data' => [
                'orders' => [
                    [
                        'order_number' => 'ORDER123',
                        'status' => 'waiting',
                        'created_at' => '2023-01-15',
                    ],
                ],
                'total' => 1,
                'page' => 1,
                'limit' => 10,
            ],
        ];
        
        $this->apiService
            ->expects($this->once())
            ->method('get')
            ->with('order/list', $filters)
            ->willReturn($expectedResponse);
        
        $result = $this->orderService->getList($filters);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testGetDetail(): void
    {
        $orderNumber = 'ORDER123';
        
        $expectedResponse = [
            'status' => 'success',
            'message' => 'İşlem başarılı',
            'data' => [
                'order' => [
                    'order_number' => 'ORDER123',
                    'status' => 'waiting',
                    'created_at' => '2023-01-15',
                    'items' => [
                        [
                            'barcode' => '1234567890123',
                            'title' => 'Test Ürün',
                            'quantity' => 1,
                            'price' => 100.00,
                        ],
                    ],
                ],
            ],
        ];
        
        $this->apiService
            ->expects($this->once())
            ->method('get')
            ->with('order/detail', ['order_number' => $orderNumber])
            ->willReturn($expectedResponse);
        
        $result = $this->orderService->getDetail($orderNumber);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testApprove(): void
    {
        $orderNumber = 'ORDER123';
        
        $expectedResponse = [
            'status' => 'success',
            'message' => 'Sipariş başarıyla onaylandı',
        ];
        
        $this->apiService
            ->expects($this->once())
            ->method('put')
            ->with('order/approve', ['order_number' => $orderNumber])
            ->willReturn($expectedResponse);
        
        $result = $this->orderService->approve($orderNumber);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testReject(): void
    {
        $orderNumber = 'ORDER123';
        $reason = 'Stokta yok';
        
        $expectedResponse = [
            'status' => 'success',
            'message' => 'Sipariş başarıyla reddedildi',
        ];
        
        $this->apiService
            ->expects($this->once())
            ->method('put')
            ->with('order/reject', [
                'order_number' => $orderNumber,
                'reason' => $reason,
            ])
            ->willReturn($expectedResponse);
        
        $result = $this->orderService->reject($orderNumber, $reason);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testUpdateShipment(): void
    {
        $orderNumber = 'ORDER123';
        $trackingNumber = 'TRACK123';
        $shippingCompany = 'PTT Kargo';
        
        $expectedResponse = [
            'status' => 'success',
            'message' => 'Kargo bilgileri başarıyla güncellendi',
        ];
        
        $this->apiService
            ->expects($this->once())
            ->method('put')
            ->with('order/shipment/update', [
                'order_number' => $orderNumber,
                'tracking_number' => $trackingNumber,
                'shipping_company' => $shippingCompany,
            ])
            ->willReturn($expectedResponse);
        
        $result = $this->orderService->updateShipment($orderNumber, $trackingNumber, $shippingCompany);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testUpdateShipmentWithoutCompany(): void
    {
        $orderNumber = 'ORDER123';
        $trackingNumber = 'TRACK123';
        
        $expectedResponse = [
            'status' => 'success',
            'message' => 'Kargo bilgileri başarıyla güncellendi',
        ];
        
        $this->apiService
            ->expects($this->once())
            ->method('put')
            ->with('order/shipment/update', [
                'order_number' => $orderNumber,
                'tracking_number' => $trackingNumber,
            ])
            ->willReturn($expectedResponse);
        
        $result = $this->orderService->updateShipment($orderNumber, $trackingNumber);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testRequestCancel(): void
    {
        $orderNumber = 'ORDER123';
        $reason = 'Müşteri talebi';
        
        $expectedResponse = [
            'status' => 'success',
            'message' => 'İptal talebi başarıyla oluşturuldu',
        ];
        
        $this->apiService
            ->expects($this->once())
            ->method('put')
            ->with('order/cancel/request', [
                'order_number' => $orderNumber,
                'reason' => $reason,
            ])
            ->willReturn($expectedResponse);
        
        $result = $this->orderService->requestCancel($orderNumber, $reason);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testRequestReturn(): void
    {
        $orderNumber = 'ORDER123';
        $reason = 'Ürün hasarlı';
        
        $expectedResponse = [
            'status' => 'success',
            'message' => 'İade talebi başarıyla oluşturuldu',
        ];
        
        $this->apiService
            ->expects($this->once())
            ->method('put')
            ->with('order/return/request', [
                'order_number' => $orderNumber,
                'reason' => $reason,
            ])
            ->willReturn($expectedResponse);
        
        $result = $this->orderService->requestReturn($orderNumber, $reason);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testApproveReturn(): void
    {
        $orderNumber = 'ORDER123';
        
        $expectedResponse = [
            'status' => 'success',
            'message' => 'İade talebi başarıyla onaylandı',
        ];
        
        $this->apiService
            ->expects($this->once())
            ->method('put')
            ->with('order/return/approve', [
                'order_number' => $orderNumber,
            ])
            ->willReturn($expectedResponse);
        
        $result = $this->orderService->approveReturn($orderNumber);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testRejectReturn(): void
    {
        $orderNumber = 'ORDER123';
        $reason = 'Ürün kullanılmış';
        
        $expectedResponse = [
            'status' => 'success',
            'message' => 'İade talebi başarıyla reddedildi',
        ];
        
        $this->apiService
            ->expects($this->once())
            ->method('put')
            ->with('order/return/reject', [
                'order_number' => $orderNumber,
                'reason' => $reason,
            ])
            ->willReturn($expectedResponse);
        
        $result = $this->orderService->rejectReturn($orderNumber, $reason);
        
        $this->assertEquals($expectedResponse, $result);
    }
    
    public function testUpdateNotes(): void
    {
        $orderNumber = 'ORDER123';
        $notes = 'Müşteri ile iletişime geçildi.';
        
        $expectedResponse = [
            'status' => 'success',
            'message' => 'Sipariş notları başarıyla güncellendi',
        ];
        
        $this->apiService
            ->expects($this->once())
            ->method('put')
            ->with('order/notes/update', [
                'order_number' => $orderNumber,
                'notes' => $notes,
            ])
            ->willReturn($expectedResponse);
        
        $result = $this->orderService->updateNotes($orderNumber, $notes);
        
        $this->assertEquals($expectedResponse, $result);
    }
} 