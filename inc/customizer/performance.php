<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

function gesahan_customize_performance( $wp_customize ) {
    $wp_customize->add_section( 'ges_perf_section', array(
        'title'    => esc_html__( 'Optimasi Performa', 'gesahan-news-pro' ),
        'panel'    => 'gesahan_theme_options',
        'priority' => 50,
    ));

    $wp_customize->add_setting( 'ges_perf_lazyload_active', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control( 'ges_perf_lazyload_active_ctrl', array(
        'label'       => esc_html__( 'Aktifkan Native Lazyload', 'gesahan-news-pro' ),
        'description' => esc_html__( 'Membantu meningkatkan nilai Lighthouse & LCP.', 'gesahan-news-pro' ),
        'section'     => 'ges_perf_section',
        'settings'    => 'ges_perf_lazyload_active',
        'type'        => 'checkbox',
    ));
}