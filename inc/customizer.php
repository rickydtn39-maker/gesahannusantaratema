<?php
/**
 * Konfigurasi Customizer Halaman Utama (Homepage Builder) - Gesahan News Pro
 *
 * @package Gesahan_News_Pro
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function gesahan_customize_homepage( $wp_customize ) {
    $wp_customize->add_section( 'ges_homepage_section', array(
        'title'    => esc_html__( 'Homepage Builder Settings', 'gesahan-news-pro' ),
        'panel'    => 'gesahan_theme_options',
        'priority' => 30,
    ));

    // Ambil daftar kategori riil dari database untuk pilihan dropdown
    $categories = get_categories( array( 'hide_empty' => false ) );
    $cats_choices = array( '0' => esc_html__( '-- Berita Terbaru (Semua) --', 'gesahan-news-pro' ) );
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
        'label'    => esc_html__( '1. Aktifkan Hero (Berita Utama)', 'gesahan-news-pro' ),
        'section'  => 'ges_homepage_section',
        'settings' => 'ges_home_hero_enable',
        'type'     => 'checkbox',
    ));

    $wp_customize->add_setting( 'ges_home_hero_category', array(
        'default'           => '0',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control( 'ges_home_hero_category_ctrl', array(
        'label'    => esc_html__( '└─ Kategori Sumber Hero', 'gesahan-news-pro' ),
        'section'  => 'ges_homepage_section',
        'settings' => 'ges_home_hero_category',
        'type'     => 'select',
        'choices'  => $cats_choices,
    ));

    $wp_customize->add_setting( 'ges_home_hero_order', array(
        'default'           => 10,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control( 'ges_home_hero_order_ctrl', array(
        'label'       => esc_html__( '└─ Urutan Posisi Hero (Angka)', 'gesahan-news-pro' ),
        'description' => esc_html__( 'Semakin kecil nilainya, semakin atas posisinya.', 'gesahan-news-pro' ),
        'section'     => 'ges_homepage_section',
        'settings' => 'ges_home_hero_order',
        'type'     => 'number',
    ));

    // ==========================================
    // 2. BLOK BARU: PILIHAN REDAKSI STRIP HORIZONTAL
    // ==========================================
    $wp_customize->add_setting( 'ges_home_choice_enable', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control( 'ges_home_choice_enable_ctrl', array(
        'label'    => esc_html__( '2. Aktifkan "Pilihan Redaksi" Strip', 'gesahan-news-pro' ),
        'section'  => 'ges_homepage_section',
        'settings' => 'ges_home_choice_enable',
        'type'     => 'checkbox',
    ));

    $wp_customize->add_setting( 'ges_home_choice_category', array(
        'default'           => '0',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control( 'ges_home_choice_category_ctrl', array(
        'label'    => esc_html__( '└─ Kategori Pilihan Redaksi', 'gesahan-news-pro' ),
        'section'  => 'ges_homepage_section',
        'settings' => 'ges_home_choice_category',
        'type'     => 'select',
        'choices'  => $cats_choices,
    ));

    $wp_customize->add_setting( 'ges_home_choice_order', array(
        'default'           => 20,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control( 'ges_home_choice_order_ctrl', array(
        'label'    => esc_html__( '└─ Urutan Posisi Strip (Angka)', 'gesahan-news-pro' ),
        'section'  => 'ges_homepage_section',
        'settings' => 'ges_home_choice_order',
        'type'     => 'number',
    ));

    // ==========================================
    // 3. BLOK 3: LATEST NEWS (BERITA TERBARU)
    // ==========================================
    $wp_customize->add_setting( 'ges_home_latest_enable', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control( 'ges_home_latest_enable_ctrl', array(
        'label'    => esc_html__( '3. Aktifkan Berita Terbaru (Latest)', 'gesahan-news-pro' ),
        'section'  => 'ges_homepage_section',
        'settings' => 'ges_home_latest_enable',
        'type'     => 'checkbox',
    ));

    $wp_customize->add_setting( 'ges_home_latest_limit', array(
        'default'           => 6,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control( 'ges_home_latest_limit_ctrl', array(
        'label'    => esc_html__( '└─ Jumlah Artikel Terbaru', 'gesahan-news-pro' ),
        'section'  => 'ges_homepage_section',
        'settings' => 'ges_home_latest_limit',
        'type'     => 'number',
    ));

    $wp_customize->add_setting( 'ges_home_latest_all_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control( 'ges_home_latest_all_url_ctrl', array(
        'label'       => esc_html__( '└─ URL Tombol "Lihat Semua"', 'gesahan-news-pro' ),
        'description' => esc_html__( 'Masukkan URL indeks atau halaman arsip berita terbaru. Kosongkan untuk deteksi otomatis.', 'gesahan-news-pro' ),
        'section'     => 'ges_homepage_section',
        'settings'    => 'ges_home_latest_all_url',
        'type'        => 'text',
    ));

    $wp_customize->add_setting( 'ges_home_latest_order', array(
        'default'           => 30,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control( 'ges_home_latest_order_ctrl', array(
        'label'    => esc_html__( '└─ Urutan Posisi Terbaru (Angka)', 'gesahan-news-pro' ),
        'section'  => 'ges_homepage_section',
        'settings' => 'ges_home_latest_order',
        'type'     => 'number',
    ));

    // Kontrol Fokus Sidebar (Pendamping Kolom Terbaru)
    $wp_customize->add_setting( 'ges_home_fokus_enable', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control( 'ges_home_fokus_enable_ctrl', array(
        'label'    => esc_html__( '└─ Aktifkan "Fokus" Sidebar (Terbaru)', 'gesahan-news-pro' ),
        'section'  => 'ges_homepage_section',
        'settings' => 'ges_home_fokus_enable',
        'type'     => 'checkbox',
    ));

    $wp_customize->add_setting( 'ges_home_fokus_category', array(
        'default'           => '0',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control( 'ges_home_fokus_category_ctrl', array(
        'label'    => esc_html__( '   └─ Kategori Sumber Fokus', 'gesahan-news-pro' ),
        'section'  => 'ges_homepage_section',
        'settings' => 'ges_home_fokus_category',
        'type'     => 'select',
        'choices'  => $cats_choices,
    ));

    $wp_customize->add_setting( 'ges_home_fokus_limit', array(
        'default'           => 3,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control( 'ges_home_fokus_limit_ctrl', array(
        'label'    => esc_html__( '   └─ Batas Jumlah Fokus', 'gesahan-news-pro' ),
        'section'  => 'ges_homepage_section',
        'settings' => 'ges_home_fokus_limit',
        'type'     => 'number',
    ));

    // ==========================================
    // 4. BLOK 4: KATEGORI KUSTOM 1
    // ==========================================
    $wp_customize->add_setting( 'ges_home_cat_block_1_enable', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control( 'ges_home_cat_block_1_enable_ctrl', array(
        'label'    => esc_html__( '4. Aktifkan Blok Kategori Kustom 1', 'gesahan-news-pro' ),
        'section'  => 'ges_homepage_section',
        'settings' => 'ges_home_cat_block_1_enable',
        'type'     => 'checkbox',
    ));

    $wp_customize->add_setting( 'ges_home_cat_block_1_id', array(
        'default'           => '0',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control( 'ges_home_cat_block_1_id_ctrl', array(
        'label'    => esc_html__( '└─ Pilih Kategori Sumber', 'gesahan-news-pro' ),
        'section'  => 'ges_homepage_section',
        'settings' => 'ges_home_cat_block_1_id',
        'type'     => 'select',
        'choices'  => $cats_choices,
    ));

    $wp_customize->add_setting( 'ges_home_cat_block_1_limit', array(
        'default'           => 4,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control( 'ges_home_cat_block_1_limit_ctrl', array(
        'label'    => esc_html__( '└─ Batas Jumlah Artikel', 'gesahan-news-pro' ),
        'section'  => 'ges_homepage_section',
        'settings' => 'ges_home_cat_block_1_limit',
        'type'     => 'number',
    ));

    $wp_customize->add_setting( 'ges_home_cat_block_1_order', array(
        'default'           => 40,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control( 'ges_home_cat_block_1_order_ctrl', array(
        'label'    => esc_html__( '└─ Urutan Posisi Blok 1 (Angka)', 'gesahan-news-pro' ),
        'section'  => 'ges_homepage_section',
        'settings' => 'ges_home_cat_block_1_order',
        'type'     => 'number',
    ));

    // ==========================================
    // 5. BLOK 5: KATEGORI KUSTOM 2
    // ==========================================
    $wp_customize->add_setting( 'ges_home_cat_block_2_enable', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control( 'ges_home_cat_block_2_enable_ctrl', array(
        'label'    => esc_html__( '5. Aktifkan Blok Kategori Kustom 2', 'gesahan-news-pro' ),
        'section'  => 'ges_homepage_section',
        'settings' => 'ges_home_cat_block_2_enable',
        'type'     => 'checkbox',
    ));

    $wp_customize->add_setting( 'ges_home_cat_block_2_id', array(
        'default'           => '0',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control( 'ges_home_cat_block_2_id_ctrl', array(
        'label'    => esc_html__( '└─ Pilih Kategori Sumber', 'gesahan-news-pro' ),
        'section'  => 'ges_homepage_section',
        'settings' => 'ges_home_cat_block_2_id',
        'type'     => 'select',
        'choices'  => $cats_choices,
    ));

    $wp_customize->add_setting( 'ges_home_cat_block_2_limit', array(
        'default'           => 4,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control( 'ges_home_cat_block_2_limit_ctrl', array(
        'label'    => esc_html__( '└─ Batas Jumlah Artikel', 'gesahan-news-pro' ),
        'section'  => 'ges_homepage_section',
        'settings' => 'ges_home_cat_block_2_limit',
        'type'     => 'number',
    ));

    $wp_customize->add_setting( 'ges_home_cat_block_2_order', array(
        'default'           => 50,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control( 'ges_home_cat_block_2_order_ctrl', array(
        'label'    => esc_html__( '└─ Urutan Posisi Blok 2 (Angka)', 'gesahan-news-pro' ),
        'section'  => 'ges_homepage_section',
        'settings' => 'ges_home_cat_block_2_order',
        'type'     => 'number',
    ));

    // ==========================================
    // 6. BLOK 6: KATEGORI KUSTOM 3
    // ==========================================
    $wp_customize->add_setting( 'ges_home_cat_block_3_enable', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control( 'ges_home_cat_block_3_enable_ctrl', array(
        'label'    => esc_html__( '6. Aktifkan Blok Kategori Kustom 3', 'gesahan-news-pro' ),
        'section'  => 'ges_homepage_section',
        'settings' => 'ges_home_cat_block_3_enable',
        'type'     => 'checkbox',
    ));

    $wp_customize->add_setting( 'ges_home_cat_block_3_id', array(
        'default'           => '0',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control( 'ges_home_cat_block_3_id_ctrl', array(
        'label'    => esc_html__( '└─ Pilih Kategori Sumber', 'gesahan-news-pro' ),
        'section'  => 'ges_homepage_section',
        'settings' => 'ges_home_cat_block_3_id',
        'type'     => 'select',
        'choices'  => $cats_choices,
    ));

    $wp_customize->add_setting( 'ges_home_cat_block_3_limit', array(
        'default'           => 4,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control( 'ges_home_cat_block_3_limit_ctrl', array(
        'label'    => esc_html__( '└─ Batas Jumlah Artikel', 'gesahan-news-pro' ),
        'section'  => 'ges_homepage_section',
        'settings' => 'ges_home_cat_block_3_limit',
        'type'     => 'number',
    ));

    $wp_customize->add_setting( 'ges_home_cat_block_3_order', array(
        'default'           => 60,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control( 'ges_home_cat_block_3_order_ctrl', array(
        'label'    => esc_html__( '└─ Urutan Posisi Blok 3 (Angka)', 'gesahan-news-pro' ),
        'section'  => 'ges_homepage_section',
        'settings' => 'ges_home_cat_block_3_order',
        'type'     => 'number',
    ));
}