<?php
/**
 * Semantic HTML Document Header - Gentara Style (Component-Based Hibrida)
 *
 * @package Gentara_News
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if ( function_exists( 'ges_before_header' ) ) { ges_before_header(); } ?>

<a class="skip-link" href="#primary-content">
    <?php esc_html_e( 'Lompati ke Konten Utama', 'gentara-news' ); ?>
</a>

<!-- 1. DESKTOP UNIFIED 2-TIER HEADER (Gaya Premium Desktop) -->
<header class="site-header hide-on-mobile" role="banner">
    
    <!-- TIER 1: Logo, Kotak Pencarian Lebar, & Dark Mode Toggle -->
    <div class="header-tier-top">
        <div class="container header-tier-top-container">
            
            <!-- Sisi Kiri: Logo Brand Media -->
            <?php get_template_part( 'template-parts/header/branding' ); ?>
            
            <!-- Sisi Kanan: Bar Pencarian & Tombol Pengalih Mode Gelap -->
            <div class="header-top-right">
                
                <!-- Kotak Pencarian Lebar -->
                <form role="search" method="get" class="desktop-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <input type="search" class="desktop-search-input" placeholder="<?php esc_attr_e( 'Masukkan kata pencarian...', 'gentara-news' ); ?>" value="<?php echo get_search_query(); ?>" name="s" required />
                    <button type="submit" class="desktop-search-submit" aria-label="<?php esc_attr_e( 'Cari', 'gentara-news' ); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </svg>
                    </button>
                </form>
                
                <!-- Tombol Mode Gelap -->
                <div class="desktop-actions-wrap">
                    <?php get_template_part( 'template-parts/header/dark-mode-toggle' ); ?>
                </div>

            </div>

        </div>
    </div>

    <!-- TIER 2: Bilah Menu Navigasi Utama (Latar Belakang Gelap Charcoal) -->
    <div class="header-tier-nav">
        <div class="container header-tier-nav-container">
            <?php get_template_part( 'template-parts/header/navigation-desktop' ); ?>
        </div>
    </div>

</header>

<!-- 2. MOBILE 2-TIER HEADER (Khusus Layar HP / Seluler) -->
<?php get_template_part( 'template-parts/header/header-mobile' ); ?>

<!-- Slide-out Drawer Panel Seluler -->
<?php get_template_part( 'template-parts/header/drawer' ); ?>

<!-- 3. TIER 3: Ticker Berita Berjalan (Headline Ticker Bar) -->
<?php get_template_part( 'template-parts/header/ticker' ); ?>

<?php if ( function_exists( 'ges_after_header' ) ) { ges_after_header(); } ?>