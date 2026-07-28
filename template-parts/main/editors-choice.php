<?php
/**
 * Template Part: Desktop Horizontal Editor's Choice Strip inside Main Column (740px)
 *
 * @package Gesahan_News_Pro
 */

$choice_cat = get_theme_mod( 'ges_home_choice_category', 0 );

$choice_args = array(
    'posts_per_page'      => 3,
    'post_status'         => 'publish',
    'ignore_sticky_posts' => 1,
);

if ( $choice_cat > 0 ) {
    $choice_args['cat'] = $choice_cat;
}

$choice_query = new WP_Query( $choice_args );

if ( $choice_query->have_posts() ) :
    ?>
    <section class="editors-choice-desktop-strip" style="width: 100%; box-sizing: border-box;">
        
        <div style="border-left: 3px solid var(--color-accent); padding-left: 10px; margin-bottom: 10px;">
            <h3 style="font-family: var(--font-sans); font-size: 12px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; color: var(--color-text-main); margin: 0;">
                <?php esc_html_e( 'Pilihan Redaksi', 'gesahan-news-pro' ); ?>
            </h3>
        </div>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; width: 100%;">
            <?php
            while ( $choice_query->have_posts() ) : $choice_query->the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'gds-card-choice' ); ?> style="display: flex; gap: var(--space-xs); align-items: center; background-color: var(--color-bg-surface); padding: 8px; border: 1px solid var(--color-border); border-radius: var(--border-radius-sm); box-sizing: border-box; overflow: hidden;">
                    <!-- Thumbnail Kompak di Kiri -->
                    <div class="choice-thumb" style="width: 70px; height: 50px; flex-shrink: 0; overflow: hidden; background-color: var(--color-border); border-radius: 2px;">
                        <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true" style="display: block; width: 100%; height: 100%;">
                            <?php gesahan_post_thumbnail( 'gesahan-compact' ); ?>
                        </a>
                    </div>
                    <!-- Judul & Meta di Kanan (Diperbarui menggunakan waktu relatif) -->
                    <div class="choice-content" style="display: flex; flex-direction: column; justify-content: center; min-width: 0;">
                        <h4 class="choice-title" style="font-family: var(--font-condensed); font-size: 12px; font-weight: var(--font-weight-bold); line-height: 1.25; margin: 0 0 4px 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            <a href="<?php the_permalink(); ?>" style="color: var(--color-text-main); text-decoration: none;"><?php the_title(); ?></a>
                        </h4>
                        <span class="choice-meta" style="font-size: 9px; color: var(--color-text-muted); font-weight: 500;">
                            <?php gesahan_posted_on(); ?>
                        </span>
                    </div>
                </article>
                <?php
            endwhile;
            ?>
        </div>
    </section>
    <?php
    wp_reset_postdata();
endif;