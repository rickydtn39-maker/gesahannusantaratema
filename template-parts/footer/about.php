<?php
/**
 * Komponen: Profil Media, Deskripsi, & Google News Badge
 *
 * @package Gentara_News
 */
?>
<div class="footer-about-content">
    <?php 
    $desc_text = get_theme_mod( 'ges_footer_desc', 'Menyajikan berita terhangat langsung melalui handphone Anda' ); 
    if ( ! empty( $desc_text ) ) : ?>
        <p class="footer-desc-text"><?php echo esc_html( $desc_text ); ?></p>
    <?php endif; ?>

    <?php 
    $download_label = get_theme_mod( 'ges_footer_download_label', 'DOWNLOAD SEKARANG' ); 
    if ( ! empty( $download_label ) ) : ?>
        <p class="footer-download-label"><?php echo esc_html( $download_label ); ?></p>
    <?php endif; ?>
    
    <?php 
    $show_gnews = get_theme_mod( 'ges_footer_show_gnews', true );
    $gnews_url = get_theme_mod( 'ges_footer_gnews_url', '#' );
    if ( $show_gnews && ! empty( $gnews_url ) && $gnews_url !== 'hide' ) : ?>
        <a href="<?php echo esc_url( $gnews_url ); ?>" class="gnews-badge-btn" target="_blank" rel="noopener">
            <span class="gnews-icon-g">G</span>
            <div class="gnews-badge-text">
                Add <strong>GN</strong> as a preferred
                <span>source on Google</span>
            </div>
        </a>
    <?php endif; ?>
</div>