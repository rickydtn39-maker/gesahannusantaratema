<?php
namespace Gentara\Core;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Advanced Semantic SEO Breadcrumb Engine
 */
class Breadcrumb {
    public static function render() {
        if ( is_front_page() || is_home() ) {
            return;
        }

        echo '<nav class="gds-breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'gentara-news' ) . '" itemscope itemtype="https://schema.org/BreadcrumbList">';
        
        // Item: Home
        self::print_item( esc_html__( 'Home', 'gentara-news' ), home_url( '/' ), 1 );

        $position = 2;

        if ( is_category() || is_single() ) {
            $categories = get_the_category();
            if ( ! empty( $categories ) ) {
                $primary_cat = $categories[0];
                // Menangani parent category jika tersedia
                if ( $primary_cat->parent ) {
                    $parent_cat = get_category( $primary_cat->parent );
                    self::print_item( $parent_cat->name, get_category_link( $parent_cat->term_id ), $position );
                    $position++;
                }
                self::print_item( $primary_cat->name, get_category_link( $primary_cat->term_id ), $position );
                $position++;
            }
        }

        if ( is_single() ) {
            self::print_item( get_the_title(), null, $position, true );
        } elseif ( is_page() ) {
            self::print_item( get_the_title(), null, $position, true );
        } elseif ( is_archive() && !is_category() ) {
            self::print_item( get_the_archive_title(), null, $position, true );
        } elseif ( is_search() ) {
            self::print_item( sprintf( esc_html__( 'Cari: %s', 'gentara-news' ), get_search_query() ), null, $position, true );
        }

        echo '</nav>';
    }

    private static function print_item( $name, $link = null, $position = 1, $is_active = false ) {
        echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" style="display: inline-flex; align-items: center;">';
        if ( $position > 1 ) {
            echo '<span aria-hidden="true" style="margin: 0 var(--space-xs); color: var(--color-text-muted); font-size: 10px;">&gt;</span>';
        }

        if ( $link && ! $is_active ) {
            echo '<a itemprop="item" href="' . esc_url( $link ) . '" style="color: var(--color-text-main); text-decoration: none; font-weight: var(--font-weight-medium);">';
            echo '<span itemprop="name">' . esc_html( $name ) . '</span>';
            echo '</a>';
        } else {
            echo '<span itemprop="name" aria-current="page" style="color: var(--color-text-muted);">' . esc_html( $name ) . '</span>';
        }
        echo '<meta itemprop="position" content="' . esc_attr( $position ) . '" />';
        echo '</span>';
    }
}