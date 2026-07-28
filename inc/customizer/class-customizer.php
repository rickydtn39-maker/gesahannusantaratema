<?php
namespace Gentara\Customizer;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Enterprise Customizer Modular Framework Controller
 *
 * Seluruh sub-file kustomizer dimuat langsung di dalam constructor 
 * agar fungsi injeksi CSS visual selalu didefinisikan baik di frontend maupun backend.
 */
class Customizer {
    public function __construct() {
        // Load seluruh sub-file konfigurasi secara global demi keamanan FCP/LCP dan fungsi Head
        require_once GENTARA_DIR . '/inc/customizer/colors.php';
        require_once GENTARA_DIR . '/inc/customizer/typography.php';
        require_once GENTARA_DIR . '/inc/customizer/styling.php';
        require_once GENTARA_DIR . '/inc/customizer/header.php';
        require_once GENTARA_DIR . '/inc/customizer/mobile.php';
        require_once GENTARA_DIR . '/inc/customizer/homepage.php';
        require_once GENTARA_DIR . '/inc/customizer/single.php';
        require_once GENTARA_DIR . '/inc/customizer/ads.php';
        require_once GENTARA_DIR . '/inc/customizer/performance.php';
        require_once GENTARA_DIR . '/inc/customizer/footer.php';

        add_action( 'customize_register', array( $this, 'register_modular_sections' ) );
    }

    /**
     * Mendaftarkan panel, section, dan kontrol ke sistem Customizer WordPress
     */
    public function register_modular_sections( $wp_customize ) {
        // Daftarkan Panel Utama Gentara News Settings
        $wp_customize->add_panel( 'gesahan_theme_options', array(
            'title'       => esc_html__( 'Gentara News Settings', 'gentara-news' ),
            'priority'    => 30,
            'description' => esc_html__( 'Kelola seluruh setelan portal berita Anda.', 'gentara-news' ),
        ));

        // Inisialisasi kontrol modular kustomizer
        gesahan_customize_colors( $wp_customize );
        gesahan_customize_typography( $wp_customize );
        gesahan_customize_styling( $wp_customize );
        gesahan_customize_header( $wp_customize );
        gesahan_customize_mobile( $wp_customize );
        gesahan_customize_homepage( $wp_customize );
        gesahan_customize_single( $wp_customize );
        gesahan_customize_ads( $wp_customize );
        gesahan_customize_performance( $wp_customize );
        gesahan_customize_footer( $wp_customize );
    }
}

new Customizer();