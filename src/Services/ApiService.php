<?php

namespace PttavmApi\PttavmSpApi\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use PttavmApi\PttavmSpApi\Contracts\ApiServiceInterface;
use PttavmApi\PttavmSpApi\Exceptions\PttAvmException;
use Illuminate\Support\Facades\Log;

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
            // İsteği logla
            if (config('pttavm.log.api_requests', true)) {
                Log::channel(config('pttavm.log.channel', 'daily'))
                    ->debug('PttAvm API Request', [
                        'method' => $method,
                        'endpoint' => $endpoint,
                        'options' => $this->sanitizeForLogging($options),
                    ]);
            }

            // İsteği gönder
            $response = $this->client->request($method, $endpoint, $options);
            $body = $response->getBody()->getContents();
            $data = json_decode($body, true);

            // Yanıtı logla
            if (config('pttavm.log.api_responses', true)) {
                Log::channel(config('pttavm.log.channel', 'daily'))
                    ->debug('PttAvm API Response', [
                        'method' => $method,
                        'endpoint' => $endpoint,
                        'status' => $response->getStatusCode(),
                        'data' => $data,
                    ]);
            }

            // Yanıt başarısız ise istisna fırlat
            if (isset($data['status']) && $data['status'] !== 'success') {
                throw new PttAvmException(
                    $data['message'] ?? 'API isteği başarısız oldu',
                    $data['code'] ?? 0,
                    $data
                );
            }

            return $data;
        } catch (GuzzleException $e) {
            // Hatayı logla
            if (config('pttavm.log.errors', true)) {
                Log::channel(config('pttavm.log.channel', 'daily'))
                    ->error('PttAvm API Error', [
                        'method' => $method,
                        'endpoint' => $endpoint,
                        'error' => $e->getMessage(),
                    ]);
            }

            throw new PttAvmException(
                'API isteği başarısız oldu: ' . $e->getMessage(),
                $e->getCode(),
                null,
                $e
            );
        } catch (\Exception $e) {
            // Hatayı logla
            if (config('pttavm.log.errors', true)) {
                Log::channel(config('pttavm.log.channel', 'daily'))
                    ->error('PttAvm API Error', [
                        'method' => $method,
                        'endpoint' => $endpoint,
                        'error' => $e->getMessage(),
                    ]);
            }

            throw new PttAvmException(
                'İstek işlenirken bir hata oluştu: ' . $e->getMessage(),
                $e->getCode(),
                null,
                $e
            );
        }
    }

    /**
     * Loglamadan önce hassas verileri temizler.
     *
     * @param array $data
     * @return array
     */
    protected function sanitizeForLogging(array $data): array
    {
        // JSON verilerini kopyala
        $sanitized = $data;

        // Hassas bilgileri maskele
        if (isset($sanitized['json'])) {
            if (isset($sanitized['json']['password'])) {
                $sanitized['json']['password'] = '********';
            }
        }

        // Sorgu parametrelerindeki hassas bilgileri maskele
        if (isset($sanitized['query'])) {
            if (isset($sanitized['query']['password'])) {
                $sanitized['query']['password'] = '********';
            }
        }

        return $sanitized;
    }
} 