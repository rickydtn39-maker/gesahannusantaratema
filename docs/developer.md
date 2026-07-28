# Panduan Pengembang (Developer Extensibility Guide)

Gesahan News Pro dirancang berbasis OOP (Object Oriented Programming) serta sistem penamaan hook (Volume 7) untuk memudahkan pengembang melakukan override tanpa memodifikasi core file tema.

## Lokasi Event Hooks:
*   `gesahan_before_header` : Dipanggil tepat sebelum visual elemen header dirender.
*   `gesahan_after_header`  : Dipanggil setelah elemen navigasi header selesai dimuat.

## Contoh Filter Hook PHP (override warna aksen via Plugin/Child Theme):
```php
add_filter('gesahan_card_title', function($title) {
    return '★ ' . $title;
});