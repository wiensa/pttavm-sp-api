# PttAvm Pazaryeri API Laravel Paketi

Bu paket, PttAvm Pazaryeri API'si ile entegrasyon sağlayan Laravel 10+ uyumlu bir pakettir. Bu paket sayesinde PttAvm Pazaryeri'nde ürün, sipariş, kategori ve diğer API servislerini kolayca kullanabilirsiniz.

## Özellikler

- PttAvm pazaryerine ürün yükleme ve güncelleme
- Sipariş ve kargo yönetimi
- Kategori ve varyasyon yönetimi
- Stok ve fiyat güncelleme
- Sipariş durumlarını izleme
- Ürün varyantları ve marka yönetimi
- Komisyon oranları ve hesaplamaları
- Detaylı raporlama ve analiz
- Mağaza bilgilerini yönetme

## Kurulum

Composer aracılığıyla paketi projenize ekleyin:

```bash
composer require wiensa/pttavm-sp-api
```

Laravel 5.5+ sürümlerinde otomatik servis provider keşfi sayesinde ayrıca servis provider eklemenize gerek yoktur.

Eğer otomatik keşif özelliğini kullanmak istemiyorsanız, servis provider'ı ve facade'ı manuel olarak kaydedebilirsiniz:

```php
// config/app.php
'providers' => [
    // ...
    PttavmApi\PttavmSpApi\PttAvmServiceProvider::class,
],

'aliases' => [
    // ...
    'PttAvm' => PttavmApi\PttavmSpApi\Facades\PttAvm::class,
],
```

Konfigürasyon dosyasını yayınlamak için aşağıdaki komutu çalıştırın:

```bash
php artisan vendor:publish --provider="PttavmApi\PttavmSpApi\PttAvmServiceProvider" --tag="config"
```

## Yapılandırma

`config/pttavm.php` dosyasını aşağıdaki PttAvm API bilgileriniz ile düzenleyin:

```php
return [
    'username' => env('PTTAVM_USERNAME', ''),
    'password' => env('PTTAVM_PASSWORD', ''),
    'shop_id' => env('PTTAVM_SHOP_ID', ''),
    'api_url' => env('PTTAVM_API_URL', 'https://api.epttavm.com/'),
    'timeout' => env('PTTAVM_TIMEOUT', 30),
    'debug' => env('PTTAVM_DEBUG', false),
];
```

`.env` dosyanıza aşağıdaki bilgileri ekleyin:

```
PTTAVM_USERNAME=kullanici_adi
PTTAVM_PASSWORD=sifre
PTTAVM_SHOP_ID=magaza_id
PTTAVM_API_URL=https://api.epttavm.com/
PTTAVM_TIMEOUT=30
PTTAVM_DEBUG=false
```

## Kullanım

### Yeni Ürün Ekleme

```php
use PttavmApi\PttavmSpApi\Facades\PttAvm;

$product = [
    'barcode' => '123456789', 
    'title' => 'Ürün Adı',
    'description' => 'Ürün açıklaması',
    'price' => 100.00,
    'stock' => 10,
    'category_id' => 123,
    // Diğer ürün bilgileri
];

$result = PttAvm::product()->create($product);
```

### Ürün Güncelleme

```php
use PttavmApi\PttavmSpApi\Facades\PttAvm;

$product = [
    'barcode' => '123456789',
    'price' => 110.00,
    'stock' => 15,
    // Diğer güncellenecek alanlar
];

$result = PttAvm::product()->update($product);
```

### Sipariş Listeleme

```php
use PttavmApi\PttavmSpApi\Facades\PttAvm;

// Bekleyen siparişleri listeleme
$orders = PttAvm::order()->getList(['status' => 'waiting']);

// Tarih aralığına göre sipariş listeleme
$startDate = '2024-01-01';
$endDate = '2024-01-31';
$orders = PttAvm::order()->getList([
    'start_date' => $startDate,
    'end_date' => $endDate
]);
```

### Sipariş Detayı

```php
use PttavmApi\PttavmSpApi\Facades\PttAvm;

$orderNumber = 'SIPARIS123';
$orderDetail = PttAvm::order()->getDetail($orderNumber);
```

### Kategori Listesi

```php
use PttavmApi\PttavmSpApi\Facades\PttAvm;

$categories = PttAvm::category()->getList();
```

### Varyant İşlemleri

```php
use PttavmApi\PttavmSpApi\Facades\PttAvm;

// Ürün varyantlarını listeleme
$variants = PttAvm::variant()->getList('123456789');

// Varyant ekleme
$variant = [
    'barcode' => 'VARYANT123',
    'title' => 'Varyant Adı',
    'price' => 95.00,
    'stock' => 5,
    'attributes' => [
        'color' => 'Kırmızı',
        'size' => 'XL'
    ]
];
$result = PttAvm::variant()->create('123456789', $variant);

// Varyant stok güncelleme
$result = PttAvm::variant()->updateStock('123456789', 'VARYANT123', 10);
```

### Komisyon İşlemleri

```php
use PttavmApi\PttavmSpApi\Facades\PttAvm;

// Kategori komisyon oranı sorgulama
$commissionRate = PttAvm::commission()->getCategoryRate(123);

// Komisyon hesaplama
$calculation = PttAvm::commission()->calculate(100.00, 123);
```

### Marka İşlemleri

```php
use PttavmApi\PttavmSpApi\Facades\PttAvm;

// Marka listesi
$brands = PttAvm::brand()->getList();

// Kategori bazlı marka listesi
$categoryBrands = PttAvm::brand()->getListByCategory(123);

// Marka arama
$searchResults = PttAvm::brand()->search('Apple');
```

### Rapor İşlemleri

```php
use PttavmApi\PttavmSpApi\Facades\PttAvm;

// Satış raporu
$salesReport = PttAvm::report()->getSales('2024-01-01', '2024-01-31');

// Stok raporu
$stockReport = PttAvm::report()->getStock();

// Özel rapor
$customReport = PttAvm::report()->requestCustom('sales', '2024-01-01', '2024-01-31', 'excel');
```

### Mağaza İşlemleri

```php
use PttavmApi\PttavmSpApi\Facades\PttAvm;

// Mağaza bilgileri
$storeInfo = PttAvm::store()->getInfo();

// Mağaza performans
$performance = PttAvm::store()->getPerformance('2024-01-01', '2024-01-31');

// Mağaza istatistikleri
$statistics = PttAvm::store()->getStatistics();
```

## Hata Yönetimi

API isteklerinde oluşabilecek hataları yakalamak için try-catch bloğu kullanılması önerilir:

```php
use PttavmApi\PttavmSpApi\Exceptions\PttAvmException;

try {
    $result = PttAvm::product()->create($product);
} catch (PttAvmException $e) {
    // Hata mesajını görüntüleme
    echo $e->getMessage();
    
    // Hata kodunu alma
    $errorCode = $e->getCode();
    
    // Varsa orijinal API yanıtını alma
    $response = $e->getResponse();
}
```

## Lisans

Bu paket MIT lisansı altında lisanslanmıştır. Daha fazla bilgi için [LICENSE](LICENSE) dosyasına bakınız.
