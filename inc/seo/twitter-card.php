<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

function ges_render_twitter_card() {
    $card_style  = 'summary_large_image';
    $title       = get_the_title();
    $description = is_singular() ? wp_strip_all_tags( get_the_excerpt() ) : get_bloginfo( 'description' );

    echo '<meta name="twitter:card" content="' . esc_attr( $card_style ) . '">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr( $description ) . '">' . "\n";

    if ( is_singular() && has_post_thumbnail() ) {
        $image = wp_get_attachment_image_url( get_post_thumbnail_id(), 'full' );
        echo '<meta name="twitter:image" content="' . esc_url( $image ) . '">' . "\n";
    }
}