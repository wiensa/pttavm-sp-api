<?php

namespace PttavmApi\PttavmSpApi\Tests\Unit;

use PHPUnit\Framework\TestCase;
use PttavmApi\PttavmSpApi\Contracts\ApiServiceInterface;
use PttavmApi\PttavmSpApi\Services\BaseService;

class BaseServiceTest extends TestCase
{
    public function testConstructor(): void
    {
        // Mock ApiServiceInterface
        $apiService = $this->createMock(ApiServiceInterface::class);
        
        // Anonim sınıf oluşturarak abstract BaseService'i test ediyoruz
        $baseService = new class($apiService) extends BaseService {
            public function getApi(): ApiServiceInterface
            {
                return $this->api;
            }
        };
        
        // API servisi doğru şekilde enjekte edilmiş mi kontrol ediyoruz
        $this->assertSame($apiService, $baseService->getApi());
    }
} 