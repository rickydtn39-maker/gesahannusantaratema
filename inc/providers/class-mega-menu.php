<?php
namespace Gentara\Core;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Walker Nav Menu - CNN Black Theme Style
 */
class MegaMenuWalker extends \Walker_Nav_Menu {
    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $args = is_array( $args ) ? (object) $args : $args;
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu\">\n";
    }

    public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
        $args = is_array( $args ) ? (object) $args : $args;
        $menu_item = $data_object;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $classes = empty( $menu_item->classes ) ? array() : (array) $menu_item->classes;
        $classes[] = 'menu-item-' . $menu_item->ID;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $menu_item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $output .= $indent . '<li' . $class_names . '>';

        $atts = array();
        $atts['title']  = ! empty( $menu_item->attr_title ) ? $menu_item->attr_title : '';
        $atts['target'] = ! empty( $menu_item->target )     ? $menu_item->target     : '';
        $atts['rel']    = ! empty( $menu_item->xfn )        ? $menu_item->xfn        : '';
        $atts['href']   = ! empty( $menu_item->url )        ? $menu_item->url        : '';

        $has_children = in_array( 'menu-item-has-children', $classes, true );

        if ( $has_children ) {
            $atts['aria-haspopup'] = 'true';
            $atts['aria-expanded'] = 'false';
        }

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $menu_item, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $val ) {
            if ( ! empty( $val ) ) {
                $val = ( 'href' === $attr ) ? esc_url( $val ) : esc_attr( $val );
                $attributes .= ' ' . $attr . '="' . $val . '"';
            }
        }

        $title = apply_filters( 'the_title', $menu_item->title, $menu_item->ID );

        $before       = isset( $args->before ) ? $args->before : '';
        $after        = isset( $args->after ) ? $args->after : '';
        $link_before  = isset( $args->link_before ) ? $args->link_before : '';
        $link_after   = isset( $args->link_after ) ? $args->link_after : '';

        $item_output = $before;
        $item_output .= '<a' . $attributes . ' class="nav-link-item">';
        $item_output .= $link_before . $title . $link_after;
        
        if ( $depth === 0 && $has_children ) {
            $item_output .= ' <span style="font-size: 7px; margin-left: 4px; vertical-align: middle;">&#9662;</span>';
        }
        
        $item_output .= '</a>';
        $item_output .= $after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $menu_item, $depth, $args );
    }
}