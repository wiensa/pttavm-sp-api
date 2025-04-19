<?php

namespace PttavmApi\PttavmSpApi\Services;

class OrderService extends BaseService
{
    /**
     * Siparişleri listeler.
     *
     * @param array $filters Filtreler (örn. status, start_date, end_date, page, limit)
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function getList(array $filters = []): array
    {
        return $this->api->get('order/list', $filters);
    }

    /**
     * Sipariş detaylarını getirir.
     *
     * @param string $orderNumber Sipariş numarası
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function getDetail(string $orderNumber): array
    {
        return $this->api->get('order/detail', ['order_number' => $orderNumber]);
    }

    /**
     * Siparişi onaylar.
     *
     * @param string $orderNumber Sipariş numarası
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function approve(string $orderNumber): array
    {
        return $this->api->put('order/approve', ['order_number' => $orderNumber]);
    }

    /**
     * Siparişi reddeder.
     *
     * @param string $orderNumber Sipariş numarası
     * @param string $reason Ret nedeni
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function reject(string $orderNumber, string $reason): array
    {
        return $this->api->put('order/reject', [
            'order_number' => $orderNumber,
            'reason' => $reason,
        ]);
    }

    /**
     * Sipariş kargo bilgilerini günceller.
     *
     * @param string $orderNumber Sipariş numarası
     * @param string $trackingNumber Kargo takip numarası
     * @param string|null $shippingCompany Kargo şirketi
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function updateShipment(string $orderNumber, string $trackingNumber, ?string $shippingCompany = null): array
    {
        $data = [
            'order_number' => $orderNumber,
            'tracking_number' => $trackingNumber,
        ];

        if ($shippingCompany !== null) {
            $data['shipping_company'] = $shippingCompany;
        }

        return $this->api->put('order/shipment/update', $data);
    }

    /**
     * Sipariş iptali talep eder.
     *
     * @param string $orderNumber Sipariş numarası
     * @param string $reason İptal nedeni
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function requestCancel(string $orderNumber, string $reason): array
    {
        return $this->api->put('order/cancel/request', [
            'order_number' => $orderNumber,
            'reason' => $reason,
        ]);
    }

    /**
     * Sipariş iade talep eder.
     *
     * @param string $orderNumber Sipariş numarası
     * @param string $reason İade nedeni
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function requestReturn(string $orderNumber, string $reason): array
    {
        return $this->api->put('order/return/request', [
            'order_number' => $orderNumber,
            'reason' => $reason,
        ]);
    }

    /**
     * İade talebini onaylar.
     *
     * @param string $orderNumber Sipariş numarası
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function approveReturn(string $orderNumber): array
    {
        return $this->api->put('order/return/approve', [
            'order_number' => $orderNumber,
        ]);
    }

    /**
     * İade talebini reddeder.
     *
     * @param string $orderNumber Sipariş numarası
     * @param string $reason Ret nedeni
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function rejectReturn(string $orderNumber, string $reason): array
    {
        return $this->api->put('order/return/reject', [
            'order_number' => $orderNumber,
            'reason' => $reason,
        ]);
    }

    /**
     * Sipariş notlarını günceller.
     *
     * @param string $orderNumber Sipariş numarası
     * @param string $notes Notlar
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function updateNotes(string $orderNumber, string $notes): array
    {
        return $this->api->put('order/notes/update', [
            'order_number' => $orderNumber,
            'notes' => $notes,
        ]);
    }
} 