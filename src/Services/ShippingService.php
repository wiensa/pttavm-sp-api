<?php

namespace PttavmApi\PttavmSpApi\Services;

class ShippingService extends BaseService
{
    /**
     * Kargo firmalarını listeler.
     *
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function getCarriers(): array
    {
        return $this->api->get('shipping/carriers');
    }

    /**
     * Teslimat şablonlarını listeler.
     *
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function getTemplates(): array
    {
        return $this->api->get('shipping/templates');
    }

    /**
     * Teslimat şablonu oluşturur.
     *
     * @param array $template Şablon verileri
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function createTemplate(array $template): array
    {
        return $this->api->post('shipping/template/create', $template);
    }

    /**
     * Teslimat şablonu günceller.
     *
     * @param int $templateId Şablon ID
     * @param array $template Şablon verileri
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function updateTemplate(int $templateId, array $template): array
    {
        $template['template_id'] = $templateId;
        return $this->api->put('shipping/template/update', $template);
    }

    /**
     * Teslimat şablonu siler.
     *
     * @param int $templateId Şablon ID
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function deleteTemplate(int $templateId): array
    {
        return $this->api->delete('shipping/template/delete', ['template_id' => $templateId]);
    }

    /**
     * Kargo takip bilgilerini getirir.
     *
     * @param string $trackingNumber Kargo takip numarası
     * @param string|null $carrier Kargo firması
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function trackShipment(string $trackingNumber, ?string $carrier = null): array
    {
        $params = ['tracking_number' => $trackingNumber];
        
        if ($carrier !== null) {
            $params['carrier'] = $carrier;
        }
        
        return $this->api->get('shipping/track', $params);
    }

    /**
     * Kargo fişi oluşturur.
     *
     * @param string $orderNumber Sipariş numarası
     * @param string|null $carrier Kargo firması
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function generateLabel(string $orderNumber, ?string $carrier = null): array
    {
        $params = ['order_number' => $orderNumber];
        
        if ($carrier !== null) {
            $params['carrier'] = $carrier;
        }
        
        return $this->api->get('shipping/label', $params);
    }

    /**
     * Desi hesaplar.
     *
     * @param float $width Genişlik (cm)
     * @param float $length Uzunluk (cm)
     * @param float $height Yükseklik (cm)
     * @return int
     */
    public function calculateDesi(float $width, float $length, float $height): int
    {
        $desi = ($width * $length * $height) / 3000;
        return ceil($desi);
    }

    /**
     * Kargo ücretini hesaplar.
     *
     * @param array $parameters Parametreler
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function calculateShippingCost(array $parameters): array
    {
        return $this->api->post('shipping/calculate', $parameters);
    }
} 