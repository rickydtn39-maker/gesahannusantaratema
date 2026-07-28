<?php
namespace Gentara\Providers;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Gentara\Core\ServiceProvider;

/**
 * Parallel-Loading Assets & Deferring Manager Provider
 */
class AssetServiceProvider extends ServiceProvider {
    
    public function register() {
        // Tidak membutuhkan binding internal container
    }

    public function boot() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_all_modular_assets' ) );
        add_filter( 'script_loader_tag', array( $this, 'apply_defer_attributes_to_scripts' ), 10, 2 );
    }

    /**
     * Memuat paralel seluruh aset CSS dan skrip JavaScript Gentara secara optimal
     */
    public function enqueue_all_modular_assets() {
        // 1. DAFTARKAN SELURUH MODUL CSS PARALEL (Menghilangkan @import lambat)
        wp_enqueue_style( 'gentara-core-style', get_stylesheet_uri(), array(), GENTARA_VERSION );
        wp_enqueue_style( 'gentara-variables', GENTARA_URI . '/assets/css/variables.css', array(), GENTARA_VERSION );
        wp_enqueue_style( 'gentara-base', GENTARA_URI . '/assets/css/base.css', array( 'gentara-variables' ), GENTARA_VERSION );
        wp_enqueue_style( 'gentara-theme', GENTARA_URI . '/assets/css/theme.css', array( 'gentara-base' ), GENTARA_VERSION );

        // Memuat komponen modular terpisah (Komponen nusantara-slider dibuang demi keamanan asinkron)
        $components = array(
            'ticker', 'dark-mode', 'buttons-forms', 'cards', 
            'single-post', 'comments', 'ads-navigation'
        );
        foreach ( $components as $component ) {
            wp_enqueue_style(
                'gentara-comp-' . $component,
                GENTARA_URI . '/assets/css/components/' . $component . '.css',
                array( 'gentara-theme' ),
                GENTARA_VERSION
            );
        }

        // Memuat CSS Responsif Mobile di barisan akhir
        wp_enqueue_style( 'gentara-responsive', GENTARA_URI . '/assets/css/responsive-mobile.css', array( 'gentara-theme' ), GENTARA_VERSION );

        // 2. DAFTARKAN JAVASCRIPT MODULAR (Header loading untuk theme-toggle guna mencegah kedipan flash visual)
        wp_enqueue_script( 'gentara-theme-toggle', GENTARA_URI . '/assets/js/theme-toggle.js', array(), GENTARA_VERSION, false );
        
        // Memasukkan seluruh script interaktif ke footer dengan filter penundaan (defer)
        $footer_scripts = array(
            'gentara-search-modal' => '/assets/js/search-modal.js',
            'gentara-mobile-nav'   => '/assets/js/mobile-navigation.js',
            'gentara-back-to-top'  => '/assets/js/back-to-top.js',
            'gentara-accordion'    => '/assets/js/accordion.js',
            'gentara-slider-run'   => '/assets/js/nusantara-slider.js',
        );

        foreach ( $footer_scripts as $handle => $path ) {
            wp_enqueue_script( $handle, GENTARA_URI . $path, array(), GENTARA_VERSION, true );
        }

        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
    }

    /**
     * Menyaring output HTML tag script untuk menambahkan atribut defer secara asinkron demi performa Core Web Vitals
     */
    public function apply_defer_attributes_to_scripts( $tag, $handle ) {
        $deferred_handles = array(
            'gentara-search-modal',
            'gentara-mobile-nav',
            'gentara-back-to-top',
            'gentara-accordion',
            'gentara-slider-run'
        );

        if ( in_array( $handle, $deferred_handles, true ) ) {
            return str_replace( ' src', ' defer="defer" src', $tag );
        }
        return $tag;
    }
}