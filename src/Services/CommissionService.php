<?php

namespace PttavmApi\PttavmSpApi\Services;

use PttavmApi\PttavmSpApi\Exceptions\PttAvmException;

class CommissionService extends BaseService
{
    /**
     * Kategori komisyon oranlarını listeler.
     *
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function getCategoryRates(): array
    {
        return $this->api->get('commission/category/rates');
    }

    /**
     * Belirli bir kategorinin komisyon oranını getirir.
     *
     * @param int $categoryId Kategori ID
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function getCategoryRate(int $categoryId): array
    {
        return $this->api->get('commission/category/rate', ['category_id' => $categoryId]);
    }

    /**
     * Ürün komisyon oranını getirir.
     *
     * @param string $barcode Ürün barkodu
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function getProductRate(string $barcode): array
    {
        return $this->api->get('commission/product/rate', ['barcode' => $barcode]);
    }

    /**
     * Mağaza komisyon oranını getirir.
     *
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function getShopRate(): array
    {
        return $this->api->get('commission/shop/rate');
    }

    /**
     * Komisyon hesaplaması yapar.
     *
     * @param float $price Ürün fiyatı
     * @param int $categoryId Kategori ID
     * @param float|null $commissionRate Özel komisyon oranı (isteğe bağlı)
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function calculate(float $price, int $categoryId, ?float $commissionRate = null): array
    {
        $data = [
            'price' => $price,
            'category_id' => $categoryId
        ];

        if ($commissionRate !== null) {
            $data['commission_rate'] = $commissionRate;
        }

        return $this->api->post('commission/calculate', $data);
    }

    /**
     * Toplu komisyon hesaplaması yapar.
     *
     * @param array $products Ürün bilgileri listesi (her biri price ve category_id içermeli)
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function batchCalculate(array $products): array
    {
        return $this->api->post('commission/batch/calculate', ['products' => $products]);
    }

    /**
     * Komisyon özetini getirir (belirli bir tarih aralığı için).
     *
     * @param string $startDate Başlangıç tarihi (YYYY-MM-DD)
     * @param string $endDate Bitiş tarihi (YYYY-MM-DD)
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function getSummary(string $startDate, string $endDate): array
    {
        return $this->api->get('commission/summary', [
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
    }
} 