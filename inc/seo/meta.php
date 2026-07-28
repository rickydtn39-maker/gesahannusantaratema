<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

function ges_render_seo_meta() {
    if ( is_singular() ) {
        $meta_description = wp_strip_all_tags( get_the_excerpt() );
        $canonical_url    = esc_url( get_permalink() );
        $robots           = 'index, follow, max-image-preview:large';
    } else {
        $meta_description = esc_attr( get_bloginfo( 'description' ) );
        $canonical_url    = esc_url( home_url( '/' ) );
        $robots           = 'index, follow';
    }

    echo '<meta name="description" content="' . esc_attr( $meta_description ) . '">' . "\n";
    echo '<link rel="canonical" href="' . esc_url( $canonical_url ) . '">' . "\n";
    echo '<meta name="robots" content="' . esc_attr( $robots ) . '">' . "\n";
}