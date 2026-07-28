<?php
namespace Gentara\Providers;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Gentara\Core\ServiceProvider;

/**
 * High-End Metadata & Modular Schema SEO Provider
 */
class SEOServiceProvider extends ServiceProvider {

    public function register() {
        require_once GENTARA_DIR . '/inc/seo/class-seo.php';
    }

    public function boot() {
        // Diinisialisasi secara modular dalam kelas SEOEngine internal
    }
}