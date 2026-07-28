<?php
/**
 * Komponen: Panel Drawer Geser Samping Mobile
 *
 * @package Gentara_News
 */
?>
<div id="mobile-menu-drawer" class="mobile-menu-drawer" aria-hidden="true">
    <div class="drawer-header">
        <span class="drawer-title"><?php esc_html_e( 'Kategori Berita', 'gentara-news' ); ?></span>
        <button class="mobile-menu-close" aria-label="<?php esc_attr_e( 'Tutup Menu', 'gentara-news' ); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x">
                <line x1="18" x2="6" y1="6" y2="18"></line>
                <line x1="6" x2="18" y1="6" y2="18"></line>
            </svg>
        </button>
    </div>
    
    <nav class="mobile-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Mobile Navigation Menu', 'gentara-news' ); ?>">
        <?php
        if ( has_nav_menu( 'primary' ) ) {
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'mobile-nav-menu',
                'fallback_cb'    => false,
            ) );
        } else {
            // Pengambilan kategori aktif langsung dari database untuk performa maksimal
            $categories = get_categories( array(
                'parent'     => 0,
                'hide_empty' => true,
                'number'     => 8,
                'orderby'    => 'count',
                'order'      => 'DESC'
            ) );

            echo '<ul class="mobile-nav-menu">';
            echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'gentara-news' ) . '</a></li>';
            
            if ( ! empty( $categories ) ) {
                foreach ( $categories as $cat ) {
                    echo '<li><a href="' . esc_url( get_category_link( $cat->term_id ) ) . '">' . esc_html( $cat->name ) . '</a></li>';
                }
            }
            echo '</ul>';
        }
        ?>
    </nav>
</div>
<div class="mobile-drawer-overlay"></div>