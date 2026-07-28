<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

function gesahan_customize_footer( $wp_customize ) {
    $wp_customize->add_section( 'ges_footer_section', array(
        'title'    => esc_html__( 'Pengaturan Footer GN', 'gesahan-news-pro' ),
        'panel'    => 'gesahan_theme_options',
        'priority' => 60,
    ));

    // ==========================================
    // 1. VISIBILITAS AREA LOGO BAR
    // ==========================================
    $wp_customize->add_setting( 'ges_footer_show_logo_bar', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control( 'ges_footer_show_logo_bar_ctrl', array(
        'label'    => esc_html__( 'Tampilkan Logo Bar Atas Footer', 'gesahan-news-pro' ),
        'section'  => 'ges_footer_section',
        'settings' => 'ges_footer_show_logo_bar',
        'type'     => 'checkbox',
    ));

    $wp_customize->add_setting( 'ges_footer_tagline', array(
        'default'           => 'NEWS WE CAN TRUST',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'ges_footer_tagline_ctrl', array(
        'label'    => esc_html__( 'Tagline Samping Logo', 'gesahan-news-pro' ),
        'section'  => 'ges_footer_section',
        'settings' => 'ges_footer_tagline',
        'type'     => 'text',
    ));

    // ==========================================
    // 2. KONTROL DETAIL KOLOM 1 (KIRI)
    // ==========================================
    $wp_customize->add_setting( 'ges_footer_desc', array(
        'default'           => 'Menyajikan berita terhangat langsung melalui handphone Anda',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'ges_footer_desc_ctrl', array(
        'label'    => esc_html__( 'Deskripsi Kiri', 'gesahan-news-pro' ),
        'section'  => 'ges_footer_section',
        'settings' => 'ges_footer_desc',
        'type'     => 'textarea',
    ));

    $wp_customize->add_setting( 'ges_footer_download_label', array(
        'default'           => 'DOWNLOAD SEKARANG',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'ges_footer_download_label_ctrl', array(
        'label'    => esc_html__( 'Label Teks Download (Kosongkan jika ingin disembunyikan)', 'gesahan-news-pro' ),
        'section'  => 'ges_footer_section',
        'settings' => 'ges_footer_download_label',
        'type'     => 'text',
    ));

    $wp_customize->add_setting( 'ges_footer_show_gnews', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control( 'ges_footer_show_gnews_ctrl', array(
        'label'    => esc_html__( 'Aktifkan Badge Google News', 'gesahan-news-pro' ),
        'section'  => 'ges_footer_section',
        'settings' => 'ges_footer_show_gnews',
        'type'     => 'checkbox',
    ));

    $wp_customize->add_setting( 'ges_footer_gnews_url', array(
        'default'           => '#',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'ges_footer_gnews_url_ctrl', array(
        'label'    => esc_html__( 'URL Link Google News', 'gesahan-news-pro' ),
        'section'  => 'ges_footer_section',
        'settings' => 'ges_footer_gnews_url',
        'type'     => 'text',
    ));

    // ==========================================
    // 3. KONTROL DETAIL TV (KOLOM 2) & SOSMED (KOLOM 3)
    // ==========================================
    $wp_customize->add_setting( 'ges_footer_show_gntv', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control( 'ges_footer_show_gntv_ctrl', array(
        'label'    => esc_html__( 'Aktifkan Tombol Merah TV', 'gesahan-news-pro' ),
        'section'  => 'ges_footer_section',
        'settings' => 'ges_footer_show_gntv',
        'type'     => 'checkbox',
    ));

    $wp_customize->add_setting( 'ges_footer_gntv_text', array(
        'default'           => 'GN TV',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'ges_footer_gntv_text_ctrl', array(
        'label'    => esc_html__( 'Teks Tombol TV', 'gesahan-news-pro' ),
        'section'  => 'ges_footer_section',
        'settings' => 'ges_footer_gntv_text',
        'type'     => 'text',
    ));

    $wp_customize->add_setting( 'ges_footer_gntv_url', array(
        'default'           => '#',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'ges_footer_gntv_url_ctrl', array(
        'label'    => esc_html__( 'URL Link TV', 'gesahan-news-pro' ),
        'section'  => 'ges_footer_section',
        'settings' => 'ges_footer_gntv_url',
        'type'     => 'text',
    ));

    $wp_customize->add_setting( 'ges_footer_show_socials', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control( 'ges_footer_show_socials_ctrl', array(
        'label'    => esc_html__( 'Tampilkan Blok Ikon Sosial Media', 'gesahan-news-pro' ),
        'section'  => 'ges_footer_section',
        'settings' => 'ges_footer_show_socials',
        'type'     => 'checkbox',
    ));

    $socials = array( 'facebook', 'x', 'instagram', 'tiktok' );
    foreach ( $socials as $social ) {
        $wp_customize->add_setting( 'ges_social_' . $social, array(
            'default'           => '#',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control( 'ges_social_' . $social . '_ctrl', array(
            'label'       => sprintf( esc_html__( 'URL Link %s', 'gesahan-news-pro' ), ucfirst($social) ),
            'section'     => 'ges_footer_section',
            'settings'    => 'ges_social_' . $social,
            'type'        => 'text',
        ));
    }

    // ==========================================
    // 4. SEGMEN NAVIGASI DASAR (FLAT LINKS)
    // ==========================================
    $wp_customize->add_setting( 'ges_footer_show_flat_links_1', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control( 'ges_footer_show_flat_links_1_ctrl', array(
        'label'    => esc_html__( 'Tampilkan Navigasi Dasar Baris 1', 'gesahan-news-pro' ),
        'section'  => 'ges_footer_section',
        'settings' => 'ges_footer_show_flat_links_1',
        'type'     => 'checkbox',
    ));

    $wp_customize->add_setting( 'ges_footer_flat_links_text_1', array(
        'default'           => '<a href="#">Tentang Kami</a> | <a href="#">Redaksi</a> | <a href="#">Pedoman Media Siber</a> | <a href="#">Karir</a> | <a href="#">Disclaimer</a>',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control( 'ges_footer_flat_links_text_1_ctrl', array(
        'label'       => esc_html__( 'Isi HTML Navigasi Dasar Baris 1', 'gesahan-news-pro' ),
        'description' => esc_html__( 'Tulis dalam format tag HTML link yang dipisahkan garis vertikal (|).', 'gesahan-news-pro' ),
        'section'     => 'ges_footer_section',
        'settings'    => 'ges_footer_flat_links_text_1',
        'type'        => 'textarea',
    ));

    $wp_customize->add_setting( 'ges_footer_show_flat_links_2', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control( 'ges_footer_show_flat_links_2_ctrl', array(
        'label'    => esc_html__( 'Tampilkan Navigasi Dasar Baris 2 (Regional)', 'gesahan-news-pro' ),
        'section'  => 'ges_footer_section',
        'settings' => 'ges_footer_show_flat_links_2',
        'type'     => 'checkbox',
    ));

    $wp_customize->add_setting( 'ges_footer_flat_links_text_2', array(
        'default'           => '<a href="#">GN U.S.</a> | <a href="#">GN International</a> | <a href="#">GN en ESPAÑOL</a> | <a href="#">GN Chile</a> | <a href="#">GN México</a>',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control( 'ges_footer_flat_links_text_2_ctrl', array(
        'label'    => esc_html__( 'Isi HTML Navigasi Dasar Baris 2 (Regional)', 'gesahan-news-pro' ),
        'section'  => 'ges_footer_section',
        'settings' => 'ges_footer_flat_links_text_2',
        'type'     => 'textarea',
    ));

    // ==========================================
    // 5. COPYRIGHT & DISCLAIMER
    // ==========================================
    $wp_customize->add_setting( 'ges_footer_copyright', array(
        'default'           => '© 2026 Trans Media, GN name, logo and all associated elements (R) and © 2026 Cable News Network, Inc. A Time Warner Company. All rights reserved.',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control( 'ges_footer_copyright_ctrl', array(
        'label'    => esc_html__( 'Teks Disclaimer Copyright', 'gesahan-news-pro' ),
        'section'  => 'ges_footer_section',
        'settings' => 'ges_footer_copyright',
        'type'     => 'textarea',
    ));
}