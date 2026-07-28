<?php
/**
 * Front Page - Gentara News Pro Enterprise Edition
 * Sistem Kontrol Modular Page Builder Dinamis Terintegrasi (KISS & SOLID Compliant)
 *
 * @package Gentara_News
 */

get_header();
?>

<main id="primary-content" class="container" role="main" style="margin-top: 10px; display: flex; flex-direction: column; gap: var(--space-md); width: 100%;">

    <!-- TOP LEADERBOARD AD SLOT (Desktop High Monetization) -->
    <div style="margin-bottom: 5px; width: 100%;">
        <?php 
        if ( function_exists( 'ges_has_ad_code' ) && ges_has_ad_code('header_leaderboard') ) {
            gesahan_display_ad_spot('header_leaderboard'); 
        }
        ?>
    </div>

    <!-- SEGMEN BERANDA 1: Hero Utama (Full Screen Container lebar 1200px) -->
    <?php if ( get_theme_mod( 'ges_home_hero_enable', true ) ) : ?>
        <section class="homepage-hero-curated-block" style="width: 100%;">
            <?php get_template_part( 'template-parts/main/hero' ); ?>
        </section>
    <?php endif; ?>

    <!-- SEGMEN BERANDA 2: Nusantara Terkini Slider (Full-Width, Jangan Diubah) -->
    <?php if ( get_theme_mod( 'ges_home_nusantara_enable', true ) ) : ?>
        <?php get_template_part( 'template-parts/main/nusantara-terkini' ); ?>
    <?php endif; ?>

    <!-- SEGMEN BERANDA 3: Sistem Tata Letak Grid Kolom Belah (Split Layout) -->
    <div class="split-layout">
        
        <!-- KOLOM KIRI: Aliran 8 Blok Kategori Manual secara Vertikal -->
        <div class="main-content-column" style="display: flex; flex-direction: column; gap: var(--space-lg); width: 100%;">
            <?php
            $category_blocks = array();

            for ( $i = 1; $i <= 8; $i++ ) {
                if ( get_theme_mod( 'ges_home_cat_block_' . $i . '_enable', false ) ) {
                    $category_blocks['cat_block_' . $i] = array(
                        'order'    => (int) get_theme_mod( 'ges_home_cat_block_' . $i . '_order', (30 + ($i * 5)) ),
                        'callback' => function() use ($i) {
                            $cat_id = get_theme_mod( 'ges_home_cat_block_' . $i . '_id', 0 );
                            $limit  = get_theme_mod( 'ges_home_cat_block_' . $i . '_limit', 4 );
                            $style  = get_theme_mod( 'ges_home_cat_block_' . $i . '_style', 'standard' );
                            
                            get_template_part( 'template-parts/main/category-block', null, array(
                                'block_index' => $i,
                                'cat_id'      => $cat_id,
                                'limit'       => $limit,
                                'style'       => $style,
                            ) );
                        }
                    );
                }
            }

            // Urutkan dan render blok kategori manual tambahan secara dinamis
            if ( ! empty( $category_blocks ) ) {
                uasort( $category_blocks, function( $a, $b ) {
                    return $a['order'] <=> $b['order'];
                });

                foreach ( $category_blocks as $block_key => $block_data ) {
                    call_user_func( $block_data['callback'] );
                }
            }
            ?>
        </div>

        <!-- KOLOM KANAN: BILAH SAMPING BERANDA (Sidebar Column) -->
        <aside class="sidebar-column" role="complementary" aria-label="<?php esc_attr_e( 'Sidebar Beranda', 'gentara-news' ); ?>">
            <?php get_template_part( 'template-parts/main/sidebar' ); ?>
        </aside>

    </div> <!-- .split-layout -->

</main>

<?php
get_footer();