<?php
/**
 * Template Part: Header Khusus Perangkat Mobile & Tablet (Android / iOS)
 *
 * @package Gentara_News
 */
?>
<header class="site-header-mobile">
    <div class="mobile-header-container">
        
        <!-- Hamburger Menu Drawer Button -->
        <button class="mobile-nav-toggle" aria-controls="mobile-menu-drawer" aria-expanded="false" aria-label="<?php esc_attr_e( 'Buka Menu Navigasi', 'gentara-news' ); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu">
                <line x1="3" x2="21" y1="12" y2="12"></line>
                <line x1="3" x2="21" y1="6" y2="6"></line>
                <line x1="3" x2="21" y1="18" y2="18"></line>
            </svg>
        </button>

        <!-- Centered Mobile Logo (Image / Text Fallback) -->
        <div class="mobile-logo-box">
            <?php
            if ( has_custom_logo() ) {
                the_custom_logo();
            } else {
                ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="gn-text-logo-mobile" rel="home">
                    <?php echo esc_html( get_theme_mod( 'ges_mobile_logo_text', 'GN' ) ); ?>
                </a>
                <?php
            }
            ?>
        </div>

        <!-- Mobile Header Actions (Search & Dark Mode) -->
        <div class="mobile-header-actions">
            <?php if ( get_theme_mod( 'ges_mobile_show_search', true ) ) : ?>
                <button class="mobile-action-btn search-open-trigger" aria-label="<?php esc_attr_e( 'Cari Berita', 'gentara-news' ); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.3-4.3"></path>
                    </svg>
                </button>
            <?php endif; ?>

            <?php if ( get_theme_mod( 'ges_mobile_show_dark_mode', true ) ) : ?>
                <button class="mobile-action-btn theme-toggle-btn" aria-label="<?php esc_attr_e( 'Ganti Mode Warna', 'gentara-news' ); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-moon">
                        <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path>
                    </svg>
                </button>
            <?php endif; ?>
        </div>

    </div>
</header>