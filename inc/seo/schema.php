<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

function ges_render_article_schema() {
    if ( ! is_single() ) {
        return;
    }

    global $post;
    $thumbnail_id = get_post_thumbnail_id( $post->ID );
    $image_url    = $thumbnail_id ? wp_get_attachment_image_url( $thumbnail_id, 'full' ) : '';

    $schema = array(
        '@context'         => 'https://schema.org',
        '@type'            => 'NewsArticle',
        'headline'         => get_the_title(),
        'image'            => array( $image_url ),
        'datePublished'    => get_the_date( DATE_W3C ),
        'dateModified'     => get_the_modified_date( DATE_W3C ),
        'author'           => array(
            array(
                '@type' => 'Person',
                'name'  => get_the_author(),
                'url'   => get_author_posts_url( get_the_author_meta( 'ID' ) ),
            ),
        ),
        'publisher'        => array(
            '@type' => 'Organization',
            'name'  => get_bloginfo( 'name' ),
            'logo'  => array(
                '@type' => 'ImageObject',
                'url'   => '', // Dapat diintegrasikan ke logo kustom jika tersedia
            ),
        ),
        'description'      => wp_strip_all_tags( get_the_excerpt() ),
    );

    echo '<script type="application/ld+json">' . json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n";
}