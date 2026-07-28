<?php
namespace Gentara\Core;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Accessible Numbered Pagination Engine
 */
class Pagination {
    public static function render( $query = null ) {
        if ( null === $query ) {
            global $wp_query;
            $query = $wp_query;
        }

        if ( $query->max_num_pages <= 1 ) {
            return;
        }

        $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
        $max   = intval( $query->max_num_pages );

        echo '<nav class="navigation pagination" role="navigation" aria-label="' . esc_attr__( 'Paginasi Berita', 'gentara-news' ) . '" style="margin: var(--space-lg) 0;">';
        echo '<div class="nav-links" style="display: flex; gap: var(--space-xs); justify-content: center; align-items: center; list-style: none;">';

        // Tombol Sebelumnya
        if ( $paged > 1 ) {
            echo '<a class="prev page-numbers btn btn-outline btn-sm" href="' . esc_url( get_pagenum_link( $paged - 1 ) ) . '">' . esc_html__( 'Sebelumnya', 'gentara-news' ) . '</a>';
        }

        for ( $i = 1; $i <= $max; $i++ ) {
            if ( $i == $paged ) {
                echo '<span aria-current="page" class="page-numbers current btn btn-primary btn-sm">' . esc_html( $i ) . '</span>';
            } elseif ( $i == 1 || $i == $max || ( $i >= $paged - 2 && $i <= $paged + 2 ) ) {
                echo '<a class="page-numbers btn btn-outline btn-sm" href="' . esc_url( get_pagenum_link( $i ) ) . '">' . esc_html( $i ) . '</a>';
            } elseif ( ( $i == 2 && $paged > 4 ) || ( $i == $max - 1 && $paged < $max - 3 ) ) {
                echo '<span class="page-numbers dots" style="color: var(--color-text-muted);">...</span>';
            }
        }

        // Tombol Selanjutnya
        if ( $paged < $max ) {
            echo '<a class="next page-numbers btn btn-outline btn-sm" href="' . esc_url( get_pagenum_link( $paged + 1 ) ) . '">' . esc_html__( 'Berikutnya', 'gentara-news' ) . '</a>';
        }

        echo '</div>';
        echo '</nav>';
    }
}