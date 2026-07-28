<?php
/**
 * Komponen: Logo Branding Khas Gesahan Nusantara (Mendukung Image Upload / Text Fallback)
 *
 * @package Gesahan_News_Pro
 */
?>
<div class="gn-logo-box">
    <?php
    if ( has_custom_logo() ) {
        the_custom_logo();
    } else {
        ?>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="gn-text-logo" rel="home">
            <?php echo esc_html( get_theme_mod( 'ges_header_logo_text', 'GN' ) ); ?>
        </a>
        <?php
    }
    ?>
</div>