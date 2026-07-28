<?php
/**
 * Komponen: Daftar Ikon Sosial Media Bulat
 *
 * @package Gentara_News
 */
?>
<?php if ( get_theme_mod( 'ges_footer_show_socials', true ) ) : ?>
    <div class="footer-social-grid">
        <?php
        $social_platforms = array( 'facebook' => 'F', 'x' => 'X', 'instagram' => 'I', 'tiktok' => 'T' );
        foreach ( $social_platforms as $slug => $char ) {
            $link = get_theme_mod( 'ges_social_' . $slug, '#' );
            if ( ! empty( $link ) && $link !== 'hide' ) {
                echo '<a href="' . esc_url( $link ) . '" class="footer-social-icon" target="_blank" rel="noopener">' . esc_html( $char ) . '</a>';
            }
        }
        ?>
    </div>
<?php endif; ?>