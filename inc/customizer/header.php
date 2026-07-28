<?php
/**
 * Konfigurasi Customizer Bagian Header Tema - Gesahan News Pro
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function gesahan_customize_header( $wp_customize ) {
    $wp_customize->add_section( 'ges_header_section', array(
        'title'    => esc_html__( 'Pengaturan Header & Menu', 'gesahan-news-pro' ),
        'panel'    => 'gesahan_theme_options',
        'priority' => 15,
    ));

    // 1. Teks Logo Singkat
    $wp_customize->add_setting( 'ges_header_logo_text', array(
        'default'           => 'GN',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'ges_header_logo_text_ctrl', array(
        'label'       => esc_html__( 'Teks Logo Header', 'gesahan-news-pro' ),
        'description' => esc_html__( 'Maksimal 3 karakter (Saran: GN, CNN, IDN, dll)', 'gesahan-news-pro' ),
        'section'     => 'ges_header_section',
        'settings'    => 'ges_header_logo_text',
        'type'        => 'text',
    ));

    // 2. Aktifkan Tombol Pencarian
    $wp_customize->add_setting( 'ges_header_show_search', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control( 'ges_header_show_search_ctrl', array(
        'label'    => esc_html__( 'Tampilkan Tombol Pencarian Overlay', 'gesahan-news-pro' ),
        'section'  => 'ges_header_section',
        'settings' => 'ges_header_show_search',
        'type'     => 'checkbox',
    ));

    // 3. Aktifkan Tombol Mode Gelap (Theme Toggle)
    $wp_customize->add_setting( 'ges_header_show_dark_mode', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control( 'ges_header_show_dark_mode_ctrl', array(
        'label'    => esc_html__( 'Tampilkan Tombol Switch Mode Gelap', 'gesahan-news-pro' ),
        'section'  => 'ges_header_section',
        'settings' => 'ges_header_show_dark_mode',
        'type'     => 'checkbox',
    ));

    // 4. Label Trending Ticker
    $wp_customize->add_setting( 'ges_header_trending_label', array(
        'default'           => 'Trending',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'ges_header_trending_label_ctrl', array(
        'label'    => esc_html__( 'Label Teks Trending', 'gesahan-news-pro' ),
        'section'  => 'ges_header_section',
        'settings' => 'ges_header_trending_label',
        'type'     => 'text',
    ));

    // 5. Batasi Jumlah Tag Tren
    $wp_customize->add_setting( 'ges_header_trending_limit', array(
        'default'           => 5,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control( 'ges_header_trending_limit_ctrl', array(
        'label'    => esc_html__( 'Jumlah Tag yang Muncul di Ticker', 'gesahan-news-pro' ),
        'section'  => 'ges_header_section',
        'settings' => 'ges_header_trending_limit',
        'type'     => 'number',
    ));
}