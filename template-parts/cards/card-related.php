<?php
/**
 * Template Part: Related Post Card (Minimalist grid layout)
 *
 * @package Gentara_News
 */

$card_size_global = get_theme_mod( 'ges_card_size_global', 'medium' );
?>
<div id="post-<?php the_ID(); ?>" class="related-post-card gds-card-size-<?php echo esc_attr( $card_size_global ); ?>" style="display:flex; flex-direction:column; gap:var(--space-xs); background: var(--card-bg) !important; border: var(--card-border) !important; padding: var(--card-padding) !important; border-radius: var(--card-border-radius) !important; transition: transform var(--duration-standard) var(--ease-out), box-shadow var(--duration-standard) var(--ease-out) !important;">
    
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="gds-card-thumbnail" style="border-radius:var(--card-border-radius) !important; overflow:hidden;">
            <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true" style="display: block; width: 100%; height: 100%;">
                <?php the_post_thumbnail( 'gesahan-standard', array( 'loading' => 'lazy', 'style' => 'width:100%; height:100%; object-fit:cover;' ) ); ?>
            </a>
        </div>
    <?php endif; ?>

    <h4 style="line-height:var(--line-height-tight); font-weight: var(--font-weight-bold); margin:0;">
        <a href="<?php the_permalink(); ?>" style="color:var(--color-primary); text-decoration:none;"><?php the_title(); ?></a>
    </h4>
    
    <div class="gds-card-meta" style="font-size: 8px; color: var(--color-text-muted); font-weight: 500;">
        <?php gesahan_posted_on(); ?>
    </div>
</div>