<?php

namespace PttavmApi\PttavmSpApi\Tests\Unit;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PttavmApi\PttavmSpApi\Services\ApiService;

class ApiServiceTest extends TestCase
{
    protected MockHandler $mockHandler;
    protected HandlerStack $handlerStack;
    protected Client $client;
    protected ApiService $apiService;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->mockHandler = new MockHandler();
        $this->handlerStack = HandlerStack::create($this->mockHandler);
        $this->client = new Client(['handler' => $this->handlerStack]);
    }
    
    public function testPostMethod(): void
    {
        $responseBody = [
            'status' => 'success',
            'message' => 'İşlem başarılı',
            'data' => [
                'id' => 123,
                'name' => 'Test Ürün',
            ],
        ];
        
        $expectedResponse = json_encode($responseBody);
        
        $this->mockHandler->append(
            new Response(200, ['Content-Type' => 'application/json'], $expectedResponse)
        );
        
        $reflectionClass = new \ReflectionClass(ApiService::class);
        $apiService = $reflectionClass->newInstanceWithoutConstructor();
        
        $reflectionProperty = $reflectionClass->getProperty('client');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($apiService, $this->client);
        
        $reflectionProperty = $reflectionClass->getProperty('username');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($apiService, 'test_username');
        
        $reflectionProperty = $reflectionClass->getProperty('password');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($apiService, 'test_password');
        
        $reflectionProperty = $reflectionClass->getProperty('shopId');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($apiService, 'test_shop_id');
        
        $reflectionMethod = $reflectionClass->getMethod('request');
        $reflectionMethod->setAccessible(true);
        
        $result = $reflectionMethod->invokeArgs($apiService, ['POST', 'product/create', ['json' => ['name' => 'Test Ürün']]]);
        
        $this->assertEquals($responseBody, $result);
    }
    
    public function testGetMethod(): void
    {
        $responseBody = [
            'status' => 'success',
            'message' => 'İşlem başarılı',
            'data' => [
                'orders' => [
                    [
                        'order_number' => 'ORDER123',
                        'status' => 'waiting',
                    ],
                ],
            ],
        ];
        
        $expectedResponse = json_encode($responseBody);
        
        $this->mockHandler->append(
            new Response(200, ['Content-Type' => 'application/json'], $expectedResponse)
        );
        
        $reflectionClass = new \ReflectionClass(ApiService::class);
        $apiService = $reflectionClass->newInstanceWithoutConstructor();
        
        $reflectionProperty = $reflectionClass->getProperty('client');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($apiService, $this->client);
        
        $reflectionProperty = $reflectionClass->getProperty('username');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($apiService, 'test_username');
        
        $reflectionProperty = $reflectionClass->getProperty('password');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($apiService, 'test_password');
        
        $reflectionProperty = $reflectionClass->getProperty('shopId');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($apiService, 'test_shop_id');
        
        $reflectionMethod = $reflectionClass->getMethod('request');
        $reflectionMethod->setAccessible(true);
        
        $result = $reflectionMethod->invokeArgs($apiService, ['GET', 'order/list', ['query' => ['status' => 'waiting']]]);
        
        $this->assertEquals($responseBody, $result);
    }
} 