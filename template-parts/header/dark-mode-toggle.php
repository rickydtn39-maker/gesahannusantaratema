<?php
/**
 * Komponen: Tombol Pengalih Mode Gelap/Terang - Lucide SVG
 *
 * @package Gesahan_News_Pro
 */

$show_desktop = get_theme_mod( 'ges_header_show_dark_mode', true );
$show_mobile  = get_theme_mod( 'ges_mobile_show_dark_mode', true );

if ( $show_desktop || $show_mobile ) :
    $classes = 'theme-toggle-btn';
    if ( ! $show_desktop ) { $classes .= ' hide-on-desktop'; }
    if ( ! $show_mobile ) { $classes .= ' hide-on-mobile'; }
    ?>
    <button class="<?php echo esc_attr( $classes ); ?>" aria-label="<?php esc_attr_e( 'Ganti Mode Warna', 'gesahan-news-pro' ); ?>">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-moon">
            <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path>
        </svg>
    </button>
    <?php
endif;