<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

function ges_render_opengraph() {
    $title       = get_the_title();
    $site_name   = get_bloginfo( 'name' );
    $type        = is_singular() ? 'article' : 'website';
    $url         = is_singular() ? get_permalink() : home_url( '/' );
    $description = is_singular() ? wp_strip_all_tags( get_the_excerpt() ) : get_bloginfo( 'description' );

    echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr( $site_name ) . '">' . "\n";
    echo '<meta property="og:type" content="' . esc_attr( $type ) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr( $description ) . '">' . "\n";

    if ( is_singular() && has_post_thumbnail() ) {
        $image = wp_get_attachment_image_url( get_post_thumbnail_id(), 'full' );
        echo '<meta property="og:image" content="' . esc_url( $image ) . '">' . "\n";
    }
}