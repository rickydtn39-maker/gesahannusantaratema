<?php
namespace Gentara\Providers;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Gentara\Core\ServiceProvider;

/**
 * Performance Optimizer Service Provider
 */
class PerformanceServiceProvider extends ServiceProvider {

    public function register() {
        require_once GENTARA_DIR . '/inc/performance/class-performance.php';
    }

    public function boot() {
        // Diinisialisasi secara modular dalam kelas PerformanceEngine internal
    }
}