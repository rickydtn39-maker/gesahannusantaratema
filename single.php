<?php
/**
 * Single Article Enterprise News Template
 *
 * @package Gentara_News
 */

get_header();

// Mengambil kode iklan top dropdown secara dinamis
$top_dropdown_code = '';
if ( function_exists('gesahan_get_ad_code') && function_exists('ges_sanitize_ad_code') ) {
    $top_dropdown_code = ges_sanitize_ad_code( gesahan_get_ad_code( 'top_dropdown' ) );
}

if ( ! empty( $top_dropdown_code ) ) :
    ?>
    <!-- TOP DROPDOWN AD POPUP (CNN Style) - Hanya dirender jika kode iklan tersedia -->
    <div id="top-dropdown-ad" class="top-dropdown-ad" aria-hidden="true">
        <div class="top-dropdown-ad-container" style="max-width: 970px; margin: 0 auto; position: relative;">
            <button id="top-dropdown-ad-close" class="top-dropdown-ad-close" aria-label="<?php esc_attr_e('Tutup Iklan', 'gentara-news'); ?>">&times;</button>
            <div class="top-dropdown-ad-content" style="display:flex; justify-content:center;">
                <?php echo $top_dropdown_code; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </div>
        </div>
    </div>
    <?php
endif;
?>

<main id="primary-content" class="container split-layout" role="main" style="margin-top: var(--space-md);">
    <div class="main-content-column">
        <?php
        while ( have_posts() ) : the_post();
            get_template_part( 'template-parts/post/content-single' );

            // Slot Iklan Bawah Artikel
            if ( function_exists( 'gesahan_display_ad_spot' ) ) {
                gesahan_display_ad_spot( 'below_article' );
            }

            // Rekomendasi Berita Terkait di Bawah Artikel (Dinamis via Customizer)
            if ( get_theme_mod( 'ges_single_show_related', true ) ) {
                $categories = get_the_category();
                if ( ! empty( $categories ) ) {
                    $related_limit = get_theme_mod( 'ges_single_related_limit', 3 );
                    $related_query = new WP_Query( array(
                        'category__in'        => array( $categories[0]->term_id ),
                        'post__not_in'        => array( get_the_ID() ),
                        'posts_per_page'      => $related_limit,
                        'ignore_sticky_posts' => 1,
                    ));

                    if ( $related_query->have_posts() ) :
                        ?>
                        <section class="related-posts-section" style="margin-top: var(--space-lg); border-top: 1px solid var(--color-border); padding-top: var(--space-md);">
                            <div class="terpopuler-header" style="border-bottom:2px solid var(--color-accent); margin-bottom: var(--space-sm);">
                                <span><?php esc_html_e( 'Rekomendasi Untukmu', 'gentara-news' ); ?></span>
                            </div>
                            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: var(--space-md); margin-bottom:var(--space-md);">
                                <?php
                                while ( $related_query->have_posts() ) : $related_query->the_post();
                                    get_template_part( 'template-parts/cards/card-related' );
                                endwhile;
                                ?>
                            </div>
                        </section>
                        <?php
                    endif;
                    wp_reset_postdata();
                }
            }

            // SLOT IKLAN: Di Atas Komentar (Above Comments)
            if ( function_exists( 'gesahan_display_ad_spot' ) ) {
                gesahan_display_ad_spot( 'above_comments' );
            }

            // Integrasi Modul Komentar
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
        endwhile;
        ?>
    </div>

    <!-- Sidebar Dinamis Beranda & Slot Iklan Sticky -->
    <aside class="sidebar-column" role="complementary" aria-label="<?php esc_attr_e('Sidebar', 'gentara-news'); ?>">
        <?php 
        if ( is_active_sidebar( 'main-sidebar' ) ) {
            dynamic_sidebar( 'main-sidebar' );
        } else {
            // FALLBACK DEFAULT SIDEBAR POPULER
            ?>
            <div class="terpopuler-header">
                <?php esc_html_e( 'Terpopuler', 'gentara-news' ); ?>
            </div>
            <div class="terpopuler-list">
                <?php
                $popular_query = new WP_Query( array(
                    'posts_per_page' => 5,
                    'orderby'        => 'comment_count',
                    'post_status'    => 'publish',
                ) );
                if ( $popular_query->have_posts() ) :
                    $rank = 1;
                    while ( $popular_query->have_posts() ) : $popular_query->the_post();
                        ?>
                        <div class="terpopuler-item">
                            <div class="terpopuler-rank"><?php echo sprintf('%02d', $rank); ?></div>
                            <div class="terpopuler-content">
                                <span class="cat-label" style="font-size:9px; margin-bottom:2px;"><?php 
                                    $cats = get_the_category();
                                    if(!empty($cats)) echo esc_html($cats[0]->name);
                                ?></span>
                                <h4 class="terpopuler-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h4>
                            </div>
                        </div>
                        <?php
                        $rank++;
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
            <?php
        }
        ?>

        <!-- SLOT IKLAN: Sidebar Sticky (Hanya dirender jika kode diaktifkan) -->
        <?php if ( function_exists('ges_has_ad_code') && ges_has_ad_code('sidebar_sticky') ) : ?>
            <div style="position: sticky; top: 70px; margin-top: var(--space-md);">
                <?php gesahan_display_ad_spot( 'sidebar_sticky' ); ?>
            </div>
        <?php endif; ?>
    </aside>
</main>

<?php
get_footer();