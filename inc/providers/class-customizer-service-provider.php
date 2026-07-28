<?php
namespace Gentara\Providers;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Gentara\Core\ServiceProvider;

/**
 * Modular Theme Customizer Service Provider
 */
class CustomizerServiceProvider extends ServiceProvider {

    /**
     * Memuat modul Customizer utama secara aman
     */
    public function register() {
        require_once GENTARA_DIR . '/inc/customizer/class-customizer.php';
    }

    /**
     * Menjalankan inisialisasi boot
     */
    public function boot() {
        // Seluruh hook wp_head otomatis ditangani secara mandiri oleh masing-masing sub-file kustomizer
    }
}