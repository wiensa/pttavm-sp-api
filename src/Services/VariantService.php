<?php

namespace PttavmApi\PttavmSpApi\Services;

use PttavmApi\PttavmSpApi\Exceptions\PttAvmException;

class VariantService extends BaseService
{
    /**
     * Ürün varyantlarını listeler.
     *
     * @param string $barcode Ana ürün barkodu
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function getList(string $barcode): array
    {
        return $this->api->get('variant/list', ['barcode' => $barcode]);
    }

    /**
     * Ürün varyantlarını toplu olarak günceller.
     *
     * @param string $barcode Ana ürün barkodu
     * @param array $variants Varyant bilgileri listesi
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function batchUpdate(string $barcode, array $variants): array
    {
        return $this->api->put('variant/batch/update', [
            'barcode' => $barcode,
            'variants' => $variants
        ]);
    }

    /**
     * Ürün varyantı ekler.
     *
     * @param string $barcode Ana ürün barkodu
     * @param array $variant Varyant bilgileri
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function create(string $barcode, array $variant): array
    {
        $this->validateVariantData($variant);
        
        return $this->api->post('variant/create', [
            'barcode' => $barcode,
            'variant' => $variant
        ]);
    }

    /**
     * Ürün varyantını günceller.
     *
     * @param string $barcode Ana ürün barkodu
     * @param string $variantBarcode Varyant barkodu
     * @param array $variant Varyant bilgileri
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function update(string $barcode, string $variantBarcode, array $variant): array
    {
        return $this->api->put('variant/update', [
            'barcode' => $barcode,
            'variant_barcode' => $variantBarcode,
            'variant' => $variant
        ]);
    }

    /**
     * Ürün varyantı fiyatını günceller.
     *
     * @param string $barcode Ana ürün barkodu
     * @param string $variantBarcode Varyant barkodu
     * @param float $price Yeni fiyat
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function updatePrice(string $barcode, string $variantBarcode, float $price): array
    {
        return $this->api->put('variant/update/price', [
            'barcode' => $barcode,
            'variant_barcode' => $variantBarcode,
            'price' => $price
        ]);
    }

    /**
     * Ürün varyantı stok miktarını günceller.
     *
     * @param string $barcode Ana ürün barkodu
     * @param string $variantBarcode Varyant barkodu
     * @param int $stock Yeni stok miktarı
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function updateStock(string $barcode, string $variantBarcode, int $stock): array
    {
        return $this->api->put('variant/update/stock', [
            'barcode' => $barcode,
            'variant_barcode' => $variantBarcode,
            'stock' => $stock
        ]);
    }

    /**
     * Ürün varyantını siler.
     *
     * @param string $barcode Ana ürün barkodu
     * @param string $variantBarcode Varyant barkodu
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function delete(string $barcode, string $variantBarcode): array
    {
        return $this->api->delete('variant/delete', [
            'barcode' => $barcode,
            'variant_barcode' => $variantBarcode
        ]);
    }

    /**
     * Varyant verilerini doğrular.
     *
     * @param array $variant Varyant verileri
     * @return void
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    protected function validateVariantData(array $variant): void
    {
        $requiredFields = ['barcode', 'title', 'price', 'stock', 'attributes'];
        
        foreach ($requiredFields as $field) {
            if (!isset($variant[$field]) || empty($variant[$field])) {
                throw new PttAvmException(sprintf('%s alanı gereklidir.', $field));
            }
        }
        
        if (!is_array($variant['attributes']) || empty($variant['attributes'])) {
            throw new PttAvmException('Varyant özellikleri (attributes) bir dizi olmalı ve boş olmamalıdır.');
        }
    }
} 