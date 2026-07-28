<?php
/**
 * Komponen: Navigasi Kategori Menu Kaki "TELUSURI"
 *
 * @package Gentara_News
 */
?>
<ul class="footer-links-grid">
    <?php
    if ( has_nav_menu( 'footer' ) ) {
        wp_nav_menu( array(
            'theme_location' => 'footer',
            'container'      => false,
            'items_wrap'     => '%3$s',
            'fallback_cb'    => false,
        ) );
    } else {
        $footer_categories = array( 'Nasional', 'Daerah', 'Internasional', 'Hukum', 'Politik', 'Ekonomi', 'Olahraga', 'Lifestyle', 'Opini' );
        foreach ( $footer_categories as $cat_name ) {
            $cat_obj = get_category_by_slug( sanitize_title( $cat_name ) );
            if ( $cat_obj ) {
                echo '<li><a href="' . esc_url( get_category_link( $cat_obj->term_id ) ) . '">' . esc_html( $cat_obj->name ) . '</a></li>';
            }
        }
    }
    ?>
</ul>