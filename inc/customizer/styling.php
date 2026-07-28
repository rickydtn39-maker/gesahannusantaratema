<?php
/**
 * Konfigurasi Customizer Desain Visual & Kelengkungan Kartu - Gentara News Pro
 *
 * @package Gentara_News
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function gesahan_customize_styling( $wp_customize ) {
    $wp_customize->add_section( 'ges_styling_section', array(
        'title'    => esc_html__( 'Desain & Kelengkungan Kartu', 'gentara-news' ),
        'panel'    => 'gesahan_theme_options',
        'priority' => 22,
    ));

    // 1. Selector Potongan Kelengkungan Kartu
    $wp_customize->add_setting( 'ges_card_shape', array(
        'default'           => 'sharp',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'ges_card_shape_ctrl', array(
        'label'       => esc_html__( 'Bentuk Sudut Kartu', 'gentara-news' ),
        'description' => esc_html__( 'Tentukan bentuk potongan sudut untuk seluruh elemen kartu berita di website.', 'gentara-news' ),
        'section'     => 'ges_styling_section',
        'settings'    => 'ges_card_shape',
        'type'        => 'select',
        'choices'     => array(
            'sharp'              => esc_html__( 'Sharp Kotak Sempurna (0px)', 'gentara-news' ),
            'rounded'            => esc_html__( 'Uniform Rounded (Membulat Rata)', 'gentara-news' ),
            'asymmetric'         => esc_html__( 'CNN Asymmetric (Kanan-Atas & Kiri-Bawah)', 'gentara-news' ),
            'asymmetric-inverse' => esc_html__( 'Inverse Asymmetric (Kiri-Atas & Kanan-Bawah)', 'gentara-news' ),
        ),
    ));

    // 2. Ketebalan Nilai Sudut (Radius Value Slider)
    $wp_customize->add_setting( 'ges_card_radius', array(
        'default'           => 0,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control( 'ges_card_radius_ctrl', array(
        'label'       => esc_html__( 'Ketebalan Kelengkungan (Pixel)', 'gentara-news' ),
        'section'     => 'ges_styling_section',
        'settings'    => 'ges_card_radius',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 40,
            'step' => 1,
        ),
    ));

    // 3. Kontrol Ukuran Kartu Global
    $wp_customize->add_setting( 'ges_card_size_global', array(
        'default'           => 'medium',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'ges_card_size_global_ctrl', array(
        'label'       => esc_html__( 'Ukuran Kartu Berita', 'gentara-news' ),
        'section'     => 'ges_styling_section',
        'settings'    => 'ges_card_size_global',
        'type'     => 'select',
        'choices'  => array(
            'small'  => esc_html__( 'Kecil (Kompak)', 'gentara-news' ),
            'medium' => esc_html__( 'Sedang (Standard)', 'gentara-news' ),
            'large'  => esc_html__( 'Besar (Lebar)', 'gentara-news' ),
        ),
    ));

    // 4. Kontrol Rasio Aspek Gambar
    $wp_customize->add_setting( 'ges_card_aspect_ratio', array(
        'default'           => '16/9',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'ges_card_aspect_ratio_ctrl', array(
        'label'       => esc_html__( 'Rasio Aspek Gambar', 'gentara-news' ),
        'section'     => 'ges_styling_section',
        'settings'    => 'ges_card_aspect_ratio',
        'type'     => 'select',
        'choices'  => array(
            '16/9' => esc_html__( '16:9 Sinematik (Detik Style)', 'gentara-news' ),
            '4/3'  => esc_html__( '4:3 Klasik (Televisi)', 'gentara-news' ),
            '1/1'  => esc_html__( '1:1 Kotak Sempurna', 'gentara-news' ),
            '21/9' => esc_html__( '21:9 Ultra-Wide', 'gentara-news' ),
        ),
    ));

    // 5. Kontrol Arah Aliran Layout Aliran (Grid / List)
    $wp_customize->add_setting( 'ges_latest_layout_direction', array(
        'default'           => 'horizontal',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'ges_latest_layout_direction_ctrl', array(
        'label'       => esc_html__( 'Sumbu Arah Aliran Berita', 'gentara-news' ),
        'section'     => 'ges_styling_section',
        'settings'    => 'ges_latest_layout_direction',
        'type'     => 'select',
        'choices'  => array(
            'horizontal' => esc_html__( 'Horizontal (Gambar Kanan - Detik Style)', 'gentara-news' ),
            'vertical'   => esc_html__( 'Vertikal Grid (Gambar Atas - Box Style)', 'gentara-news' ),
        ),
    ));

    // 6. Efek Visual Kartu (Card Accent Style)
    $wp_customize->add_setting( 'ges_card_accent', array(
        'default'           => 'flat',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'ges_card_accent_ctrl', array(
        'label'       => esc_html__( 'Gaya Efek Visual Kartu', 'gentara-news' ),
        'section'     => 'ges_styling_section',
        'settings'    => 'ges_card_accent',
        'type'        => 'select',
        'choices'     => array(
            'flat'           => esc_html__( 'Flat (Datar Minimalis)', 'gentara-news' ),
            'light-gradient' => esc_html__( 'Light Gradient (Gradien Mewah Tipis)', 'gentara-news' ),
            'subtle-border'  => esc_html__( 'Border Outline (Garis Tepi Rapih)', 'gentara-news' ),
            'subtle-shadow'  => esc_html__( 'Subtle Shadow (Melayang Lembut saat Dihover)', 'gentara-news' ),
        ),
    ));

    // ==========================================================================
    // SEGMEN CONTROLS BARU: UKURAN, RASIO, DAN OVERLAY POSISI JUDUL MANUAL
    // ==========================================================================

    // A. Rasio Lebar Gambar pada List Card (Mencegah Judul Terlalu Sempit)
    $wp_customize->add_setting( 'ges_list_thumb_width_pct', array(
        'default'           => 35,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control( 'ges_list_thumb_width_pct_ctrl', array(
        'label'       => esc_html__( 'Rasio Lebar Gambar List Card (%)', 'gentara-news' ),
        'description' => esc_html__( 'Mengecilkan nilai ini akan memperluas area teks/judul agar tidak sempit wrap satu kata.', 'gentara-news' ),
        'section'     => 'ges_styling_section',
        'settings'    => 'ges_list_thumb_width_pct',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 20,
            'max'  => 60,
            'step' => 1,
        ),
    ));

    // B. Posisi Judul: Di Luar/Samping Gambar atau Di Dalam Gambar (Overlay)
    $wp_customize->add_setting( 'ges_card_title_position', array(
        'default'           => 'beside',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'ges_card_title_position_ctrl', array(
        'label'       => esc_html__( 'Penempatan Judul Berita', 'gentara-news' ),
        'section'     => 'ges_styling_section',
        'settings'    => 'ges_card_title_position',
        'type'        => 'select',
        'choices'     => array(
            'beside'  => esc_html__( 'Tetap seperti semula (Samping / Bawah)', 'gentara-news' ),
            'overlay' => esc_html__( 'Judul masuk ke dalam gambar (Overlay)', 'gentara-news' ),
        ),
    ));

    // C. Ukuran Font Judul khusus jika dimasukkan ke dalam Gambar (Overlay Font)
    $wp_customize->add_setting( 'ges_overlay_title_size_px', array(
        'default'           => 16,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control( 'ges_overlay_title_size_px_ctrl', array(
        'label'       => esc_html__( 'Ukuran Font Judul di Dalam Gambar (px)', 'gentara-news' ),
        'section'     => 'ges_styling_section',
        'settings'    => 'ges_overlay_title_size_px',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 12,
            'max'  => 28,
            'step' => 1,
        ),
    ));

    // D. Pengaturan Tinggi Minimum Kartu
    $wp_customize->add_setting( 'ges_card_min_height_px', array(
        'default'           => 0,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control( 'ges_card_min_height_px_ctrl', array(
        'label'       => esc_html__( 'Tinggi Minimum Kartu (px) [0 = Auto]', 'gentara-news' ),
        'section'     => 'ges_styling_section',
        'settings'    => 'ges_card_min_height_px',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 400,
            'step' => 10,
        ),
    ));
}

/**
 * INJEKSI CSS STYLING DINAMIS DI HEAD (Merespons Instan Perubahan Customizer)
 */
