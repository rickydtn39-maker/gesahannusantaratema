<?php
/**
 * Template Part: Desktop Main Hero Grid Split (Detik.com Style Hero Utama & Modern Terpopuler)
 *
 * @package Gentara_News
 */

// Ambil setelan kategori sumber Hero dari Customizer
$hero_cat = get_theme_mod( 'ges_home_hero_category', 0 );

$hero_args = array(
    'posts_per_page'      => 1, // Hanya 1 Hero Utama
    'post_status'         => 'publish',
    'ignore_sticky_posts' => 1,
);

if ( $hero_cat > 0 ) {
    $hero_args['cat'] = $hero_cat;
}

$hero_query = new WP_Query( $hero_args );

if ( $hero_query->have_posts() ) :
    // Daftarkan ID post untuk mencegah duplikasi konten di aliran "Berita Terbaru" secara ketat
    $GLOBALS['gds_hero_post_ids'] = array();
    ?>
    <div class="gn-hero-grid-wrapper">
        
        <?php
        while ( $hero_query->have_posts() ) : $hero_query->the_post();
            $GLOBALS['gds_hero_post_ids'][] = get_the_ID();
            ?>
            <!-- KOLOM KIRI: HERO UTAMA (100% PERSIS DETIK.COM) -->
            <div class="gn-hero-container">
                
                <!-- 1. Gambar Fitur Utama di Posisi Teratas (Rasio 16:9 Lebar) -->
                <div class="gn-hero-image">
                    <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true" style="display: block; width: 100%; height: 100%;">
                        <?php gesahan_post_thumbnail( 'gesahan-hero' ); ?>
                    </a>
                </div>

                <!-- 2. Detail Konten di Bawah Gambar (Detik Style Typography) -->
                <div class="gn-hero-text">
                    <!-- Label Kategori Merah All-Caps -->
                    <span class="cat-label" style="font-size: 11px; font-weight: 800; color: var(--color-accent); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">
                        <?php
                        $cats = get_the_category();
                        if ( ! empty( $cats ) ) {
                            echo esc_html( $cats[0]->name );
                        }
                        ?>
                    </span>
                    
                    <!-- Judul Besar Masif Detik.com -->
                    <h2 class="gn-hero-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>

                    <!-- PENANGGALAN RELATIF BAKU BAHASA INDONESIA -->
                    <div class="gds-card-meta" style="font-size: 11px; color: var(--color-text-muted); margin-bottom: 10px; font-weight: 500;">
                        <?php gesahan_posted_on(); ?>
                    </div>

                    <!-- Deskripsi Ringkasan Berita (Excerpt) -->
                    <p class="gn-hero-excerpt">
                        <?php echo wp_trim_words( get_the_excerpt(), 28, '...' ); ?>
                    </p>
                </div>

            </div>
            <?php
        endwhile;
        wp_reset_postdata();
        ?>

            <!-- KOLOM KANAN: TERPOPULER MODERN & SLOT IKLAN KOTAK PENYEIMBANG -->
            <div class="gn-hero-sidebar-right" style="display: flex; flex-direction: column; gap: var(--space-md); width: 100%;">
                
                <!-- Terpopuler List Widget -->
                <div class="widget-terpopuler" style="margin-bottom: 0;">
                    <div class="terpopuler-header">
                        <h3 class="terpopuler-header-title"><?php esc_html_e( 'Terpopuler', 'gentara-news' ); ?></h3>
                    </div>

                    <div class="terpopuler-list">
                        <?php
                        // Mengambil berita terpopuler menggunakan repositori teroptimasi transient cache
                        $post_repository = \Gentara\Core\Theme::get_instance()->get_container()->make( \Gentara\Repositories\PostRepository::class );
                        $popular_posts = $post_repository->get_popular_posts( 5 );

                        if ( ! empty( $popular_posts ) ) :
                            $rank = 1;
                            global $post;
                            foreach ( $popular_posts as $post ) :
                                setup_postdata( $post );
                                ?>
                                <div class="terpopuler-item">
                                    <!-- Nomor Urut Peringkat Modern -->
                                    <div class="terpopuler-rank">
                                        <?php echo sprintf( '%02d', $rank ); ?>
                                    </div>
                                    
                                    <!-- Konten Judul & Tag Terpopuler -->
                                    <div class="terpopuler-content">
                                        <span class="cat-label" style="font-size: 8px; font-weight: 800; color: var(--color-accent); text-transform: uppercase; margin-bottom: 2px;">
                                            <?php 
                                            $cats = get_the_category();
                                            if ( ! empty( $cats ) ) {
                                                echo esc_html( $cats[0]->name );
                                            }
                                            ?>
                                        </span>
                                        <h4 class="terpopuler-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h4>
                                    </div>
                                </div>
                                <?php
                                $rank++;
                            endforeach;
                            wp_reset_postdata();
                        else :
                            echo '<p style="font-size: 12px; color: var(--color-text-muted);">' . esc_html__( 'Belum ada berita populer.', 'gentara-news' ) . '</p>';
                        endif;
                        ?>
                    </div>
                </div> <!-- .widget-terpopuler -->

                <!-- SLOT IKLAN KOTAK PENYEIMBANG (Desktop Samping Terpopuler) -->
                <?php if ( function_exists( 'ges_has_ad_code' ) && ges_has_ad_code( 'hero_sidebar_square' ) ) : ?>
                    <div class="hero-sidebar-ad-box hide-on-mobile" style="width: 100%; display: flex; justify-content: center; align-items: center;">
                        <?php gesahan_display_ad_spot( 'hero_sidebar_square' ); ?>
                    </div>
                <?php endif; ?>

            </div> <!-- .gn-hero-sidebar-right -->
        
    </div> <!-- .gn-hero-grid-wrapper -->
    <?php
endif;