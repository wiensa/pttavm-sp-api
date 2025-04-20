<?php

namespace PttavmApi\PttavmSpApi\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use PttavmApi\PttavmSpApi\Contracts\ApiServiceInterface;
use PttavmApi\PttavmSpApi\Exceptions\PttAvmException;

class ApiService implements ApiServiceInterface
{
    /**
     * HTTP Client
     *
     * @var \GuzzleHttp\Client
     */
    protected Client $client;

    /**
     * API kullanıcı adı
     *
     * @var string
     */
    protected string $username;

    /**
     * API şifresi
     *
     * @var string
     */
    protected string $password;

    /**
     * Mağaza ID
     *
     * @var string
     */
    protected string $shopId;

    /**
     * Hata ayıklama modu
     *
     * @var bool
     */
    protected bool $debug;

    /**
     * Log yapılıp yapılmayacağını belirler
     * 
     * @var bool
     */
    protected bool $shouldLog = false;

    /**
     * ApiService constructor.
     *
     * @param string $username API kullanıcı adı
     * @param string $password API şifresi
     * @param string $shopId Mağaza ID
     * @param string $apiUrl API URL
     * @param int $timeout API zaman aşımı (saniye)
     * @param bool $debug Hata ayıklama modu
     */
    public function __construct(
        string $username,
        string $password,
        string $shopId,
        string $apiUrl,
        int $timeout = 30,
        bool $debug = false
    ) {
        $this->username = $username;
        $this->password = $password;
        $this->shopId = $shopId;
        $this->debug = $debug;

        $this->client = new Client([
            'base_uri' => $apiUrl,
            'timeout' => $timeout,
            'verify' => !$debug, // SSL doğrulamasını debug modunda devre dışı bırak
        ]);
        
        // Laravel ortamında olup olmadığımızı kontrol et
        $this->shouldLog = class_exists('\Illuminate\Support\Facades\Log') && function_exists('config');
    }

    /**
     * HTTP istemcisini döndürür.
     *
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * API'ye POST isteği gönderir.
     *
     * @param string $endpoint API bitiş noktası
     * @param array $data İstek verileri
     * @param array $headers İsteğe bağlı HTTP başlıkları
     * @return array
     *
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function post(string $endpoint, array $data = [], array $headers = []): array
    {
        return $this->request('POST', $endpoint, ['json' => $data], $headers);
    }

    /**
     * API'ye GET isteği gönderir.
     *
     * @param string $endpoint API bitiş noktası
     * @param array $params Sorgu parametreleri
     * @param array $headers İsteğe bağlı HTTP başlıkları
     * @return array
     *
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function get(string $endpoint, array $params = [], array $headers = []): array
    {
        return $this->request('GET', $endpoint, ['query' => $params], $headers);
    }

    /**
     * API'ye PUT isteği gönderir.
     *
     * @param string $endpoint API bitiş noktası
     * @param array $data İstek verileri
     * @param array $headers İsteğe bağlı HTTP başlıkları
     * @return array
     *
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function put(string $endpoint, array $data = [], array $headers = []): array
    {
        return $this->request('PUT', $endpoint, ['json' => $data], $headers);
    }

    /**
     * API'ye DELETE isteği gönderir.
     *
     * @param string $endpoint API bitiş noktası
     * @param array $params Sorgu parametreleri
     * @param array $headers İsteğe bağlı HTTP başlıkları
     * @return array
     *
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function delete(string $endpoint, array $params = [], array $headers = []): array
    {
        return $this->request('DELETE', $endpoint, ['query' => $params], $headers);
    }

    /**
     * Oturum kimlik doğrulama bilgilerini döndürür.
     *
     * @return array
     */
    public function getAuthCredentials(): array
    {
        return [
            'username' => $this->username,
            'password' => $this->password,
            'shop_id' => $this->shopId,
        ];
    }

