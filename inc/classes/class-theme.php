<?php
namespace Gentara\Core;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Memuat dependensi inti secara mutlak menggunakan native PHP relative path
require_once dirname( __DIR__ ) . '/providers/class-container.php';
require_once dirname( __DIR__ ) . '/providers/class-service-provider.php';
require_once dirname( __DIR__ ) . '/providers/class-breadcrumb.php';
require_once dirname( __DIR__ ) . '/providers/class-pagination.php';
require_once dirname( __DIR__ ) . '/providers/class-mega-menu.php';

/**
 * Enterprise Theme Bootstrap & Core Controller (Singleton)
 *
 * Folder classes/ ini dikunci secara ketat hanya memiliki 1 file ini saja.
 * Menggunakan sistem Explicit Mapping untuk memuat Service Provider secara instan dan aman.
 */
final class Theme {
    /**
     * Instansi tunggal Theme
     * @var Theme|null
     */
    private static $instance = null;

    /**
     * Kontainer manajemen dependensi aplikasi
     * @var Container
     */
    private $container;

    /**
     * Explicit Mapping: Mendaftarkan Class Namespace langsung ke nama file fisiknya.
     * Sistem ini jauh lebih cepat, stabil, dan aman dari kegagalan kompilasi path.
     * @var array
     */
    private $providers = array(
        \Gentara\Providers\QueryServiceProvider::class       => 'class-query-service-provider.php',
        \Gentara\Providers\AssetServiceProvider::class       => 'class-asset-service-provider.php',
        \Gentara\Providers\CustomizerServiceProvider::class  => 'class-customizer-service-provider.php',
        \Gentara\Providers\SEOServiceProvider::class         => 'class-seo-service-provider.php',
        \Gentara\Providers\PerformanceServiceProvider::class => 'class-performance-service-provider.php',
        \Gentara\Providers\WidgetServiceProvider::class      => 'class-widget-service-provider.php',
    );

    /**
     * Memanggil instansi tunggal Theme
     */
    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Konstruktor privat
     */
    private function __construct() {
        $this->load_theme_helpers();
        $this->container = new Container();
        $this->backward_compatibility_bridge();
        $this->register_service_providers();
        $this->boot_service_providers();
    }

    /**
     * CLASS ALIASING BRIDGE: Menjamin template lama yang memakai namespace \GDS\Classes\* tidak rusak
     */
    private function backward_compatibility_bridge() {
        if ( ! class_exists( '\GDS\Classes\Breadcrumb' ) ) {
            class_alias( \Gentara\Core\Breadcrumb::class, '\GDS\Classes\Breadcrumb' );
        }
        if ( ! class_exists( '\GDS\Classes\Pagination' ) ) {
            class_alias( \Gentara\Core\Pagination::class, '\GDS\Classes\Pagination' );
        }
        if ( ! class_exists( '\GDS\Classes\MegaMenuWalker' ) ) {
            class_alias( \Gentara\Core\MegaMenuWalker::class, '\GDS\Classes\MegaMenuWalker' );
        }
    }

    /**
     * Memuat file procedural helpers dari folder inc/ menggunakan native path absolut
     */
    private function load_theme_helpers() {
        require_once dirname( __DIR__ ) . '/setup.php';
        require_once dirname( __DIR__ ) . '/category-bootstrap.php';
        require_once dirname( __DIR__ ) . '/template-tags.php';
        require_once dirname( __DIR__ ) . '/ads-helper.php';
        require_once dirname( __DIR__ ) . '/api-hooks.php';
        require_once dirname( __DIR__ ) . '/seeder.php';
    }

    /**
     * Mendaftarkan seluruh Service Provider ke Container berdasarkan Explicit Map
     */
    private function register_service_providers() {
        foreach ( $this->providers as $provider_class => $file_name ) {
            $file_path = dirname( __DIR__ ) . '/providers/' . $file_name;
            
            if ( file_exists( $file_path ) ) {
                require_once $file_path;
            } else {
                wp_die( sprintf( esc_html__( 'Berkas Service Provider tidak ditemukan: %s', 'gentara-news' ), esc_html( $file_name ) ) );
            }

            $provider_instance = new $provider_class( $this->container );
            $provider_instance->register();
            $this->container->bind( $provider_class, function() use ( $provider_instance ) {
                return $provider_instance;
            }, true );
        }
    }

    /**
     * Menjalankan fungsi boot di seluruh Service Provider yang terdaftar
     */
    private function boot_service_providers() {
        foreach ( array_keys( $this->providers ) as $provider_class ) {
            $provider_instance = $this->container->make( $provider_class );
            $provider_instance->boot();
        }
    }

    /**
     * Mendapatkan objek Container
     */
    public function get_container() {
        return $this->container;
    }
}