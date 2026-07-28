<?php
/**
 * Template Part: Hero Article Card (Customizer Compliant)
 *
 * @package Gentara_News
 */

$card_size_global = get_theme_mod( 'ges_card_size_global', 'medium' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'hero-card gds-card-size-' . $card_size_global ); ?> style="background: var(--card-bg) !important; border: var(--card-border) !important; padding: var(--card-padding) !important; border-radius: var(--card-border-radius) !important;">
    
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="hero-thumbnail" style="border-radius: var(--card-border-radius) !important; overflow: hidden; aspect-ratio: 16/9; width: 100%;">
            <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true" style="display: block; width: 100%; height: 100%;">
                <?php the_post_thumbnail( 'gesahan-hero', array( 'loading' => 'eager', 'style' => 'width:100%; height:100%; object-fit:cover;' ) ); ?>
            </a>
        </div>
    <?php endif; ?>

    <div class="hero-body" style="padding-top: 10px;">
        <div class="gds-card-meta" style="font-size: 10px; color: var(--color-text-muted); margin-bottom: 6px;">
            <?php
            $cats = get_the_category();
            if ( ! empty( $cats ) ) {
                echo '<span style="color:var(--color-accent); font-weight:var(--font-weight-bold); margin-right:4px;">' . esc_html( $cats[0]->name ) . '</span>';
            }
            gesahan_posted_on();
            ?>
        </div>
        <h2 class="hero-title" style="display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; font-weight: 900; line-height: 1.25;">
            <a href="<?php the_permalink(); ?>" style="color:var(--color-primary); text-decoration:none;"><?php the_title(); ?></a>
        </h2>
        <p style="color: var(--color-text-muted); font-size: 13px; margin-top: 6px;"><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p>
    </div>
</article>