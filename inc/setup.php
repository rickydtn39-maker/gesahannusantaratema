<?php
/**
 * Setup dasar tema Gesahan News Pro (GDS Volume 5)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'gesahan_news_setup' ) ) :
    function gesahan_news_setup() {
        load_theme_textdomain( 'gesahan-news-pro', get_template_directory() . '/languages' );
        
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );

        // Menambahkan dukungan custom logo gambar
        add_theme_support( 'custom-logo', array(
            'height'      => 48,
            'width'       => 200,
            'flex-height' => true,
            'flex-width'  => true,
        ) );

        // Custom GDS Image Sizes
        add_image_size( 'gesahan-hero', 1200, 675, true ); 
        add_image_size( 'gesahan-standard', 640, 360, true ); 
        add_image_size( 'gesahan-compact', 80, 80, true ); 

        // Navigasi Menu Primer dan Footer
        register_nav_menus( array(
            'primary' => esc_html__( 'Primary Navigation Menu', 'gesahan-news-pro' ),
            'footer'  => esc_html__( 'Footer Navigation Menu', 'gesahan-news-pro' ),
        ) );

        add_theme_support( 'html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script',
        ) );

        add_theme_support( 'align-wide' );
        add_theme_support( 'responsive-embeds' );
    }
endif;
add_action( 'after_setup_theme', 'gesahan_news_setup' );

/**
 * Registrasi Area Widget Sidebar dan Footer Grid
 */