function ges_inject_dynamic_styling_css() {
    $shape   = get_theme_mod( 'ges_card_shape', 'sharp' );
    $radius  = (int) get_theme_mod( 'ges_card_radius', 0 );
    $accent  = get_theme_mod( 'ges_card_accent', 'flat' );
    $ratio   = get_theme_mod( 'ges_card_aspect_ratio', '16/9' );

    // Nilai Kustom Tambahan
    $list_width      = (int) get_theme_mod( 'ges_list_thumb_width_pct', 35 );
    $overlay_size    = (int) get_theme_mod( 'ges_overlay_title_size_px', 16 );
    $min_height      = (int) get_theme_mod( 'ges_card_min_height_px', 0 );

    // A. Rumuskan Nilai CSS Border-Radius
    $border_radius_css = '0px';
    if ( 'rounded' === $shape ) {
        $border_radius_css = "{$radius}px";
    } elseif ( 'asymmetric' === $shape ) {
        $border_radius_css = "0px {$radius}px 0px {$radius}px";
    } elseif ( 'asymmetric-inverse' === $shape ) {
        $border_radius_css = "{$radius}px 0px {$radius}px 0px";
    }

    // B. Rumuskan Efek Aksentuasi Latar Belakang & Border Kartu
    $bg_css       = 'none';
    $border_css   = 'none';
    $shadow_hover = 'none';
    $lift_hover   = 'none';
    $padding_card = '0px';

    if ( 'light-gradient' === $accent ) {
        $bg_css       = 'linear-gradient(135deg, var(--color-bg-body) 0%, var(--color-bg-surface) 100%)';
        $border_css   = '1px solid var(--color-border)';
        $padding_card = '12px';
    } elseif ( 'subtle-border' === $accent ) {
        $border_css   = '1px solid var(--color-border)';
        $padding_card = '12px';
    } elseif ( 'subtle-shadow' === $accent ) {
        $border_css   = '1px solid var(--color-border)';
        $padding_card = '12px';
        $shadow_hover = '0 10px 20px rgba(0, 0, 0, 0.05)';
        $lift_hover   = 'translateY(-4px)';
    }

    echo "\n<style id='ges-dynamic-card-styling'>\n";
    echo "  :root {\n";
    echo "    --card-border-radius: " . esc_attr( $border_radius_css ) . ";\n";
    echo "    --card-bg: " . esc_attr( $bg_css ) . ";\n";
    echo "    --card-border: " . esc_attr( $border_css ) . ";\n";
    echo "    --card-padding: " . esc_attr( $padding_card ) . ";\n";
    echo "    --card-shadow-hover: " . esc_attr( $shadow_hover ) . ";\n";
    echo "    --card-lift-hover: " . esc_attr( $lift_hover ) . ";\n";
    echo "    --theme-card-ratio: " . esc_attr( $ratio ) . ";\n";
    
    // Injeksi Variable Baru
    echo "    --list-thumb-width: " . esc_attr( $list_width ) . "% !important;\n";
    echo "    --overlay-title-size: " . esc_attr( $overlay_size ) . "px !important;\n";
    if ( $min_height > 0 ) {
        echo "    --card-min-height: " . esc_attr( $min_height ) . "px !important;\n";
    }
    echo "  }\n";
    echo "  [data-theme='dark'] {\n";
    echo "    --card-shadow-hover: 0 10px 25px rgba(0, 0, 0, 0.3);\n";
    echo "  }\n";
    echo "</style>\n";
}
add_action( 'wp_head', 'ges_inject_dynamic_styling_css', 11 );