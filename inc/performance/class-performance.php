<?php
namespace Gentara\Performance;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Enterprise Performance Accelerator (Lighthouse Optimization)
 */
class PerformanceEngine {
    public function __construct() {
        $lazyload_enabled = get_theme_mod( 'ges_perf_lazyload_active', true );

        if ( $lazyload_enabled ) {
            add_filter( 'wp_get_attachment_image_attributes', array( $this, 'inject_native_lazyload' ), 10, 2 );
        }

        add_action( 'wp_head', array( $this, 'inject_resource_hints' ), 2 );
    }

    public function inject_native_lazyload( $attrs, $attachment ) {
        $attrs['loading'] = 'lazy';
        return $attrs;
    }

    public function inject_resource_hints() {
        // Melakukan pre-resolve DNS server periklanan dan font eksternal secara asinkron
        echo '<link rel="dns-prefetch" href="//fonts.googleapis.com">' . "\n";
        echo '<link rel="dns-prefetch" href="//www.googletagservices.com">' . "\n";
    }
}

new PerformanceEngine();