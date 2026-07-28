<?php
/**
 * Template Part: Curated Featured Card (Customizer Compliant)
 *
 * @package Gentara_News
 */

$card_size_global = get_theme_mod( 'ges_card_size_global', 'medium' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'gds-card gds-card-size-' . $card_size_global ); ?> style="margin-bottom:var(--space-sm); background: var(--card-bg) !important; border: var(--card-border) !important; padding: var(--card-padding) !important; border-radius: var(--card-border-radius) !important; transition: transform var(--duration-standard) var(--ease-out), box-shadow var(--duration-standard) var(--ease-out) !important;">
    
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="gds-card-thumbnail" style="border-radius: var(--card-border-radius) !important; overflow: hidden;">
            <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true" style="display: block; width: 100%; height: 100%;">
                <?php the_post_thumbnail( 'gesahan-standard', array( 'loading' => 'lazy', 'style' => 'width:100%; height:100%; object-fit:cover;' ) ); ?>
            </a>
        </div>
    <?php endif; ?>

    <div class="gds-card-body" style="padding: 6px 0 0 0;">
        <h4 class="gds-card-title" style="min-height:auto; margin:0; font-weight: var(--font-weight-bold); line-height: 1.35;">
            <a href="<?php the_permalink(); ?>" style="color:var(--color-primary); text-decoration:none;"><?php the_title(); ?></a>
        </h4>
        <div class="gds-card-meta" style="margin-top:4px; font-size: 9px; color: var(--color-text-muted);">
            <?php gesahan_posted_on(); ?>
        </div>
    </div>
</article>