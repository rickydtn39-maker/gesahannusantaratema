<?php
/**
 * Komponen: Tombol Pemicu Modal Pencarian - Lucide SVG
 *
 * @package Gesahan_News_Pro
 */

$show_desktop = get_theme_mod( 'ges_header_show_search', true );
$show_mobile  = get_theme_mod( 'ges_mobile_show_search', true );

if ( $show_desktop || $show_mobile ) :
    $classes = 'search-open-trigger';
    if ( ! $show_desktop ) { $classes .= ' hide-on-desktop'; }
    if ( ! $show_mobile ) { $classes .= ' hide-on-mobile'; }
    ?>
    <button class="<?php echo esc_attr( $classes ); ?>" aria-label="<?php esc_attr_e( 'Cari Berita', 'gesahan-news-pro' ); ?>">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="m21 21-4.3-4.3"></path>
        </svg>
    </button>
    <?php
endif;