function gesahan_news_widgets_init() {
    
    // 1. Bilah Samping Default (Halaman Artikel/Single & Page)
    register_sidebar( array(
        'name'          => esc_html__( 'Main Sidebar', 'gesahan-news-pro' ),
        'id'            => 'main-sidebar',
        'description'   => esc_html__( 'Tambahkan widget untuk bilah samping kanan halaman artikel di sini.', 'gesahan-news-pro' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s" style="margin-bottom: var(--space-md);">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title" style="font-size: var(--font-size-sm); margin-bottom: var(--space-xs); font-weight: var(--font-weight-bold); border-bottom: 2px solid var(--color-border); padding-bottom: 4px;">',
        'after_title'   => '</h2>',
    ) );

    // 2. BARU: Bilah Samping Khusus Halaman Depan Beranda (Homepage Sidebar)
    register_sidebar( array(
        'name'          => esc_html__( 'Homepage Sidebar', 'gesahan-news-pro' ),
        'id'            => 'homepage-sidebar',
        'description'   => esc_html__( 'Tambahkan widget manual khusus untuk halaman utama beranda di sini. Kosongkan jika ingin memunculkan Terpopuler bawaan.', 'gesahan-news-pro' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s" style="margin-bottom: var(--space-md);">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title" style="font-size: var(--font-size-sm); margin-bottom: var(--space-xs); font-weight: var(--font-weight-bold); border-bottom: 2px solid var(--color-border); padding-bottom: 4px;">',
        'after_title'   => '</h2>',
    ) );

    // Area Widget Mobile
    register_sidebar( array(
        'name'          => esc_html__( 'Mobile Footer Column 1', 'gesahan-news-pro' ),
        'id'            => 'mobile-footer-col-1',
        'description'   => esc_html__( 'Hanya muncul di HP/Tablet pada baris akordeon Tentang Kami.', 'gesahan-news-pro' ),
        'before_widget' => '<div id="%1$s" class="mobile-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '', 
        'after_title'   => '',
    ) );

    // Area Widget Footer Column 1
    register_sidebar( array(
        'name'          => esc_html__( 'Footer Column 1 (Kiri)', 'gesahan-news-pro' ),
        'id'            => 'footer-col-1',
        'description'   => esc_html__( 'Menggantikan deskripsi/badge download bawaan di kolom kiri footer.', 'gesahan-news-pro' ),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="footer-section-title">',
        'after_title'   => '</h3>',
    ) );

    // Area Widget Footer Column 2
    register_sidebar( array(
        'name'          => esc_html__( 'Footer Column 2 (Tengah)', 'gesahan-news-pro' ),
        'id'            => 'footer-col-2',
        'description'   => esc_html__( 'Menggantikan struktur kategori link bawaan di kolom tengah footer.', 'gesahan-news-pro' ),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="footer-section-title">',
        'after_title'   => '</h3>',
    ) );

    // Area Widget Footer Column 3
    register_sidebar( array(
        'name'          => esc_html__( 'Footer Column 3 (Kanan)', 'gesahan-news-pro' ),
        'id'            => 'footer-col-3',
        'description'   => esc_html__( 'Menggantikan daftar ikon media sosial bawaan di kolom kanan footer.', 'gesahan-news-pro' ),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="footer-section-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'gesahan_news_widgets_init' );


/**
 * ==========================================================================
 * AUTOMATIC TAXONOMY INITIALIZER ENGINE
 * ==========================================================================
 */
function ges_init_default_categories() {
    if ( get_option( 'ges_categories_initialized' ) ) {
        return;
    }

    $categories_structure = array(
        'Nasional' => array(
            'Pemerintahan', 'DPR', 'TNI', 'Polri', 'Kebijakan', 'Infrastruktur'
        ),
        'Daerah' => array(
            'Sumatera' => array(
                'Aceh', 'Sumatera Utara', 'Sumatera Barat', 'Riau', 'Kepulauan Riau', 'Jambi', 'Bengkulu', 'Sumatera Selatan', 'Bangka Belitung', 'Lampung'
            ),
            'Jawa' => array(
                'DKI Jakarta', 'Banten', 'Jawa Barat', 'Jawa Tengah', 'DI Yogyakarta', 'Jawa Timur'
            ),
            'Kalimantan' => array(
                'Kalimantan Barat', 'Kalimantan Tengah', 'Kalimantan Selatan', 'Kalimantan Timur', 'Kalimantan Utara'
            ),
            'Sulawesi' => array(
                'Sulawesi Utara', 'Gorontalo', 'Sulawesi Tengah', 'Sulawesi Barat', 'Sulawesi Selatan', 'Sulawesi Tenggara'
            ),
            'Bali & Nusa Tenggara' => array(
                'Bali', 'Nusa Tenggara Barat', 'Nusa Tenggara Timur'
            ),
            'Maluku' => array(
                'Maluku', 'Maluku Utara'
            ),
            'Papua' => array(
                'Papua', 'Papua Barat', 'Papua Tengah', 'Papua Selatan', 'Papua Pegunungan', 'Papua Barat Daya'
            )
        ),
        'Internasional' => array(),
        'Hukum' => array(
            'Kriminal', 'Pengadilan', 'Kejaksaan', 'Kepolisian', 'Korupsi', 'Narkoba'
        ),
        'Politik' => array(
            'Pilkada', 'Pemilu', 'DPR', 'Pemerintah', 'Partai Politik'
        ),
        'Ekonomi' => array(
            'Bisnis', 'UMKM', 'Investasi', 'Keuangan', 'Perbankan', 'Energi'
        ),
        'Olahraga' => array(
            'Sepak Bola', 'Liga Indonesia', 'Timnas', 'MotoGP', 'Formula 1', 'Badminton', 'Basket', 'Voli', 'Padel', 'Olahraga Lainnya'
        ),
        'Lifestyle' => array(
            'Travel', 'Kuliner', 'Fashion', 'Otomotif', 'Komunitas'
        ),
        'Opini' => array(
            'Editorial', 'Kolom', 'Analisis'
        )
    );

    foreach ( $categories_structure as $parent_name => $sub_level_1 ) {
        $parent_id = ges_create_category_safe( $parent_name, 0 );

        if ( ! empty( $sub_level_1 ) ) {
            foreach ( $sub_level_1 as $child_key => $child_val ) {
                if ( is_array( $child_val ) ) {
                    $region_id = ges_create_category_safe( $child_key, $parent_id );
                    foreach ( $child_val as $province_name ) {
                        ges_create_category_safe( $province_name, $region_id );
                    }
                } else {
                    ges_create_category_safe( $child_val, $parent_id );
                }
            }
        }
    }

    update_option( 'ges_categories_initialized', true );
}
add_action( 'after_switch_theme', 'ges_init_default_categories' );

function ges_create_category_safe( $name, $parent_id = 0 ) {
    $term = term_exists( $name, 'category', $parent_id );
    if ( ! $term ) {
        $inserted = wp_insert_term( $name, 'category', array(
            'parent' => $parent_id,
            'slug'   => sanitize_title( $name )
        ) );
        if ( ! is_wp_error( $inserted ) ) {
            return $inserted['term_id'];
        }
    } else {
        return is_array( $term ) ? $term['term_id'] : $term;
    }
    return 0;
}