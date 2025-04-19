<?php

namespace PttavmApi\PttavmSpApi\Services;

use Illuminate\Support\Facades\Cache;

class CategoryService extends BaseService
{
    /**
     * Kategorileri listeler.
     *
     * @param array $filters Filtreler (örn. parent_id, status)
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function getList(array $filters = []): array
    {
        $cacheKey = 'pttavm_categories_' . md5(serialize($filters));
        $cacheTtl = config('pttavm.cache_ttl', 60);

        // Önbellekten kategorileri al
        if (Cache::has($cacheKey) && $cacheTtl > 0) {
            return Cache::get($cacheKey);
        }

        $result = $this->api->get('category/list', $filters);

        // Önbelleğe kategorileri kaydet
        if ($cacheTtl > 0) {
            Cache::put($cacheKey, $result, $cacheTtl * 60);
        }

        return $result;
    }

    /**
     * Kategori detaylarını getirir.
     *
     * @param int $categoryId Kategori ID
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function getDetail(int $categoryId): array
    {
        $cacheKey = 'pttavm_category_' . $categoryId;
        $cacheTtl = config('pttavm.cache_ttl', 60);

        // Önbellekten kategori detayını al
        if (Cache::has($cacheKey) && $cacheTtl > 0) {
            return Cache::get($cacheKey);
        }

        $result = $this->api->get('category/detail', ['category_id' => $categoryId]);

        // Önbelleğe kategori detayını kaydet
        if ($cacheTtl > 0) {
            Cache::put($cacheKey, $result, $cacheTtl * 60);
        }

        return $result;
    }

    /**
     * Kategori özniteliklerini getirir.
     *
     * @param int $categoryId Kategori ID
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function getAttributes(int $categoryId): array
    {
        $cacheKey = 'pttavm_category_attributes_' . $categoryId;
        $cacheTtl = config('pttavm.cache_ttl', 60);

        // Önbellekten kategori özniteliklerini al
        if (Cache::has($cacheKey) && $cacheTtl > 0) {
            return Cache::get($cacheKey);
        }

        $result = $this->api->get('category/attributes', ['category_id' => $categoryId]);

        // Önbelleğe kategori özniteliklerini kaydet
        if ($cacheTtl > 0) {
            Cache::put($cacheKey, $result, $cacheTtl * 60);
        }

        return $result;
    }

    /**
     * Kategori varyasyonlarını getirir.
     *
     * @param int $categoryId Kategori ID
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function getVariations(int $categoryId): array
    {
        $cacheKey = 'pttavm_category_variations_' . $categoryId;
        $cacheTtl = config('pttavm.cache_ttl', 60);

        // Önbellekten kategori varyasyonlarını al
        if (Cache::has($cacheKey) && $cacheTtl > 0) {
            return Cache::get($cacheKey);
        }

        $result = $this->api->get('category/variations', ['category_id' => $categoryId]);

        // Önbelleğe kategori varyasyonlarını kaydet
        if ($cacheTtl > 0) {
            Cache::put($cacheKey, $result, $cacheTtl * 60);
        }

        return $result;
    }

    /**
     * Kategori komisyon oranını getirir.
     *
     * @param int $categoryId Kategori ID
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function getCommissionRate(int $categoryId): array
    {
        $cacheKey = 'pttavm_category_commission_' . $categoryId;
        $cacheTtl = config('pttavm.cache_ttl', 60);

        // Önbellekten kategori komisyon oranını al
        if (Cache::has($cacheKey) && $cacheTtl > 0) {
            return Cache::get($cacheKey);
        }

        $result = $this->api->get('category/commission', ['category_id' => $categoryId]);

        // Önbelleğe kategori komisyon oranını kaydet
        if ($cacheTtl > 0) {
            Cache::put($cacheKey, $result, $cacheTtl * 60);
        }

        return $result;
    }

    /**
     * Kategori önbelleğini temizler.
     *
     * @return void
     */
    public function clearCache(): void
    {
        $patterns = [
            'pttavm_categories_*',
            'pttavm_category_*',
        ];

        foreach ($patterns as $pattern) {
            $keys = Cache::get($pattern);
            foreach ($keys as $key) {
                Cache::forget($key);
            }
        }
    }
} 