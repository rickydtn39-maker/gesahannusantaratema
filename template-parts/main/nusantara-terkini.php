<?php
/**
 * Template Part: Nusantara Terkini (Regional Auto-Slider Section - 100% Dinamis CNN Style)
 *
 * @package Gentara_News
 */

// 1. Dapatkan Kategori Pilihan Admin dari Dasbor Customizer
$target_cat_id = get_theme_mod( 'ges_home_nusantara_category', 0 );

// Jika admin belum memilih kategori khusus, otomatis cari Kategori ber-slug 'daerah' (Fallback cerdas)
if ( 0 === $target_cat_id ) {
    $daerah_cat = get_category_by_slug( 'daerah' );
    $target_cat_id = $daerah_cat ? $daerah_cat->term_id : 0;
}

$posts_array = array();
$exclude_ids = ! empty( $GLOBALS['gds_hero_post_ids'] ) ? $GLOBALS['gds_hero_post_ids'] : array();

if ( $target_cat_id > 0 ) {
    $sub_cats = get_categories( array(
        'parent'     => $target_cat_id,
        'hide_empty' => true,
    ) );

    // Tarik 1 berita terhangat dari masing-masing anak kategori (Gaya Portal Detik/CNN Regional)
    if ( ! empty( $sub_cats ) ) {
        foreach ( $sub_cats as $sub_cat ) {
            $regional_posts = get_posts( array(
                'posts_per_page' => 1,
                'category'       => $sub_cat->term_id,
                'post__not_in'   => $exclude_ids,
                'post_status'    => 'publish',
            ) );

            if ( ! empty( $regional_posts ) ) {
                $posts_array[] = $regional_posts[0];
            }
        }
    }
}

// Fallback: Jika jumlah postingan regional kurang dari 4, tarik postingan acak dari kategori target langsung
if ( count( $posts_array ) < 4 && $target_cat_id > 0 ) {
    $fallback_posts = get_posts( array(
        'posts_per_page' => 8,
        'category'       => $target_cat_id,
        'post__not_in'   => $exclude_ids,
        'post_status'    => 'publish',
    ) );

    $existing_ids = array_map( function( $p ) { return $p->ID; }, $posts_array );
    foreach ( $fallback_posts as $fp ) {
        if ( ! in_array( $fp->ID, $existing_ids ) ) {
            $posts_array[] = $fp;
        }
    }
}

$posts_array = array_slice( $posts_array, 0, 8 );

if ( ! empty( $posts_array ) ) :
    // Dapatkan judul kustom dari dasbor secara dinamis
    $nusantara_title = get_theme_mod( 'ges_home_nusantara_title', 'Nusantara Terkini' );
    ?>
    <section class="nusantara-terkini-section" aria-label="<?php echo esc_attr( $nusantara_title ); ?>">
        
        <!-- Header Nusantara Terkini (Tombol Navigasi Kiri-Kanan Dihapus) -->
        <div class="nusantara-header">
            <h3 class="nusantara-title">
                <?php echo esc_html( $nusantara_title ); ?>
            </h3>
        </div>

        <!-- Container Slider Track -->
        <div class="nusantara-slider-container">
            <div class="nusantara-slider-track">
                <?php
                foreach ( $posts_array as $post_item ) :
                    setup_postdata( $post_item );
                    ?>
                    <article class="nusantara-slide-card" style="background: var(--card-bg) !important; border: var(--card-border) !important; padding: var(--card-padding) !important; border-radius: var(--card-border-radius) !important; transition: transform var(--duration-standard) var(--ease-out), box-shadow var(--duration-standard) var(--ease-out) !important;">
                        
                        <!-- Thumbnail Vertikal 16:10 -->
                        <div class="nusantara-card-thumbnail" style="border-radius: var(--card-border-radius) !important; overflow: hidden !important;">
                            <a href="<?php the_permalink( $post_item->ID ); ?>" tabindex="-1" aria-hidden="true">
                                <?php 
                                if ( has_post_thumbnail( $post_item->ID ) ) {
                                    echo get_the_post_thumbnail( $post_item->ID, 'gesahan-standard', array( 'loading' => 'lazy' ) );
                                } else {
                                    gesahan_post_thumbnail( 'gesahan-standard' );
                                }
                                ?>
                            </a>
                        </div>

                        <!-- Detail Berita -->
                        <div class="nusantara-card-body">
                            <span class="nusantara-card-badge">
                                <?php 
                                $cats = get_the_category( $post_item->ID );
                                if ( ! empty( $cats ) ) {
                                    echo esc_html( $cats[count($cats)-1]->name );
                                }
                                ?>
                            </span>
                            <h4 class="nusantara-card-title">
                                <a href="<?php the_permalink( $post_item->ID ); ?>"><?php echo esc_html( get_the_title( $post_item->ID ) ); ?></a>
                            </h4>
                            <div class="nusantara-card-meta" style="font-weight: 500;">
                                <?php gesahan_posted_on(); ?>
                            </div>
                        </div>

                    </article>
                    <?php
                endforeach;
                wp_reset_postdata();
                ?>
            </div>
        </div>

    </section>
    <?php
endif;