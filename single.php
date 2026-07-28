<?php
/**
 * Single Article Enterprise News Template
 * Diperbarui dengan Related Posts bercitra premium berbentuk Card Panjang Horisontal,
 * serta Sticky Sidebar khusus memuat Terpopuler (01-05), Iklan, Pilihan Redaksi, dan Tag Populer.
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
    <!-- TOP DROPDOWN AD POPUP (CNN Style) -->
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

<main id="primary-content" class="container split-layout" role="main" style="margin-top: var(--space-md); align-items: start;">
    
    <!-- KOLOM UTAMA KONTEN ARTIKEL (KIRI) -->
    <div class="main-content-column">
        <?php
        while ( have_posts() ) : the_post();
            get_template_part( 'template-parts/post/content-single' );

            // Slot Iklan Bawah Artikel
            if ( function_exists( 'gesahan_display_ad_spot' ) ) {
                gesahan_display_ad_spot( 'below_article' );
            }

            // REDESIGN: Artikel Terkait Premium - CARD PANJANG HORISONTAL (3 Artikel Sejajar Vertikal Rapat Tanpa Garis Pembatas)
            if ( get_theme_mod( 'ges_single_show_related', true ) ) {
                $categories = get_the_category();
                if ( ! empty( $categories ) ) {
                    $related_limit = 3;
                    $related_query = new WP_Query( array(
                        'category__in'        => array( $categories[0]->term_id ),
                        'post__not_in'        => array( get_the_ID() ),
                        'posts_per_page'      => $related_limit,
                        'ignore_sticky_posts' => 1,
                    ));

                    if ( $related_query->have_posts() ) :
                        ?>
                        <section class="related-posts-section" style="margin-top: 16px !important; padding-top: 0 !important; border-top: none !important;">
                            <div class="nusantara-header" style="border-bottom: none; margin-bottom: 14px; padding-bottom: 0;">
                                <h3 class="nusantara-title" style="border-left: 6px solid var(--color-accent); padding-left: 14px; font-size: 18px; font-weight: 900; text-transform: uppercase; line-height: 1.1;">
                                    <?php esc_html_e( 'Rekomendasi Untukmu', 'gentara-news' ); ?>
                                </h3>
                            </div>
                            
                            <!-- Daftar 3 Card Panjang Horisontal Modern -->
                            <div class="gn-related-horizontal-list-container" style="display: flex; flex-direction: column; width: 100%;">
                                <?php
                                while ( $related_query->have_posts() ) : $related_query->the_post();
                                    ?>
                                    <article class="gn-related-premium-card">
                                        
                                        <!-- Thumbnail Sisi Kiri (180px Width) -->
                                        <div class="nusantara-card-thumbnail">
                                            <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true" style="display: block; width: 100%; height: 100%;">
                                                <?php the_post_thumbnail( 'gesahan-standard', array( 'loading' => 'lazy', 'style' => 'width:100%; height:100%; object-fit:cover;' ) ); ?>
                                            </a>
                                        </div>

                                        <!-- Detail Berita Sisi Kanan -->
                                        <div class="nusantara-card-body">
                                            <span class="nusantara-card-badge">
                                                <?php 
                                                $cats = get_the_category();
                                                if ( ! empty( $cats ) ) {
                                                    echo esc_html( $cats[0]->name );
                                                }
                                                ?>
                                            </span>
                                            <h4 class="nusantara-card-title">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h4>
                                            <div class="nusantara-card-meta">
                                                <?php gesahan_posted_on(); ?>
                                            </div>
                                        </div>

                                    </article>
                                    <?php
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

    <!-- KOLOM SIDEBAR DENGAN DUKUNGAN STICKY (KANAN) -->
    <aside class="sidebar-column" role="complementary" aria-label="<?php esc_attr_e('Sidebar', 'gentara-news'); ?>">
        <div class="sticky-sidebar-wrapper">
            
            <?php 
            if ( is_active_sidebar( 'main-sidebar' ) ) {
                dynamic_sidebar( 'main-sidebar' );
            } else {
                // FALLBACK SIDEBAR PREMIUM (Strictly Organized Components)
                ?>
                
                <!-- 1. MOST POPULAR (RANKING NUMERIK INDAH 01-05 PERSIS MAIN BERANDA) -->
                <div class="sidebar-widget-popular-ranks">
                    <div class="terpopuler-header">
                        <h3 class="terpopuler-header-title"><?php esc_html_e( 'Terpopuler', 'gentara-news' ); ?></h3>
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
                                    <!-- Nomor Urut Peringkat Modern -->
                                    <div class="terpopuler-rank">
                                        <?php echo sprintf('%02d', $rank); ?>
                                    </div>
                                    <!-- Detail Konten -->
                                    <div class="terpopuler-content">
                                        <span class="cat-label" style="font-size:8px; margin-bottom:2px; font-weight: bold; color: var(--color-accent); text-transform: uppercase;">
                                            <?php 
                                            $cats = get_the_category();
                                            if(!empty($cats)) echo esc_html($cats[0]->name);
                                            ?>
                                        </span>
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
                </div>

                <!-- 2. SLOT IKLAN SIDEBAR UTAMA -->
                <?php if ( function_exists('ges_has_ad_code') && ges_has_ad_code('hero_sidebar_square') ) : ?>
                    <div class="sidebar-ad-wrapper" style="text-align: center; margin: 10px 0;">
                        <?php gesahan_display_ad_spot( 'hero_sidebar_square' ); ?>
                    </div>
                <?php endif; ?>

                <!-- 3. PILIHAN REDAKSI PREMIUM (Berbungkus Cokelat Transparan & Tepi Cokelat) -->
                <div class="sidebar-widget-editor-choices">
                    <div class="terpopuler-header" style="border-bottom: 2px solid var(--color-accent); margin-bottom: 12px; padding-bottom: 6px;">
                        <h4 class="terpopuler-header-title" style="font-size: 13px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px; color: var(--color-accent);"><?php esc_html_e( 'Pilihan Redaksi', 'gentara-news' ); ?></h4>
                    </div>
                    <div class="sidebar-choices-wrap" style="display: flex; flex-direction: column; gap: 12px;">
                        <?php 
                        $choice_query = new WP_Query( array( 'posts_per_page' => 2, 'post_status' => 'publish' ) );
                        if ( $choice_query->have_posts() ) :
                            while ( $choice_query->have_posts() ) : $choice_query->the_post();
                                ?>
                                <div class="choice-item">
                                    <div class="choice-thumb-wrap">
                                        <?php the_post_thumbnail('gesahan-compact', array('style'=>'width:100%; height:100%; object-fit:cover;')); ?>
                                    </div>
                                    <h5 class="choice-item-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h5>
                                </div>
                                <?php
                            endwhile;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>
                </div>

                <!-- 4. TAG POPULER (POPULAR TAGS CLOUD) -->
                <div class="sidebar-widget-tags-cloud">
                    <div class="terpopuler-header" style="border-bottom: 2px solid #000; margin-bottom: 12px; padding-bottom: 6px;">
                        <h4 class="terpopuler-header-title" style="font-size: 13px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px;"><?php esc_html_e( 'Tag Populer', 'gentara-news' ); ?></h4>
                    </div>
                    <div class="tags-cloud-wrap" style="display: flex; flex-wrap: wrap; gap: 6px;">
                        <?php 
                        $cloud_tags = get_tags(array('orderby' => 'count', 'order' => 'DESC', 'number' => 10));
                        if ( ! empty($cloud_tags) ) {
                            foreach ( $cloud_tags as $ctag ) {
                                echo '<a href="' . esc_url( get_tag_link($ctag->term_id) ) . '" style="font-size: 11px; font-weight: 700; color: #555; text-decoration: none; border: 1px solid var(--color-border); padding: 4px 8px; background-color:#FAFAFA;">' . esc_html($ctag->name) . '</a>';
                            }
                        }
                        ?>
                    </div>
                </div>

                <?php
            }
            ?>

            <!-- SLOT IKLAN: Sidebar Sticky (Melayang Menempel Saat Di-scroll) -->
            <?php if ( function_exists('ges_has_ad_code') && ges_has_ad_code('sidebar_sticky') ) : ?>
                <div style="position: sticky; top: 70px; margin-top: var(--space-md);">
                    <?php gesahan_display_ad_spot( 'sidebar_sticky' ); ?>
                </div>
            <?php endif; ?>

        </div> <!-- .sticky-sidebar-wrapper -->
    </aside>
</main>

<?php
get_footer();