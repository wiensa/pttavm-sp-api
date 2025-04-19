<?php

namespace PttavmApi\PttavmSpApi\Services;

use PttavmApi\PttavmSpApi\Exceptions\PttAvmException;

class StoreService extends BaseService
{
    /**
     * Mağaza bilgilerini getirir.
     *
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function getInfo(): array
    {
        return $this->api->get('store/info');
    }

    /**
     * Mağaza performans metriklerini getirir.
     *
     * @param string|null $startDate Başlangıç tarihi (YYYY-MM-DD)
     * @param string|null $endDate Bitiş tarihi (YYYY-MM-DD)
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function getPerformance(?string $startDate = null, ?string $endDate = null): array
    {
        $params = [];
        
        if ($startDate !== null) {
            $params['start_date'] = $startDate;
        }
        
        if ($endDate !== null) {
            $params['end_date'] = $endDate;
        }
        
        return $this->api->get('store/performance', $params);
    }

    /**
     * Mağaza istatistiklerini getirir.
     *
     * @param string|null $startDate Başlangıç tarihi (YYYY-MM-DD)
     * @param string|null $endDate Bitiş tarihi (YYYY-MM-DD)
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function getStatistics(?string $startDate = null, ?string $endDate = null): array
    {
        $params = [];
        
        if ($startDate !== null) {
            $params['start_date'] = $startDate;
        }
        
        if ($endDate !== null) {
            $params['end_date'] = $endDate;
        }
        
        return $this->api->get('store/statistics', $params);
    }

    /**
     * Mağaza bilgilerini günceller.
     *
     * @param array $data Güncellenecek bilgiler
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function update(array $data): array
    {
        return $this->api->put('store/update', $data);
    }

    /**
     * Mağaza logo resmini günceller.
     *
     * @param string $logoPath Logo dosya yolu
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function updateLogo(string $logoPath): array
    {
        $options = [
            'multipart' => [
                [
                    'name' => 'logo',
                    'contents' => fopen($logoPath, 'r'),
                    'filename' => basename($logoPath)
                ]
            ]
        ];
        
        return $this->api->post('store/update/logo', $options);
    }

    /**
     * Mağaza durum bilgilerini getirir (aktif/pasif).
     *
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function getStatus(): array
    {
        return $this->api->get('store/status');
    }

    /**
     * Mağaza değerlendirmelerini getirir.
     *
     * @param array $filters Filtreler (örn. page, limit, sort)
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function getReviews(array $filters = []): array
    {
        return $this->api->get('store/reviews', $filters);
    }

    /**
     * Mağaza değerlendirmesine yanıt verir.
     *
     * @param string $reviewId Değerlendirme ID
     * @param string $response Yanıt metni
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function respondToReview(string $reviewId, string $response): array
    {
        return $this->api->post('store/review/respond', [
            'review_id' => $reviewId,
            'response' => $response
        ]);
    }

    /**
     * Mağaza bildirimlerini getirir.
     *
     * @param array $filters Filtreler (örn. page, limit, read_status)
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function getNotifications(array $filters = []): array
    {
        return $this->api->get('store/notifications', $filters);
    }

    /**
     * Mağaza bildirimini okundu olarak işaretler.
     *
     * @param string $notificationId Bildirim ID
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function markNotificationAsRead(string $notificationId): array
    {
        return $this->api->put('store/notification/read', ['notification_id' => $notificationId]);
    }
} 