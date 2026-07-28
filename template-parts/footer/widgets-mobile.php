<?php
/**
 * Template Part: Widget Footer Khusus Mobile & Tablet
 *
 * @package Gentara_News
 */

$use_accordion = get_theme_mod( 'ges_mobile_footer_accordion', true ) ? 'has-accordion' : 'no-accordion';
?>
<div class="mobile-footer-widgets-container <?php echo esc_attr( $use_accordion ); ?>">

    <!-- KOLOM HP 1: Tentang Kami -->
    <div class="mobile-footer-card">
        <h3 class="mobile-footer-title">
            <?php esc_html_e( 'TENTANG KAMI', 'gentara-news' ); ?>
            <span class="accordion-arrow">▼</span>
        </h3>
        <div class="mobile-footer-body">
            <?php if ( is_active_sidebar( 'mobile-footer-col-1' ) ) {
                dynamic_sidebar( 'mobile-footer-col-1' );
            } else { ?>
                <p><?php echo esc_html( get_theme_mod( 'ges_footer_desc', 'Menyajikan berita terhangat langsung melalui handphone Anda' ) ); ?></p>
            <?php } ?>
        </div>
    </div>

    <!-- KOLOM HP 2: Navigasi Kategori (Telusuri) -->
    <div class="mobile-footer-card">
        <h3 class="mobile-footer-title">
            <?php esc_html_e( 'TELUSURI', 'gentara-news' ); ?>
            <span class="accordion-arrow">▼</span>
        </h3>
        <div class="mobile-footer-body">
            <ul class="mobile-footer-links">
                <?php
                $footer_categories = array( 'Nasional', 'Daerah', 'Internasional', 'Hukum', 'Politik', 'Ekonomi', 'Olahraga', 'Lifestyle', 'Opini' );
                foreach ( $footer_categories as $cat_name ) {
                    $cat_obj = get_category_by_slug( sanitize_title( $cat_name ) );
                    if ( $cat_obj ) {
                        echo '<li><a href="' . esc_url( get_category_link( $cat_obj->term_id ) ) . '">' . esc_html( $cat_obj->name ) . '</a></li>';
                    }
                }
                ?>
            </ul>
        </div>
    </div>

    <!-- KOLOM HP 3: Media Sosial & Google News -->
    <div class="mobile-footer-card">
        <h3 class="mobile-footer-title">
            <?php esc_html_e( 'IKUTI KAMI', 'gentara-news' ); ?>
            <span class="accordion-arrow">▼</span>
        </h3>
        <div class="mobile-footer-body" style="text-align: center;">
            <?php if ( get_theme_mod( 'ges_footer_show_socials', true ) ) : ?>
                <div class="mobile-social-wrap" style="display:flex; gap:12px; justify-content:center; margin-bottom:15px;">
                    <?php
                    $social_platforms = array( 'facebook' => 'F', 'x' => 'X', 'instagram' => 'I', 'tiktok' => 'T' );
                    foreach ( $social_platforms as $slug => $char ) {
                        $link = get_theme_mod( 'ges_social_' . $slug, '#' );
                        if ( ! empty( $link ) && $link !== 'hide' ) {
                            echo '<a href="' . esc_url( $link ) . '" class="footer-social-icon">' . esc_html( $char ) . '</a>';
                        }
                    }
                    ?>
                </div>
            <?php endif; ?>

            <?php 
            $show_gnews = get_theme_mod( 'ges_footer_show_gnews', true );
            $gnews_url = get_theme_mod( 'ges_footer_gnews_url', '#' );
            if ( $show_gnews && ! empty( $gnews_url ) && $gnews_url !== 'hide' ) : ?>
                <a href="<?php echo esc_url( $gnews_url ); ?>" class="gnews-badge-btn" target="_blank" rel="noopener" style="margin: 0 auto;">
                    <span class="gnews-icon-g">G</span>
                    <div class="gnews-badge-text">
                        Add <strong>GN</strong> as a preferred
                        <span>source on Google</span>
                    </div>
                </a>
            <?php endif; ?>
        </div>
    </div>

</div>