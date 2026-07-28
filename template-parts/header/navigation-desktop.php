<?php
/**
 * Komponen: Menu Navigasi Horizontal Desktop (Dynamic Categories Fallback)
 *
 * @package Gesahan_News_Pro
 */
?>
<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'gesahan-news-pro' ); ?>">
    <?php
    if ( has_nav_menu( 'primary' ) ) {
        wp_nav_menu( array(
            'theme_location' => 'primary',
            'menu_id'        => 'primary-menu',
            'container'      => false,
            'menu_class'     => 'nav-menu',
            'fallback_cb'    => false,
            'walker'         => class_exists( '\GDS\Classes\MegaMenuWalker' ) ? new \GDS\Classes\MegaMenuWalker() : '',
        ) );
    } else {
        // PERBAIKAN: Mengambil 8 kategori induk teraktif langsung dari database (100% Dynamic)
        $categories = get_categories( array(
            'parent'     => 0,
            'hide_empty' => true,
            'number'     => 8,
            'orderby'    => 'count',
            'order'      => 'DESC'
        ) );

        echo '<ul id="primary-menu" class="nav-menu">';
        $home_class = ( is_front_page() || is_home() ) ? ' class="menu-item current-menu-item"' : ' class="menu-item"';
        echo '<li' . $home_class . '><a href="' . esc_url( home_url( '/' ) ) . '" style="background-color: var(--color-accent);">' . esc_html__( 'Home', 'gesahan-news-pro' ) . '</a></li>';
        
        if ( ! empty( $categories ) ) {
            foreach ( $categories as $cat ) {
                $active_class = is_category( $cat->term_id ) ? ' style="background-color: rgba(255,255,255,0.15);"' : '';
                $sub_cats = get_categories( array( 'parent' => $cat->term_id, 'hide_empty' => false ) );
                $has_subs = ! empty( $sub_cats ) ? ' menu-item-has-children' : '';
                
                echo '<li class="menu-item' . $has_subs . '">';
                echo '<a href="' . esc_url( get_category_link( $cat->term_id ) ) . '"' . $active_class . '>' . esc_html( $cat->name );
                if ( ! empty( $sub_cats ) ) {
                    echo ' <span style="font-size: 7px; margin-left: 4px; vertical-align: middle;">&#9662;</span>';
                }
                echo '</a>';
                
                if ( ! empty( $sub_cats ) ) {
                    echo '<ul class="sub-menu">';
                    foreach ( $sub_cats as $sub_cat ) {
                        echo '<li class="menu-item">';
                        echo '<a href="' . esc_url( get_category_link( $sub_cat->term_id ) ) . '">' . esc_html( $sub_cat->name ) . '</a>';
                        echo '</li>';
                    }
                    echo '</ul>';
                }
                echo '</li>';
            }
        }
        echo '</ul>';
    }
    ?>
</nav>