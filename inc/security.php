<?php
/**
 * Helper Keamanan dan Sanitasi Input/Output Tema (GDS Volume 6)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Mencegah akses langsung ke script demi keamanan server
}

/**
 * Melakukan sanitasi unit script periklanan secara aman tanpa merusak kode JS iklan (Volume 6 Bab 2 & 9)
 */
function ges_sanitize_ad_code( $raw_code ) {
    if ( empty( $raw_code ) ) {
        return '';
    }

    // Administrator dengan hak penuh dapat langsung menyematkan HTML apa pun
    if ( current_user_can( 'unfiltered_html' ) ) {
        return $raw_code;
    }

    // Enterprise Whitelist sanitasi untuk script iklan Adsense / Custom Banner Iframe
    $allowed_tags = array(
        'script' => array(
            'src'            => true,
            'async'          => true,
            'defer'          => true,
            'type'           => true,
            'charset'        => true,
            'crossorigin'    => true,
        ),
        'ins' => array(
            'class'                      => true,
            'style'                      => true,
            'data-ad-client'             => true,
            'data-ad-slot'               => true,
            'data-ad-format'             => true,
            'data-full-width-responsive' => true,
        ),
        'iframe' => array(
            'src'             => true,
            'width'           => true,
            'height'          => true,
            'frameborder'     => true,
            'style'           => true,
            'scrolling'       => true,
            'allowfullscreen' => true,
            'loading'         => true,
        ),
        'div' => array(
            'class' => true,
            'style' => true,
            'id'    => true,
        ),
        'a' => array(
            'href'   => true,
            'target' => true,
            'class'  => true,
            'style'  => true,
            'rel'    => true,
        ),
        'img' => array(
            'src'    => true,
            'alt'    => true,
            'width'  => true,
            'height' => true,
            'style'  => true,
            'class'  => true,
        ),
    );

    return wp_kses( $raw_code, $allowed_tags );
}