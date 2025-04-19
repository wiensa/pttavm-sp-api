<?php

return [
    /*
    |--------------------------------------------------------------------------
    | PttAvm API Yapılandırması
    |--------------------------------------------------------------------------
    |
    | Bu ayarlar PttAvm pazaryeri entegrasyonu için gerekli yapılandırma değerlerini içerir.
    | API kullanıcı adı, şifre ve mağaza ID bilgilerini PttAvm mağaza panelinden alabilirsiniz.
    | API bilgilerinizi almak için PttAvm kategori yöneticinize mail göndermeniz gerekebilir.
    |
    */

    // API Kullanıcı Adı - PttAvm tarafından verilen API kullanıcı adı
    'username' => env('PTTAVM_USERNAME', ''),

    // API Şifresi - PttAvm tarafından verilen API şifresi
    'password' => env('PTTAVM_PASSWORD', ''),

    // Mağaza ID - PttAvm tarafından verilen mağaza ID bilgisi
    'shop_id' => env('PTTAVM_SHOP_ID', ''),

    // API URL - PttAvm API'sine istek yapılacak temel URL
    'api_url' => env('PTTAVM_API_URL', 'https://api.epttavm.com/'),

    // API Zaman Aşımı - API isteklerinin zaman aşımı süresi (saniye)
    'timeout' => env('PTTAVM_TIMEOUT', 30),

    // Hata Ayıklama - Hata ayıklama modu aktif/pasif
    'debug' => env('PTTAVM_DEBUG', false),

    // Önbellek Süresi - API yanıtları için önbellek süresi (dakika olarak)
    'cache_ttl' => env('PTTAVM_CACHE_TTL', 60),

    // Bekleyen Sipariş Kontrol Sıklığı - Cron işlemi için (dakika olarak)
    'order_check_interval' => env('PTTAVM_ORDER_CHECK_INTERVAL', 15),

    // API İstek Oranı - Dakika başına maksimum API isteği sayısı
    'rate_limit' => env('PTTAVM_RATE_LIMIT', 100),

    // API Yanıt Dili - API yanıtlarında kullanılacak dil
    'locale' => env('PTTAVM_LOCALE', 'tr'),

    // Webhook URL - Sipariş bildirimleri ve diğer bildirimler için callback URL
    'webhook_url' => env('PTTAVM_WEBHOOK_URL', null),

    // Webhook Secret - Webhook güvenlik anahtarı
    'webhook_secret' => env('PTTAVM_WEBHOOK_SECRET', null),

    /*
    |--------------------------------------------------------------------------
    | Ürün Ayarları
    |--------------------------------------------------------------------------
    */
    'product' => [
        // Varsayılan ürün komisyon oranı (yüzde)
        'default_commission_rate' => env('PTTAVM_DEFAULT_COMMISSION_RATE', 15),
        
        // Ürün güncelleme aralığı (dakika) - PttAvm'de 20 dakika kısıtlaması var
        'update_interval' => env('PTTAVM_PRODUCT_UPDATE_INTERVAL', 20),
        
        // Otomatik kategori eşleştirme aktif/pasif
        'auto_category_mapping' => env('PTTAVM_AUTO_CATEGORY_MAPPING', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Sipariş Ayarları
    |--------------------------------------------------------------------------
    */
    'order' => [
        // Yeni siparişler için varsayılan durum
        'default_status' => env('PTTAVM_DEFAULT_ORDER_STATUS', 'waiting'),
        
        // Otomatik sipariş onaylama aktif/pasif
        'auto_approve' => env('PTTAVM_AUTO_APPROVE_ORDERS', false),
        
        // Otomatik sipariş reddetme için zaman aşımı (saat)
        'auto_reject_timeout' => env('PTTAVM_AUTO_REJECT_TIMEOUT', 48),
    ],

    /*
    |--------------------------------------------------------------------------
    | Kargo Ayarları
    |--------------------------------------------------------------------------
    */
    'shipping' => [
        // Varsayılan kargo firması
        'default_carrier' => env('PTTAVM_DEFAULT_CARRIER', 'ptt'),
        
        // Kargo entegrasyonu aktif/pasif
        'integration_enabled' => env('PTTAVM_SHIPPING_INTEGRATION', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Log Ayarları
    |--------------------------------------------------------------------------
    */
    'log' => [
        // API isteklerini loglamak aktif/pasif
        'api_requests' => env('PTTAVM_LOG_API_REQUESTS', true),
        
        // API yanıtlarını loglamak aktif/pasif
        'api_responses' => env('PTTAVM_LOG_API_RESPONSES', true),
        
        // Hataları loglamak aktif/pasif
        'errors' => env('PTTAVM_LOG_ERRORS', true),
        
        // Log kanalı
        'channel' => env('PTTAVM_LOG_CHANNEL', 'daily'),
    ],
];
