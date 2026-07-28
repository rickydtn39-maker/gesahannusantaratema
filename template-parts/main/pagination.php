<?php
/**
 * Template Part: Desktop Pagination Link Layout (pagination.php)
 *
 * @package Gesahan_News_Pro
 */

// Menerima parameter query yang dikirimkan oleh file pemanggil
$custom_query = isset( $args['query'] ) ? $args['query'] : null;

if ( class_exists( '\GDS\Classes\Pagination' ) ) {
    \GDS\Classes\Pagination::render( $custom_query ); 
} else {
    // Fallback jika class pagination OOP tidak terbaca
    the_posts_pagination( array(
        'mid_size'  => 2,
        'prev_text' => esc_html__( 'Sebelumnya', 'gesahan-news-pro' ),
        'next_text' => esc_html__( 'Berikutnya', 'gesahan-news-pro' ),
    ) );
}