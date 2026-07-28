<?php
/**
 * Template Part: Mini GN Editorial Card (Customizer Compliant)
 *
 * @package Gentara_News
 */

$card_size_global = get_theme_mod( 'ges_card_size_global', 'medium' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'gn-sub-card gds-card-size-' . $card_size_global ); ?> style="padding: 8px 0; border-bottom: 1px solid var(--color-border); display: flex; gap: var(--space-xs); align-items: center; background: var(--card-bg) !important; border: var(--card-border) !important; padding: var(--card-padding) !important; border-radius: var(--card-border-radius) !important;">
    
    <!-- Thumbnail Kompak -->
    <div class="gn-sub-card-thumb" style="width:70px; height:46px; flex-shrink: 0; overflow: hidden; border-radius: var(--card-border-radius) !important;">
        <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true" style="display: block; width: 100%; height: 100%;">
            <?php gesahan_post_thumbnail( 'gesahan-compact' ); ?>
        </a>
    </div>

    <div class="gn-sub-card-content" style="min-width: 0; flex: 1;">
        <h4 class="gn-sub-card-title" style="font-weight:var(--font-weight-bold); line-height:1.2; margin: 0;">
            <a href="<?php the_permalink(); ?>" style="color:var(--color-text-main); text-decoration:none;"><?php the_title(); ?></a>
        </h4>
        <div class="gds-card-meta" style="font-size: 8px; color: var(--color-text-muted); margin-top: 2px;">
            <?php gesahan_posted_on(); ?>
        </div>
    </div>
</article>