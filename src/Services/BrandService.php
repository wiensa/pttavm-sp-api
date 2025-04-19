<?php

namespace PttavmApi\PttavmSpApi\Services;

use PttavmApi\PttavmSpApi\Exceptions\PttAvmException;

class BrandService extends BaseService
{
    /**
     * Markaları listeler.
     *
     * @param array $filters Filtreler (örn. category_id, page, limit, query)
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function getList(array $filters = []): array
    {
        return $this->api->get('brand/list', $filters);
    }

    /**
     * Marka detayını getirir.
     *
     * @param int $brandId Marka ID
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function getDetail(int $brandId): array
    {
        return $this->api->get('brand/detail', ['brand_id' => $brandId]);
    }

    /**
     * Marka adına göre marka arar.
     *
     * @param string $query Arama sorgusu (marka adı)
     * @param int|null $categoryId Kategori ID (isteğe bağlı)
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function search(string $query, ?int $categoryId = null): array
    {
        $params = ['query' => $query];
        
        if ($categoryId !== null) {
            $params['category_id'] = $categoryId;
        }
        
        return $this->api->get('brand/search', $params);
    }

    /**
     * Kategoriye göre markaları listeler.
     *
     * @param int $categoryId Kategori ID
     * @param array $filters Filtreler (örn. page, limit)
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function getListByCategory(int $categoryId, array $filters = []): array
    {
        $filters['category_id'] = $categoryId;
        return $this->api->get('brand/list/category', $filters);
    }

    /**
     * Marka oluşturma isteği gönderir.
     *
     * @param string $name Marka adı
     * @param array $categories Marka için kategori ID'leri
     * @param array $additionalInfo Ek bilgiler (örn. description, logo_url)
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function requestCreate(string $name, array $categories, array $additionalInfo = []): array
    {
        $data = [
            'name' => $name,
            'categories' => $categories
        ];
        
        if (!empty($additionalInfo)) {
            $data = array_merge($data, $additionalInfo);
        }
        
        return $this->api->post('brand/request/create', $data);
    }

    /**
     * Marka oluşturma istek durumunu sorgular.
     *
     * @param string $requestId İstek ID
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function checkRequestStatus(string $requestId): array
    {
        return $this->api->get('brand/request/status', ['request_id' => $requestId]);
    }

    /**
     * Marka oluşturma isteklerini listeler.
     *
     * @param array $filters Filtreler (örn. status, page, limit)
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function getRequestList(array $filters = []): array
    {
        return $this->api->get('brand/request/list', $filters);
    }
} 