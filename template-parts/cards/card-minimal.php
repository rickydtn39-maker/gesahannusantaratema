<?php
/**
 * Template Part: Minimal Text-Only Card
 *
 * @package Gentara_News
 */

$card_size_global = get_theme_mod( 'ges_card_size_global', 'medium' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'gds-card-minimal gds-card-size-' . $card_size_global ); ?> style="padding: 12px 0; border-bottom: 1px solid var(--color-border); display: flex; flex-direction: column; justify-content: flex-start; height: 100%; background: var(--card-bg) !important; border: var(--card-border) !important; padding: var(--card-padding) !important; border-radius: var(--card-border-radius) !important;">
    
    <!-- Kategori Badge -->
    <span class="cat-label" style="font-size: 9px; font-weight: 800; color: var(--color-accent); text-transform: uppercase; margin-bottom: 6px; letter-spacing: 0.5px;">
        <?php
        $cats = get_the_category();
        if ( ! empty( $cats ) ) {
            echo esc_html( $cats[0]->name );
        }
        ?>
    </span>
    
    <!-- Judul Berita -->
    <h4 class="gds-minimal-title" style="font-family: var(--font-condensed); font-weight: var(--font-weight-bold); line-height: 1.3; margin: 0 0 8px 0;">
        <a href="<?php the_permalink(); ?>" style="color: var(--color-text-main) !important; text-decoration: none; transition: color var(--duration-fast) var(--ease-standard) !important;"><?php the_title(); ?></a>
    </h4>
    
    <div class="gds-minimal-meta" style="font-size: 10px; color: var(--color-text-muted); margin-top: auto; font-weight: 500;">
        <?php gesahan_posted_on(); ?>
    </div>
</article>