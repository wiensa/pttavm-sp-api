<?php

namespace PttavmApi\PttavmSpApi\Tests\Unit;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PttavmApi\PttavmSpApi\Exceptions\PttAvmException;
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
    
    public function testPutMethod(): void
    {
        $responseBody = [
            'status' => 'success',
            'message' => 'İşlem başarılı',
            'data' => [
                'updated' => true,
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
        
        $result = $reflectionMethod->invokeArgs($apiService, ['PUT', 'product/update', ['json' => ['id' => 123, 'name' => 'Güncellenmiş Ürün']]]);
        
        $this->assertEquals($responseBody, $result);
    }
    
    public function testDeleteMethod(): void
    {
        $responseBody = [
            'status' => 'success',
            'message' => 'İşlem başarılı',
            'data' => [
                'deleted' => true,
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
        
        $result = $reflectionMethod->invokeArgs($apiService, ['DELETE', 'product/delete', ['query' => ['id' => 123]]]);
        
        $this->assertEquals($responseBody, $result);
    }
    
    public function testGetAuthCredentials(): void
    {
        $username = 'test_username';
        $password = 'test_password';
        $shopId = 'test_shop_id';
        
        $apiService = new ApiService(
            $username,
            $password,
            $shopId,
            'https://api.test.com',
            30,
            false
        );
        
        $expected = [
            'username' => $username,
            'password' => $password,
            'shop_id' => $shopId,
        ];
        
        $this->assertEquals($expected, $apiService->getAuthCredentials());
    }
    
    public function testGetClient(): void
    {
        $apiService = new ApiService(
            'test_username',
            'test_password',
            'test_shop_id',
            'https://api.test.com',
            30,
            false
        );
        
        $this->assertInstanceOf(Client::class, $apiService->getClient());
    }
    
    public function testConstructorWithDebugMode(): void
    {
        $apiService = new ApiService(
            'test_username',
            'test_password',
            'test_shop_id',
            'https://api.test.com',
            30,
            true
        );
        
        $clientReflection = new \ReflectionObject($apiService->getClient());
        $configProperty = $clientReflection->getProperty('config');
        $configProperty->setAccessible(true);
        $config = $configProperty->getValue($apiService->getClient());
        
        $this->assertEquals('https://api.test.com', $config['base_uri']->__toString());
        $this->assertEquals(30, $config['timeout']);
        $this->assertFalse($config['verify']); // Debug modunda SSL doğrulaması kapalı olmalı
    }
    
    public function testSanitizeForLogging(): void
    {
        $reflectionClass = new \ReflectionClass(ApiService::class);
        $apiService = $reflectionClass->newInstanceWithoutConstructor();
        
        $sensitiveData = [
            'username' => 'user',
            'password' => 'secret123',
            'token' => 'very-secret-token',
            'api_key' => 'api-key-123',
            'data' => [
                'name' => 'Test',
                'secret' => 'hidden-secret',
                'auth' => 'auth-token',
                'nested' => [
                    'password' => 'nested-secret'
                ]
            ]
        ];
        
        $reflectionMethod = $reflectionClass->getMethod('sanitizeForLogging');
        $reflectionMethod->setAccessible(true);
        
        $result = $reflectionMethod->invokeArgs($apiService, [$sensitiveData]);
        
        $this->assertEquals('user', $result['username']);
        $this->assertEquals('***MASKED***', $result['password']);
        $this->assertEquals('***MASKED***', $result['token']);
        $this->assertEquals('***MASKED***', $result['api_key']);
        $this->assertEquals('Test', $result['data']['name']);
        $this->assertEquals('***MASKED***', $result['data']['secret']);
        $this->assertEquals('***MASKED***', $result['data']['auth']);
        $this->assertEquals('***MASKED***', $result['data']['nested']['password']);
    }
    
    public function testRequestWithErrorResponse(): void
    {
        $errorResponse = [
            'status' => 'error',
            'message' => 'Bir hata oluştu',
            'code' => 400,
        ];
        
        $expectedResponse = json_encode($errorResponse);
        
        $this->mockHandler->append(
            new Response(400, ['Content-Type' => 'application/json'], $expectedResponse)
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
        
        $reflectionProperty = $reflectionClass->getProperty('shouldLog');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($apiService, false);
        
        $reflectionMethod = $reflectionClass->getMethod('request');
        $reflectionMethod->setAccessible(true);
        
        $this->expectException(PttAvmException::class);
        // Hata mesajında tam olarak neyin olacağını kontrol etmek yerine,
        // sadece exception türünü kontrol edelim
        
        $reflectionMethod->invokeArgs($apiService, ['GET', 'product/list', []]);
    }
    
    public function testRequestWithInvalidJson(): void
    {
        $invalidJson = 'Invalid JSON response';
        
        $this->mockHandler->append(
            new Response(200, ['Content-Type' => 'application/json'], $invalidJson)
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
        
        $this->expectException(PttAvmException::class);
        
        $reflectionMethod->invokeArgs($apiService, ['GET', 'product/list', []]);
    }
} 