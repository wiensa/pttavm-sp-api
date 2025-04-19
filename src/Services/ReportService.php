<?php

namespace PttavmApi\PttavmSpApi\Services;

use PttavmApi\PttavmSpApi\Exceptions\PttAvmException;

class ReportService extends BaseService
{
    /**
     * Satış raporunu getirir.
     *
     * @param string $startDate Başlangıç tarihi (YYYY-MM-DD)
     * @param string $endDate Bitiş tarihi (YYYY-MM-DD)
     * @param array $filters Filtreler (örn. status, payment_status, product_id)
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function getSales(string $startDate, string $endDate, array $filters = []): array
    {
        $params = [
            'start_date' => $startDate,
            'end_date' => $endDate
        ];
        
        if (!empty($filters)) {
            $params = array_merge($params, $filters);
        }
        
        return $this->api->get('report/sales', $params);
    }

    /**
     * Ürün performans raporunu getirir.
     *
     * @param string $startDate Başlangıç tarihi (YYYY-MM-DD)
     * @param string $endDate Bitiş tarihi (YYYY-MM-DD)
     * @param array $filters Filtreler (örn. product_id, category_id)
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function getProductPerformance(string $startDate, string $endDate, array $filters = []): array
    {
        $params = [
            'start_date' => $startDate,
            'end_date' => $endDate
        ];
        
        if (!empty($filters)) {
            $params = array_merge($params, $filters);
        }
        
        return $this->api->get('report/product/performance', $params);
    }

    /**
     * Stok raporunu getirir.
     *
     * @param array $filters Filtreler (örn. category_id, status)
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function getStock(array $filters = []): array
    {
        return $this->api->get('report/stock', $filters);
    }

    /**
     * Finans raporunu getirir.
     *
     * @param string $startDate Başlangıç tarihi (YYYY-MM-DD)
     * @param string $endDate Bitiş tarihi (YYYY-MM-DD)
     * @param array $filters Filtreler (örn. payment_status)
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function getFinance(string $startDate, string $endDate, array $filters = []): array
    {
        $params = [
            'start_date' => $startDate,
            'end_date' => $endDate
        ];
        
        if (!empty($filters)) {
            $params = array_merge($params, $filters);
        }
        
        return $this->api->get('report/finance', $params);
    }

    /**
     * İade raporunu getirir.
     *
     * @param string $startDate Başlangıç tarihi (YYYY-MM-DD)
     * @param string $endDate Bitiş tarihi (YYYY-MM-DD)
     * @param array $filters Filtreler (örn. status)
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function getReturns(string $startDate, string $endDate, array $filters = []): array
    {
        $params = [
            'start_date' => $startDate,
            'end_date' => $endDate
        ];
        
        if (!empty($filters)) {
            $params = array_merge($params, $filters);
        }
        
        return $this->api->get('report/returns', $params);
    }

    /**
     * İptal raporunu getirir.
     *
     * @param string $startDate Başlangıç tarihi (YYYY-MM-DD)
     * @param string $endDate Bitiş tarihi (YYYY-MM-DD)
     * @param array $filters Filtreler (örn. status)
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function getCancellations(string $startDate, string $endDate, array $filters = []): array
    {
        $params = [
            'start_date' => $startDate,
            'end_date' => $endDate
        ];
        
        if (!empty($filters)) {
            $params = array_merge($params, $filters);
        }
        
        return $this->api->get('report/cancellations', $params);
    }

    /**
     * Özel rapor talep eder (CSV/Excel formatında).
     *
     * @param string $reportType Rapor türü (sales, finance, stock, returns, vb.)
     * @param string $startDate Başlangıç tarihi (YYYY-MM-DD)
     * @param string $endDate Bitiş tarihi (YYYY-MM-DD)
     * @param string $format Rapor formatı (csv, excel)
     * @param array $filters Filtreler
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function requestCustom(string $reportType, string $startDate, string $endDate, string $format = 'csv', array $filters = []): array
    {
        $params = [
            'report_type' => $reportType,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'format' => $format
        ];
        
        if (!empty($filters)) {
            $params = array_merge($params, $filters);
        }
        
        return $this->api->post('report/request', $params);
    }

    /**
     * Rapor dosyasını indirir.
     *
     * @param string $reportId Rapor ID
     * @return array
     * @throws \PttavmApi\PttavmSpApi\Exceptions\PttAvmException
     */
    public function download(string $reportId): array
    {
        return $this->api->get('report/download', ['report_id' => $reportId]);
    }
} 