    /**
     * API isteği gönderir.
     *
     * @param string $method HTTP metodu
     * @param string $endpoint API bitiş noktası
     * @param array $options İstek seçenekleri
     * @param array $headers İsteğe bağlı HTTP başlıkları
     * @return array
     *
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    protected function request(string $method, string $endpoint, array $options = [], array $headers = []): array
    {
        // Kimlik doğrulama bilgilerini ekle
        $auth = $this->getAuthCredentials();

        // Eğer mevcut bir json gönderiliyorsa, kimlik doğrulama bilgilerini ekle
        if (isset($options['json'])) {
            $options['json'] = array_merge($options['json'], $auth);
        } elseif (isset($options['query'])) {
            // Sorgu parametrelerine kimlik doğrulama bilgilerini ekle
            $options['query'] = array_merge($options['query'], $auth);
        } else {
            // Varsayılan olarak json olarak gönder
            $options['json'] = $auth;
        }

        // Başlıkları birleştir
        $options['headers'] = array_merge([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ], $headers);

        try {
            // Laravel ortamında olup olmadığımızı kontrol et ve log yap
            if ($this->shouldLog && $this->getShouldLogConfig('api_requests', true)) {
                $this->log('debug', 'PttAvm API Request', [
                    'method' => $method,
                    'endpoint' => $endpoint,
                    'options' => $this->sanitizeForLogging($options),
                ]);
            }

            // İsteği gönder
            $response = $this->client->request($method, $endpoint, $options);
            $body = $response->getBody()->getContents();
            $data = json_decode($body, true);

            // Laravel ortamında olup olmadığımızı kontrol et ve log yap
            if ($this->shouldLog && $this->getShouldLogConfig('api_responses', true)) {
                $this->log('debug', 'PttAvm API Response', [
                    'method' => $method,
                    'endpoint' => $endpoint,
                    'status' => $response->getStatusCode(),
                    'data' => $this->sanitizeForLogging($data),
                ]);
            }

            // JSON dönüşüm hatası kontrolü
            if ($data === null && $body !== '') {
                throw new PttAvmException(
                    'API yanıtı JSON formatında değil: ' . substr($body, 0, 100),
                    $response->getStatusCode()
                );
            }

            // API hata kontrolü
            if (isset($data['status']) && $data['status'] !== 'success') {
                throw new PttAvmException(
                    $data['message'] ?? 'API hatası oluştu',
                    $response->getStatusCode(),
                    $data['code'] ?? null,
                    $data
                );
            }

            return $data;
        } catch (GuzzleException $e) {
            // Laravel ortamında olup olmadığımızı kontrol et ve log yap
            if ($this->shouldLog && $this->getShouldLogConfig('api_errors', true)) {
                $this->log('error', 'PttAvm API Error', [
                    'method' => $method,
                    'endpoint' => $endpoint,
                    'error' => $e->getMessage(),
                ]);
            }

            throw new PttAvmException(
                'API isteği gönderilirken hata oluştu: ' . $e->getMessage(),
                $e->getCode() ?: 500,
                null,
                [
                    'method' => $method,
                    'endpoint' => $endpoint,
                    'error' => $e->getMessage()
                ],
                $e
            );
        }
    }

    /**
     * Laravel ortamında config değerini alır
     * 
     * @param string $key Config anahtarı
     * @param mixed $default Varsayılan değer
     * @return mixed
     */
    protected function getShouldLogConfig(string $key, $default = null)
    {
        if (function_exists('config')) {
            return config('pttavm.log.' . $key, $default);
        }
        
        return $default;
    }
    
    /**
     * Log mesajını kaydeder
     * 
     * @param string $level Log seviyesi (debug, info, warning, error, critical)
     * @param string $message Log mesajı
     * @param array $context Log bağlamı
     * @return void
     */
    protected function log(string $level, string $message, array $context = []): void
    {
        if (!$this->shouldLog) {
            return;
        }
        
        if (class_exists('\Illuminate\Support\Facades\Log')) {
            $channel = function_exists('config') 
                ? config('pttavm.log.channel', 'daily') 
                : 'daily';
                
            \Illuminate\Support\Facades\Log::channel($channel)->$level($message, $context);
        }
    }

    /**
     * Hassas verileri loglama için temizler.
     *
     * @param array $data Temizlenecek veri
     * @return array Temizlenmiş veri
     */
    protected function sanitizeForLogging(array $data): array
    {
        $sensitiveKeys = ['password', 'token', 'api_key', 'secret', 'auth'];
        
        foreach ($data as $key => $value) {
            if (in_array(strtolower($key), $sensitiveKeys)) {
                $data[$key] = '***MASKED***';
            } elseif (is_array($value)) {
                $data[$key] = $this->sanitizeForLogging($value);
            }
        }
        
        return $data;
    }
} 