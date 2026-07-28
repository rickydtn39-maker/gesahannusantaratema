<?php
/**
 * Konfigurasi Customizer Sistem Tipografi Lanjut - Gesahan News Pro
 *
 * @package Gesahan_News_Pro
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function gesahan_customize_typography( $wp_customize ) {
    $wp_customize->add_section( 'ges_typo_section', array(
        'title'    => esc_html__( 'Sistem Tipografi', 'gesahan-news-pro' ),
        'panel'    => 'gesahan_theme_options',
        'priority' => 20,
    ));

    // ==========================================
    // 1. SELECTOR JENIS FONT PRIMER
    // ==========================================
    $wp_customize->add_setting( 'ges_font_family_selection', array(
        'default'           => 'sans',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'ges_font_family_ctrl', array(
        'label'       => esc_html__( 'Gaya Font Utama', 'gesahan-news-pro' ),
        'description' => esc_html__( 'Sistem akan otomatis memuat aset Google Fonts jika Anda memilih opsi font eksternal.', 'gesahan-news-pro' ),
        'section'     => 'ges_typo_section',
        'settings'    => 'ges_font_family_selection',
        'type'        => 'select',
        'choices'     => array(
            'sans'         => esc_html__( 'System Sans-serif (Cepat & Ringan)', 'gesahan-news-pro' ),
            'serif'        => esc_html__( 'Georgia Serif (Klasik & Elegan)', 'gesahan-news-pro' ),
            'condensed'    => esc_html__( 'Condensed Bold (Rapat Khas Detik/CNN)', 'gesahan-news-pro' ),
            'inter'        => esc_html__( 'Inter (Modern & Minimalis - Google Font)', 'gesahan-news-pro' ),
            'roboto'       => esc_html__( 'Roboto (Bersih & Universal - Google Font)', 'gesahan-news-pro' ),
            'merriweather' => esc_html__( 'Merriweather (Premium Editorial - Google Font)', 'gesahan-news-pro' ),
            'playfair'     => esc_html__( 'Playfair Display (Mewah & Klasik - Google Font)', 'gesahan-news-pro' ),
        ),
    ));

    // ==========================================
    // 2. SLIDER UKURAN FONT (BASE & HEADING)
    // ==========================================
    $wp_customize->add_setting( 'ges_font_size_base_val', array(
        'default'           => 16,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control( 'ges_font_size_base_val_ctrl', array(
        'label'       => esc_html__( 'Ukuran Teks Berita (Pixel)', 'gesahan-news-pro' ),
        'description' => esc_html__( 'Menentukan ukuran font pada isi naskah berita / paragraf.', 'gesahan-news-pro' ),
        'section'     => 'ges_typo_section',
        'settings'    => 'ges_font_size_base_val',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 14,
            'max'  => 24,
            'step' => 1,
        ),
    ));

    $wp_customize->add_setting( 'ges_font_size_heading_val', array(
        'default'           => 28,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control( 'ges_font_size_heading_val_ctrl', array(
        'label'       => esc_html__( 'Ukuran Judul Utama (Pixel)', 'gesahan-news-pro' ),
        'description' => esc_html__( 'Menentukan ukuran font pada tajuk berita utama / h1.', 'gesahan-news-pro' ),
        'section'     => 'ges_typo_section',
        'settings'    => 'ges_font_size_heading_val',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 20,
            'max'  => 48,
            'step' => 1,
        ),
    ));

    // ==========================================
    // 3. KETEBALAN FONT (FONT WEIGHT CONTROLS)
    // ==========================================
    $wp_customize->add_setting( 'ges_body_font_weight', array(
        'default'           => '400',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'ges_body_font_weight_ctrl', array(
        'label'    => esc_html__( 'Ketebalan Teks Berita (Body)', 'gesahan-news-pro' ),
        'section'  => 'ges_typo_section',
        'settings' => 'ges_body_font_weight',
        'type'     => 'select',
        'choices'  => array(
            '400' => esc_html__( '400 - Normal (Rekomendasi)', 'gesahan-news-pro' ),
            '500' => esc_html__( '500 - Medium (Sedikit Tebal)', 'gesahan-news-pro' ),
            '700' => esc_html__( '700 - Bold (Tebal)', 'gesahan-news-pro' ),
        ),
    ));

    $wp_customize->add_setting( 'ges_heading_font_weight', array(
        'default'           => '900',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'ges_heading_font_weight_ctrl', array(
        'label'    => esc_html__( 'Ketebalan Judul Berita (Heading)', 'gesahan-news-pro' ),
        'section'  => 'ges_typo_section',
        'settings' => 'ges_heading_font_weight',
        'type'     => 'select',
        'choices'  => array(
            '700' => esc_html__( '700 - Bold (Tebal Standard)', 'gesahan-news-pro' ),
            '800' => esc_html__( '800 - Extra Bold (Sangat Tebal)', 'gesahan-news-pro' ),
            '900' => esc_html__( '900 - Black (Tebal Solid Maksimal)', 'gesahan-news-pro' ),
        ),
    ));

    // ==========================================
    // 4. GAYA FONT (FONT STYLE: NORMAL / ITALIC)
    // ==========================================
    $wp_customize->add_setting( 'ges_body_font_style', array(
        'default'           => 'normal',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'ges_body_font_style_ctrl', array(
        'label'    => esc_html__( 'Gaya Cetak Teks Berita (Body)', 'gesahan-news-pro' ),
        'section'  => 'ges_typo_section',
        'settings' => 'ges_body_font_style',
        'type'     => 'select',
        'choices'  => array(
            'normal' => esc_html__( 'Normal (Tegak)', 'gesahan-news-pro' ),
            'italic' => esc_html__( 'Italic (Miring)', 'gesahan-news-pro' ),
        ),
    ));

    $wp_customize->add_setting( 'ges_heading_font_style', array(
        'default'           => 'normal',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'ges_heading_font_style_ctrl', array(
        'label'    => esc_html__( 'Gaya Cetak Judul Berita (Heading)', 'gesahan-news-pro' ),
        'section'  => 'ges_typo_section',
        'settings' => 'ges_heading_font_style',
        'type'     => 'select',
        'choices'  => array(
            'normal' => esc_html__( 'Normal (Tegak)', 'gesahan-news-pro' ),
            'italic' => esc_html__( 'Italic (Miring)', 'gesahan-news-pro' ),
        ),
    ));

    // ==========================================
    // 5. KERAPATAN JARAK BARIS (LINE HEIGHT)
    // ==========================================
    $wp_customize->add_setting( 'ges_line_height_base_val', array(
        'default'           => 1.6,
        'sanitize_callback' => 'floatval',
    ));
    $wp_customize->add_control( 'ges_line_height_base_val_ctrl', array(
        'label'       => esc_html__( 'Kerapatan Jarak Baris Paragraf', 'gesahan-news-pro' ),
        'section'     => 'ges_typo_section',
        'settings'    => 'ges_line_height_base_val',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 1.3,
            'max'  => 1.9,
            'step' => 0.1,
        ),
    ));
}

/**
 * AUTOMATIC LOADER: Mengunduh Google Fonts API secara asinkron di Head berdasarkan setting terpilih
 */
