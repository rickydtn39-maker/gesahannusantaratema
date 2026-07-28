<?php
/**
 * Semantic HTML Document Footer - Gentara Style (Component-Based Hibrida)
 *
 * @package Gentara_News
 */
?>
<footer class="site-footer" role="contentinfo">
    
    <!-- 1. Bar Logo & Tagline Atas Footer -->
    <?php if ( get_theme_mod( 'ges_footer_show_logo_bar', true ) ) : ?>
        <div class="footer-logo-bar">
            <div class="container footer-logo-bar-container">
                <div class="footer-brand-wrap">
                    <div class="footer-gn-logo">
                        <?php echo esc_html( get_theme_mod( 'ges_header_logo_text', 'GN' ) ); ?>
                    </div>
                    <?php $tagline = get_theme_mod( 'ges_footer_tagline', 'NEWS WE CAN TRUST' ); ?>
                    <?php if ( ! empty( $tagline ) ) : ?>
                        <span class="footer-gn-tagline">
                            <?php echo esc_html( $tagline ); ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- 2. Grid Utama Widget Kaki (Akordeon Otomatis di HP) -->
    <div class="container">
        <div class="footer-grid-container">

            <!-- Kolom 1: Profil Media & Google News Badge -->
            <div class="footer-col-card">
                <?php if ( is_active_sidebar( 'footer-col-1' ) ) {
                    dynamic_sidebar( 'footer-col-1' );
                } else { ?>
                    <h3 class="footer-section-title"><?php bloginfo( 'name' ); ?></h3>
                    <div class="footer-col-body">
                        <?php get_template_part( 'template-parts/footer/about' ); ?>
                    </div>
                <?php } ?>
            </div>

            <!-- Kolom 2: Link Penelusuran Kategori Kaki -->
            <div class="footer-col-card">
                <?php if ( is_active_sidebar( 'footer-col-2' ) ) {
                    dynamic_sidebar( 'footer-col-2' );
                } else { ?>
                    <h3 class="footer-section-title"><?php esc_html_e( 'TELUSURI', 'gentara-news' ); ?></h3>
                    <div class="footer-col-body">
                        <?php get_template_part( 'template-parts/footer/explore' ); ?>
                    </div>
                <?php } ?>
            </div>

            <!-- Kolom 3: Ikon Sosial Media -->
            <div class="footer-col-card">
                <?php if ( is_active_sidebar( 'footer-col-3' ) ) {
                    dynamic_sidebar( 'footer-col-3' );
                } else { ?>
                    <h3 class="footer-section-title"><?php esc_html_e( 'IKUTI KAMI', 'gentara-news' ); ?></h3>
                    <div class="footer-col-body">
                        <?php get_template_part( 'template-parts/footer/socials' ); ?>
                    </div>
                <?php } ?>
            </div>

        </div>
    </div>

    <!-- 3. Baris Copyright & Teks Kebijakan Kaki -->
    <div class="footer-disclaimer-bar">
        <div class="container">
            <?php 
            $copyright = get_theme_mod( 'ges_footer_copyright', '© 2026 Trans Media, GN' ); 
            if ( ! empty( $copyright ) ) : ?>
                <p><?php echo wp_kses_post( $copyright ); ?></p>
            <?php endif; ?>
            
            <?php if ( get_theme_mod( 'ges_footer_show_flat_links_1', true ) ) : ?>
                <div class="footer-flat-links">
                    <?php 
                    $flat_1_default = '<a href="#">Tentang Kami</a> | <a href="#">Redaksi</a> | <a href="#">Pedoman Media Siber</a> | <a href="#">Karir</a> | <a href="#">Disclaimer</a>';
                    echo wp_kses_post( get_theme_mod( 'ges_footer_flat_links_text_1', $flat_1_default ) ); 
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

</footer>

<!-- Modal Overlay Pencarian Global -->
<div id="search-modal" class="search-modal" role="dialog" aria-modal="true" aria-hidden="true" aria-label="<?php esc_attr_e( 'Form Pencarian', 'gentara-news' ); ?>">
    <div class="search-modal-content">
        <div class="search-modal-header">
            <h3 class="search-modal-title"><?php esc_html_e( 'Cari Berita', 'gentara-news' ); ?></h3>
            <button class="search-close-trigger btn btn-ghost" aria-label="<?php esc_attr_e( 'Tutup', 'gentara-news' ); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                </svg>
            </button>
        </div>
        <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <label>
                <span class="screen-reader-text"><?php echo _x( 'Cari untuk:', 'label', 'gentara-news' ); ?></span>
                <input type="search" class="search-field input-text search-modal-input" placeholder="<?php echo esc_attr_x( 'Ketik kata kunci...', 'placeholder', 'gentara-news' ); ?>" value="<?php echo get_search_query(); ?>" name="s" required />
            </label>
            <button type="submit" class="btn btn-primary btn-md search-submit-btn"><?php echo esc_html_x( 'Cari', 'submit button', 'gentara-news' ); ?></button>
        </form>
    </div>
</div>

<!-- Tombol Kembali ke Atas (Back to Top) -->
<button id="back-to-top" class="back-to-top" aria-label="<?php esc_attr_e( 'Kembali ke atas', 'gentara-news' ); ?>">
    &#8593;
</button>

<!-- POPUP IKLAN ANCHOR MOBILE BOTTOM -->
<?php 
if ( function_exists( 'gesahan_display_ad_spot' ) ) {
    gesahan_display_ad_spot( 'interstitial_anchor' ); 
}
?>

<?php wp_footer(); ?>
</body>
</html>