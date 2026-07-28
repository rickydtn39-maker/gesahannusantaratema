<?php
/**
 * Template Navigasi Utama Aksesibel
 */
?>
<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'gesahan-news-pro' ); ?>">
    <button class="nav-toggle btn btn-ghost" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e( 'Buka Menu', 'gesahan-news-pro' ); ?>">
        &#9776;
    </button>

    <?php
    wp_nav_menu( array(
        'theme_location' => 'primary',
        'menu_id'        => 'primary-menu',
        'container'      => false,
        'menu_class'     => 'nav-menu',
        'fallback_cb'    => 'wp_page_menu',
        'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
    ) );
    ?>
</nav>