<?php
/**
 * Konfigurasi Customizer Manajemen Slot Iklan - Gentara News Pro
 *
 * @package Gentara_News
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function gesahan_customize_ads( $wp_customize ) {
    $wp_customize->add_section( 'ges_ads_section', array(
        'title'    => esc_html__( 'Manajemen Slot Iklan', 'gentara-news' ),
        'panel'    => 'gesahan_theme_options',
        'priority' => 40,
    ));

    $ad_slots = array(
        'header_leaderboard' => array(
            'label' => esc_html__( '1. Iklan Header (Leaderboard)', 'gentara-news' ),
            'desc'  => esc_html__( 'Saran dimensi: 728x90 piksel di layar lebar desktop.', 'gentara-news' ),
        ),
        'hero_sidebar_square' => array(
            'label' => esc_html__( '2. Iklan Samping Terpopuler (Desktop)', 'gentara-news' ),
            'desc'  => esc_html__( 'Saran dimensi: 300x250 piksel (Medium Rectangle) untuk mengisi kekosongan kolom kanan.', 'gentara-news' ),
        ),
        'below_article' => array(
            'label' => esc_html__( '3. Iklan Bawah Artikel', 'gentara-news' ),
            'desc'  => esc_html__( 'Saran dimensi: 336x280 atau responsif di bawah tulisan.', 'gentara-news' ),
        ),
        'top_dropdown' => array(
            'label' => esc_html__( '4. Iklan Top Dropdown (Slide Down)', 'gentara-news' ),
            'desc'  => esc_html__( 'Iklan interaktif meluncur otomatis dari atas layar setelah 3 detik.', 'gentara-news' ),
        ),
        'mid_article' => array(
            'label' => esc_html__( '5. Iklan Tengah Artikel', 'gentara-news' ),
            'desc'  => esc_html__( 'Secara cerdas otomatis menyisip tepat setelah paragraf ke-4.', 'gentara-news' ),
        ),
        'sidebar_sticky' => array(
            'label' => esc_html__( '6. Iklan Sidebar Sticky (Melayang)', 'gentara-news' ),
            'desc'  => esc_html__( 'Saran dimensi: 300x600 piksel menempel saat layar digulir.', 'gentara-news' ),
        ),
        'above_comments' => array(
            'label' => esc_html__( '7. Iklan di Atas Komentar', 'gentara-news' ),
            'desc'  => esc_html__( 'Tepat berada di atas area form komentar artikel.', 'gentara-news' ),
        ),
        'interstitial_anchor' => array(
            'label' => esc_html__( '8. Iklan Melayang Seluler (Mobile Bottom Anchor)', 'gentara-news' ),
            'desc'  => esc_html__( 'Saran dimensi: 320x50 atau 320x100 melayang di bawah layar HP.', 'gentara-news' ),
        ),
    );

    foreach ( $ad_slots as $slug => $slot ) {
        // A. Bidang Input Kode HTML / Script Iklan (AdSense)
        $wp_customize->add_setting( 'ges_ad_' . $slug, array(
            'default'           => '',
            'sanitize_callback' => 'ges_sanitize_ad_code',
        ));
        $wp_customize->add_control( 'ges_ad_' . $slug . '_ctrl', array(
            'label'       => $slot['label'],
            'description' => $slot['desc'],
            'section'     => 'ges_ads_section',
            'settings'    => 'ges_ad_' . $slug,
            'type'        => 'textarea',
        ));

        // B. Bidang Unggah Gambar Iklan (Sistem Gambar Cerdas)
        $wp_customize->add_setting( 'ges_ad_' . $slug . '_image', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control( new \WP_Customize_Image_Control( $wp_customize, 'ges_ad_' . $slug . '_image_ctrl', array(
            'label'       => esc_html__( '   └─ ATAU Upload Gambar Iklan Utama', 'gentara-news' ),
            'section'     => 'ges_ads_section',
            'settings'    => 'ges_ad_' . $slug . '_image',
        )));

        // C. Bidang Input URL Tujuan Link Tautan
        $wp_customize->add_setting( 'ges_ad_' . $slug . '_link', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control( 'ges_ad_' . $slug . '_link_ctrl', array(
            'label'       => esc_html__( '   └─ Link Tujuan Tautan Iklan (URL)', 'gentara-news' ),
            'section'     => 'ges_ads_section',
            'settings'    => 'ges_ad_' . $slug . '_link',
            'type'        => 'text',
        ));
    }
}