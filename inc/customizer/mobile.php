<?php
/**
 * Konfigurasi Customizer Khusus Mobile & Tablet - Gesahan News Pro
 *
 * @package Gesahan_News_Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function gesahan_customize_mobile( $wp_customize ) {
    $wp_customize->add_section( 'ges_mobile_section', array(
        'title'    => esc_html__( 'Pengaturan Mobile & Tablet', 'gesahan-news-pro' ),
        'panel'    => 'gesahan_theme_options',
        'priority' => 18,
    ));

    // 1. Teks Logo Khusus Mobile
    $wp_customize->add_setting( 'ges_mobile_logo_text', array(
        'default'           => 'GN',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'ges_mobile_logo_text_ctrl', array(
        'label'       => esc_html__( 'Teks Logo Mobile', 'gesahan-news-pro' ),
        'description' => esc_html__( 'Akan muncul di bagian tengah header seluler.', 'gesahan-news-pro' ),
        'section'     => 'ges_mobile_section',
        'settings'    => 'ges_mobile_logo_text',
        'type'        => 'text',
    ));

    // 2. Aktifkan Pencarian di Mobile Header
    $wp_customize->add_setting( 'ges_mobile_show_search', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control( 'ges_mobile_show_search_ctrl', array(
        'label'    => esc_html__( 'Tampilkan Tombol Cari di Mobile', 'gesahan-news-pro' ),
        'section'  => 'ges_mobile_section',
        'settings' => 'ges_mobile_show_search',
        'type'     => 'checkbox',
    ));

    // 3. Aktifkan Mode Gelap di Mobile Header
    $wp_customize->add_setting( 'ges_mobile_show_dark_mode', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control( 'ges_mobile_show_dark_mode_ctrl', array(
        'label'    => esc_html__( 'Tampilkan Tombol Mode Gelap di Mobile', 'gesahan-news-pro' ),
        'section'  => 'ges_mobile_section',
        'settings' => 'ges_mobile_show_dark_mode',
        'type'     => 'checkbox',
    ));

    // 4. Aktifkan Efek Akordeon di Footer Mobile
    $wp_customize->add_setting( 'ges_mobile_footer_accordion', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control( 'ges_mobile_footer_accordion_ctrl', array(
        'label'       => esc_html__( 'Gunakan Efek Akordeon pada Footer Mobile', 'gesahan-news-pro' ),
        'description' => esc_html__( 'Menyembunyikan isi widget footer di HP dan hanya membukanya saat judul widget disentuh.', 'gesahan-news-pro' ),
        'section'     => 'ges_mobile_section',
        'settings'    => 'ges_mobile_footer_accordion',
        'type'        => 'checkbox',
    ));

    // 5. Teks Copyright Singkat Khusus HP
    $wp_customize->add_setting( 'ges_mobile_copyright', array(
        'default'           => '© 2026 Trans Media, GN',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control( 'ges_mobile_copyright_ctrl', array(
        'label'    => esc_html__( 'Teks Hak Cipta Singkat (Mobile)', 'gesahan-news-pro' ),
        'section'  => 'ges_mobile_section',
        'settings' => 'ges_mobile_copyright',
        'type'     => 'textarea',
    ));
}