function ges_load_google_fonts() {
    $family = get_theme_mod( 'ges_font_family_selection', 'sans' );
    $fonts_url = '';

    switch ( $family ) {
        case 'inter':
            $fonts_url = 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800;900&display=swap';
            break;
        case 'roboto':
            $fonts_url = 'https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400&display=swap';
            break;
        case 'merriweather':
            $fonts_url = 'https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,400;0,700;0,900;1,400&display=swap';
            break;
        case 'playfair':
            $fonts_url = 'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&display=swap';
            break;
    }

    if ( ! empty( $fonts_url ) ) {
        echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
        echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
        echo '<link href="' . esc_url( $fonts_url ) . '" rel="stylesheet">' . "\n";
    }
}
add_action( 'wp_head', 'ges_load_google_fonts', 1 );

/**
 * INJEKSI CSS TIPOGRAFI DINAMIS DI HEAD (Merespons Instan Perubahan Slider)
 */
function ges_inject_dynamic_typography_css() {
    $family        = get_theme_mod( 'ges_font_family_selection', 'sans' );
    $size_base     = (int) get_theme_mod( 'ges_font_size_base_val', 16 );
    $size_head     = (int) get_theme_mod( 'ges_font_size_heading_val', 28 );
    $line_height   = floatval( get_theme_mod( 'ges_line_height_base_val', 1.6 ) );
    
    // Konfigurasi ketebalan & gaya
    $body_weight   = sanitize_text_field( get_theme_mod( 'ges_body_font_weight', '400' ) );
    $head_weight   = sanitize_text_field( get_theme_mod( 'ges_heading_font_weight', '900' ) );
    $body_style    = sanitize_text_field( get_theme_mod( 'ges_body_font_style', 'normal' ) );
    $head_style    = sanitize_text_field( get_theme_mod( 'ges_heading_font_style', 'normal' ) );

    // Tentukan String CSS Font Family
    $font_css = 'var(--font-sans)';
    if ( 'serif' === $family ) {
        $font_css = 'var(--font-serif)';
    } elseif ( 'condensed' === $family ) {
        $font_css = 'var(--font-condensed)';
    } elseif ( 'inter' === $family ) {
        $font_css = '"Inter", var(--font-sans)';
    } elseif ( 'roboto' === $family ) {
        $font_css = '"Roboto", var(--font-sans)';
    } elseif ( 'merriweather' === $family ) {
        $font_css = '"Merriweather", var(--font-serif)';
    } elseif ( 'playfair' === $family ) {
        $font_css = '"Playfair Display", var(--font-serif)';
    }

    echo "\n<style id='ges-dynamic-typography'>\n";
    echo "  :root {\n";
    echo "    --font-sans: " . $font_css . " !important;\n";
    echo "    --font-size-base: " . esc_attr($size_base) . "px !important;\n";
    echo "    --font-size-lg: " . esc_attr($size_head) . "px !important;\n";
    echo "    --line-height-normal: " . esc_attr($line_height) . " !important;\n";
    echo "    --font-weight-regular: " . esc_attr($body_weight) . " !important;\n";
    echo "    --font-weight-bold: " . esc_attr($head_weight) . " !important;\n";
    echo "  }\n";
    
    // Aplikasikan gaya miring/tegak ke elemen global secara presisi
    echo "  body, p, .gn-single-content p, .gds-card-excerpt {\n";
    echo "    font-style: " . esc_attr($body_style) . " !important;\n";
    echo "    font-weight: " . esc_attr($body_weight) . " !important;\n";
    echo "  }\n";
    echo "  h1, h2, h3, h4, h5, h6, .gn-hero-title, .gds-card-title, .gn-list-title, .terpopuler-title {\n";
    echo "    font-style: " . esc_attr($head_style) . " !important;\n";
    echo "    font-weight: " . esc_attr($head_weight) . " !important;\n";
    echo "  }\n";
    echo "</style>\n";
}
add_action( 'wp_head', 'ges_inject_dynamic_typography_css', 12 );