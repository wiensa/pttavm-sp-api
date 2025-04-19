<?php

namespace PttavmApi\PttavmSpApi\Services;

use PttavmApi\PttavmSpApi\Exceptions\PttAvmException;

class ProductService extends BaseService
{
    /**
     * Yeni ürün oluşturur.
     *
     * @param array $product Ürün verileri
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function create(array $product): array
    {
        $this->validateProductData($product);
        
        return $this->api->post('product/create', $product);
    }

    /**
     * Ürünü günceller.
     *
     * @param array $product Ürün verileri
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function update(array $product): array
    {
        if (!isset($product['barcode']) || empty($product['barcode'])) {
            throw new PttAvmException('Ürün barkodu gereklidir.');
        }
        
        return $this->api->put('product/update', $product);
    }

    /**
     * Ürün fiyatını günceller.
     *
     * @param string $barcode Ürün barkodu
     * @param float $price Yeni fiyat
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function updatePrice(string $barcode, float $price): array
    {
        return $this->api->put('product/update/price', [
            'barcode' => $barcode,
            'price' => $price,
        ]);
    }

    /**
     * Ürün stok miktarını günceller.
     *
     * @param string $barcode Ürün barkodu
     * @param int $stock Yeni stok miktarı
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function updateStock(string $barcode, int $stock): array
    {
        return $this->api->put('product/update/stock', [
            'barcode' => $barcode,
            'stock' => $stock,
        ]);
    }

    /**
     * Ürünleri toplu olarak günceller.
     *
     * @param array $products Ürünler listesi
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function batchUpdate(array $products): array
    {
        return $this->api->put('product/batch/update', [
            'products' => $products,
        ]);
    }

    /**
     * Ürün detaylarını getirir.
     *
     * @param string $barcode Ürün barkodu
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function getDetail(string $barcode): array
    {
        return $this->api->get('product/detail', ['barcode' => $barcode]);
    }

    /**
     * Ürünleri listeler.
     *
     * @param array $filters Filtreler (örn. status, category_id, page, limit)
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function getList(array $filters = []): array
    {
        return $this->api->get('product/list', $filters);
    }

    /**
     * Ürünü pasif duruma getirir.
     *
     * @param string $barcode Ürün barkodu
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function deactivate(string $barcode): array
    {
        return $this->api->put('product/deactivate', ['barcode' => $barcode]);
    }

    /**
     * Ürünü aktif duruma getirir.
     *
     * @param string $barcode Ürün barkodu
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function activate(string $barcode): array
    {
        return $this->api->put('product/activate', ['barcode' => $barcode]);
    }

    /**
     * Ürün verilerini doğrular.
     *
     * @param array $product Ürün verileri
     * @return void
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    protected function validateProductData(array $product): void
    {
        $requiredFields = ['barcode', 'title', 'price', 'stock', 'category_id'];
        
        foreach ($requiredFields as $field) {
            if (!isset($product[$field]) || empty($product[$field])) {
                throw new PttAvmException(sprintf('%s alanı gereklidir.', $field));
            }
        }
    }
} 