<?php
namespace Gentara\SEO;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Enterprise SEO & OpenGraph Meta Tag Engine
 */
class SEOEngine {
    public function __construct() {
        add_action( 'wp_head', array( $this, 'generate_metadata' ), 1 );
        add_action( 'wp_head', array( $this, 'generate_schema_json' ), 5 );
    }

    public function generate_metadata() {
        require_once GENTARA_DIR . '/inc/seo/meta.php';
        require_once GENTARA_DIR . '/inc/seo/opengraph.php';
        require_once GENTARA_DIR . '/inc/seo/twitter-card.php';

        ges_render_seo_meta();
        ges_render_opengraph();
        ges_render_twitter_card();
    }

    public function generate_schema_json() {
        require_once GENTARA_DIR . '/inc/seo/schema.php';
        ges_render_article_schema();
    }
}

new SEOEngine();