<?php
/**
 * Konfigurasi Customizer Halaman Utama (Homepage Builder) - Gentara News Pro
 *
 * @package Gentara_News
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function gesahan_customize_homepage( $wp_customize ) {
    $wp_customize->add_section( 'ges_homepage_section', array(
        'title'    => esc_html__( 'Homepage Builder Settings', 'gentara-news' ),
        'panel'    => 'gesahan_theme_options',
        'priority' => 30,
    ));

    // Ambil daftar kategori riil dari database untuk pilihan dropdown
    $categories = get_categories( array( 'hide_empty' => false ) );
    $cats_choices = array( '0' => esc_html__( '-- Berita Terbaru (Semua) --', 'gentara-news' ) );
    foreach ( $categories as $cat ) {
        $cats_choices[$cat->term_id] = $cat->name;
    }

    // ==========================================
    // 1. BLOK 1: HERO (BERITA UTAMA)
    // ==========================================
    $wp_customize->add_setting( 'ges_home_hero_enable', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control( 'ges_home_hero_enable_ctrl', array(
        'label'    => esc_html__( '1. Aktifkan Hero (Berita Utama)', 'gentara-news' ),
        'section'  => 'ges_homepage_section',
        'settings' => 'ges_home_hero_enable',
        'type'     => 'checkbox',
    ));

    $wp_customize->add_setting( 'ges_home_hero_category', array(
        'default'           => '0',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control( 'ges_home_hero_category_ctrl', array(
        'label'    => esc_html__( '└─ Kategori Sumber Hero', 'gentara-news' ),
        'section'  => 'ges_homepage_section',
        'settings' => 'ges_home_hero_category',
        'type'     => 'select',
        'choices'  => $cats_choices,
    ));

    // ==========================================
    // 2. BLOK 2: NUSANTARA TERKINI (SLIDER REGIONAL)
    // ==========================================
    $wp_customize->add_setting( 'ges_home_nusantara_enable', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control( 'ges_home_nusantara_enable_ctrl', array(
        'label'    => esc_html__( '2. Aktifkan Slider Nusantara Terkini', 'gentara-news' ),
        'section'  => 'ges_homepage_section',
        'settings' => 'ges_home_nusantara_enable',
        'type'     => 'checkbox',
    ));

    $wp_customize->add_setting( 'ges_home_nusantara_title', array(
        'default'           => 'Nusantara Terkini',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'ges_home_nusantara_title_ctrl', array(
        'label'    => esc_html__( '└─ Judul Kustom Slider', 'gentara-news' ),
        'section'  => 'ges_homepage_section',
        'settings' => 'ges_home_nusantara_title',
        'type'     => 'text',
    ));

    $wp_customize->add_setting( 'ges_home_nusantara_category', array(
        'default'           => '0',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control( 'ges_home_nusantara_category_ctrl', array(
        'label'       => esc_html__( '└─ Pilih Kategori Sumber Slider', 'gentara-news' ),
        'description' => esc_html__( 'Pilih kategori induk regional (Rekomendasi: Kategori "Daerah").', 'gentara-news' ),
        'section'     => 'ges_homepage_section',
        'settings'    => 'ges_home_nusantara_category',
        'type'        => 'select',
        'choices'     => $cats_choices,
    ));

    // ==========================================
    // 3. 8 ➕ BLOK KATEGORI MANUAL DENGAN OPSI DETIL
    // ==========================================
    for ( $i = 1; $i <= 8; $i++ ) {
        // A. Toggle Aktifkan Blok
        $wp_customize->add_setting( 'ges_home_cat_block_' . $i . '_enable', array(
            'default'           => false,
            'sanitize_callback' => 'wp_validate_boolean',
        ));
        $wp_customize->add_control( 'ges_home_cat_block_' . $i . '_enable_ctrl', array(
            'label'    => sprintf( esc_html__( '➕ Blok Kategori Manual %d', 'gentara-news' ), $i ),
            'section'  => 'ges_homepage_section',
            'settings' => 'ges_home_cat_block_' . $i . '_enable',
            'type'     => 'checkbox',
        ));

        // B. Nama Tampilan Kategori
        $wp_customize->add_setting( 'ges_home_cat_block_' . $i . '_title', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control( 'ges_home_cat_block_' . $i . '_title_ctrl', array(
            'label'       => esc_html__( '   └─ Nama Tampilan Kategori di Website', 'gentara-news' ),
            'description' => esc_html__( 'Tulis nama judul seksi bebas (contoh: BERITA TERKINI, ANALISIS, POLTIK DAERAH).', 'gentara-news' ),
            'section'     => 'ges_homepage_section',
            'settings'    => 'ges_home_cat_block_' . $i . '_title',
            'type'        => 'text',
        ));

        // C. Sumber Kategori
        $wp_customize->add_setting( 'ges_home_cat_block_' . $i . '_id', array(
            'default'           => '0',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control( 'ges_home_cat_block_' . $i . '_id_ctrl', array(
            'label'    => esc_html__( '   └─ Pilih Sumber Kategori', 'gentara-news' ),
            'section'  => 'ges_homepage_section',
            'settings' => 'ges_home_cat_block_' . $i . '_id',
            'type'     => 'select',
            'choices'  => $cats_choices,
        ));

        // D. Tipe / Jenis Desain Kartu (Modular Builder)
        $wp_customize->add_setting( 'ges_home_cat_block_' . $i . '_style', array(
            'default'           => 'standard',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control( 'ges_home_cat_block_' . $i . '_style_ctrl', array(
            'label'       => esc_html__( '   └─ Desain Model Kartu', 'gentara-news' ),
            'section'     => 'ges_homepage_section',
            'settings'    => 'ges_home_cat_block_' . $i . '_style',
            'type'        => 'select',
            'choices'     => array(
                'standard'      => esc_html__( 'Grid (Kartu Standard 4 Kolom)', 'gentara-news' ),
                'list'          => esc_html__( 'List (Kartu Row Lebar 1 Kolom)', 'gentara-news' ),
                'compact'       => esc_html__( 'Compact (Daftar Baris Mini 2 Kolom)', 'gentara-news' ),
                'featured'      => esc_html__( 'Featured (Model Khas Redaksi 3 Kolom)', 'gentara-news' ),
                'double_column' => esc_html__( 'Double Column (Model 2 Kolom Tegas)', 'gentara-news' ),
                'overlay'       => esc_html__( 'Overlay (Teks Di Atas Gambar 3 Kolom)', 'gentara-news' ),
            ),
        ));

        // E. Batas Jumlah Postingan
        $wp_customize->add_setting( 'ges_home_cat_block_' . $i . '_limit', array(
            'default'           => 4,
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control( 'ges_home_cat_block_' . $i . '_limit_ctrl', array(
            'label'    => esc_html__( '   └─ Batas Jumlah Artikel', 'gentara-news' ),
            'section'  => 'ges_homepage_section',
            'settings' => 'ges_home_cat_block_' . $i . '_limit',
            'type'     => 'number',
        ));

        // F. Ukuran Card Angka (Lebor px)
        $wp_customize->add_setting( 'ges_home_cat_block_' . $i . '_card_size', array(
            'default'           => 280,
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control( 'ges_home_cat_block_' . $i . '_card_size_ctrl', array(
            'label'       => esc_html__( '   └─ Ukuran Card Angka (px)', 'gentara-news' ),
            'description' => esc_html__( 'Mengatur lebar minimum card (Saran: 180 s/d 350).', 'gentara-news' ),
            'section'     => 'ges_homepage_section',
            'settings'    => 'ges_home_cat_block_' . $i . '_card_size',
            'type'        => 'number',
            'input_attrs' => array(
                'min'  => 120,
                'max'  => 500,
                'step' => 10,
            ),
        ));

        // G. Ukuran Judul Angka (Font px)
        $wp_customize->add_setting( 'ges_home_cat_block_' . $i . '_title_size', array(
            'default'           => 16,
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control( 'ges_home_cat_block_' . $i . '_title_size_ctrl', array(
            'label'       => esc_html__( '   └─ Ukuran Judul Angka (px)', 'gentara-news' ),
            'description' => esc_html__( 'Mengatur besar teks judul artikel di dalam kartu (Saran: 12 s/d 24).', 'gentara-news' ),
            'section'     => 'ges_homepage_section',
            'settings'    => 'ges_home_cat_block_' . $i . '_title_size',
            'type'        => 'number',
            'input_attrs' => array(
                'min'  => 10,
                'max'  => 36,
                'step' => 1,
            ),
        ));

        // H. Prioritas Urutan Layout
        $wp_customize->add_setting( 'ges_home_cat_block_' . $i . '_order', array(
            'default'           => (30 + ($i * 5)),
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control( 'ges_home_cat_block_' . $i . '_order_ctrl', array(
            'label'    => esc_html__( '   └─ Urutan Posisi Blok (Angka)', 'gentara-news' ),
            'section'  => 'ges_homepage_section',
            'settings' => 'ges_home_cat_block_' . $i . '_order',
            'type'     => 'number',
        ));
    }
}