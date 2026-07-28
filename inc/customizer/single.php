<?php
/**
 * Konfigurasi Customizer Halaman Single Post - Gesahan News Pro
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function gesahan_customize_single( $wp_customize ) {
    $wp_customize->add_section( 'ges_single_section', array(
        'title'    => esc_html__( 'Pengaturan Halaman Artikel', 'gesahan-news-pro' ),
        'panel'    => 'gesahan_theme_options',
        'priority' => 35,
    ));

    // 1. Tampilkan Breadcrumbs
    $wp_customize->add_setting( 'ges_single_show_breadcrumbs', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control( 'ges_single_show_breadcrumbs_ctrl', array(
        'label'    => esc_html__( 'Tampilkan Breadcrumbs', 'gesahan-news-pro' ),
        'section'  => 'ges_single_section',
        'settings' => 'ges_single_show_breadcrumbs',
        'type'     => 'checkbox',
    ));

    // 2. Tampilkan Nama Penulis
    $wp_customize->add_setting( 'ges_single_show_meta_author', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control( 'ges_single_show_meta_author_ctrl', array(
        'label'    => esc_html__( 'Tampilkan Nama Penulis (Meta)', 'gesahan-news-pro' ),
        'section'  => 'ges_single_section',
        'settings' => 'ges_single_show_meta_author',
        'type'     => 'checkbox',
    ));

    // 3. Tampilkan Tanggal Publikasi
    $wp_customize->add_setting( 'ges_single_show_meta_date', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control( 'ges_single_show_meta_date_ctrl', array(
        'label'    => esc_html__( 'Tampilkan Tanggal Publikasi (WIB)', 'gesahan-news-pro' ),
        'section'  => 'ges_single_section',
        'settings' => 'ges_single_show_meta_date',
        'type'     => 'checkbox',
    ));

    // 4. Aktifkan Injeksi Pilihan Redaksi Otomatis
    $wp_customize->add_setting( 'ges_single_show_pilihan_redaksi', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control( 'ges_single_show_pilihan_redaksi_ctrl', array(
        'label'       => esc_html__( 'Aktifkan Kotak "Pilihan Redaksi" Tengah Artikel', 'gesahan-news-pro' ),
        'description' => esc_html__( 'Menyisipkan artikel rekomendasi secara acak setelah paragraf ke-2.', 'gesahan-news-pro' ),
        'section'     => 'ges_single_section',
        'settings'    => 'ges_single_show_pilihan_redaksi',
        'type'        => 'checkbox',
    ));

    // 5. Aktifkan Kredit Inisial Editor Di Akhir Artikel
    $wp_customize->add_setting( 'ges_single_show_author_initials', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control( 'ges_single_show_author_initials_ctrl', array(
        'label'       => esc_html__( 'Tampilkan Kredit Inisial Editor', 'gesahan-news-pro' ),
        'description' => esc_html__( 'Contoh output: (abc/nva) di akhir teks artikel.', 'gesahan-news-pro' ),
        'section'     => 'ges_single_section',
        'settings'    => 'ges_single_show_author_initials',
        'type'        => 'checkbox',
    ));

    // 6. Aktifkan Artikel Terkait (Rekomendasi Di Bawah)
    $wp_customize->add_setting( 'ges_single_show_related', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control( 'ges_single_show_related_ctrl', array(
        'label'    => esc_html__( 'Tampilkan Rekomendasi Berita Terkait', 'gesahan-news-pro' ),
        'section'  => 'ges_single_section',
        'settings' => 'ges_single_show_related',
        'type'     => 'checkbox',
    ));

    // 7. Jumlah Batas Artikel Terkait
    $wp_customize->add_setting( 'ges_single_related_limit', array(
        'default'           => 3,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control( 'ges_single_related_limit_ctrl', array(
        'label'    => esc_html__( 'Jumlah Artikel Terkait', 'gesahan-news-pro' ),
        'section'  => 'ges_single_section',
        'settings' => 'ges_single_related_limit',
        'type'     => 'number',
    ));
}