<?php
namespace Gentara\Providers;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Gentara\Core\ServiceProvider;

/**
 * Core Widgets Autoloader & Registration Service Provider
 */
class WidgetServiceProvider extends ServiceProvider {

    /**
     * Mendaftarkan dan memuat seluruh berkas kelas widget secara mutlak
     */
    public function register() {
        $widget_dir = dirname( __DIR__ ) . '/widgets/';

        // Memuat fisik file secara aman dan kebal dari Local WP Symlink error
        require_once $widget_dir . 'class-widget-popular.php';
        require_once $widget_dir . 'class-widget-latest.php';
        require_once $widget_dir . 'class-widget-editor-choice.php';
        require_once $widget_dir . 'class-widget-ads.php';
    }

    public function boot() {
        add_action( 'widgets_init', array( $this, 'register_gentara_core_widgets' ) );
    }

    /**
     * Mendaftarkan seluruh widget kustom ke dalam sistem WordPress
     */
    public function register_gentara_core_widgets() {
        register_widget( '\Gentara\Widgets\Popular' );
        register_widget( '\Gentara\Widgets\Latest' );
        register_widget( '\Gentara\Widgets\EditorChoice' );
        register_widget( '\Gentara\Widgets\Ads' );
    }
}