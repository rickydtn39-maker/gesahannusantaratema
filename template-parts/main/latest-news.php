<?php
/**
 * Template Part: Desktop Latest News Content Stream (100% Dinamis)
 *
 * @package Gentara_News
 */

// Menentukan batas jumlah berita terbaru yang tampil
$latest_limit = get_theme_mod( 'ges_home_latest_limit', 6 );
$latest_direction = get_theme_mod( 'ges_latest_layout_direction', 'horizontal' );

$exclude_ids = ! empty( $GLOBALS['gds_hero_post_ids'] ) ? $GLOBALS['gds_hero_post_ids'] : array();

// Mengambil postingan menggunakan Repositori Cerdas Transient
$post_repository = \Gentara\Core\Theme::get_instance()->get_container()->make( \Gentara\Repositories\PostRepository::class );
$latest_posts = $post_repository->get_latest_posts( $latest_limit, $exclude_ids );

if ( ! empty( $latest_posts ) ) :
    // Dapatkan judul kustom dari dasbor secara dinamis
    $latest_title = get_theme_mod( 'ges_home_latest_title', 'Berita Terbaru' );
    ?>
    <div class="latest-news-section" style="width: 100%;">
        
        <!-- Header Judul Seksi (Dinamis tanpa Garis Bawah Pembatas) -->
        <div class="section-title-container" style="border-bottom: none; padding-bottom: 6px; margin-bottom: 15px;">
            <h3 style="font-family: var(--font-sans); font-size: 14px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px; color: var(--color-text-main); margin: 0;">
                <?php echo esc_html( $latest_title ); ?>
            </h3>
        </div>

        <!-- Render dinamis: Grid Multi-Kolom jika Mode Vertikal terpilih -->
        <?php if ( $latest_direction === 'vertical' ) : ?>
            <div class="latest-stream-container" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
        <?php else : ?>
            <div class="latest-stream-container" style="display: flex; flex-direction: column; gap: 10px;">
        <?php endif; ?>
            
            <?php
            global $post;
            foreach ( $latest_posts as $post ) :
                setup_postdata( $post );
                get_template_part( 'template-parts/cards/card-standard' );
            endforeach;
            wp_reset_postdata();
            ?>
        </div>

        <!-- Tombol "Lihat Semua Berita" -->
        <?php 
        $all_latest_url = get_theme_mod( 'ges_home_latest_all_url', '' );
        
        if ( empty( $all_latest_url ) ) {
            $posts_page_id = get_option( 'page_for_posts' );
            $all_latest_url = $posts_page_id ? get_permalink( $posts_page_id ) : home_url( '/' );
        }
        ?>
        <div class="latest-more-button-container" style="margin-top: 20px; text-align: center;">
            <a href="<?php echo esc_url( $all_latest_url ); ?>" class="btn btn-outline btn-md" style="font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px;">
                <?php esc_html_e( 'Lihat Semua Berita', 'gentara-news' ); ?> &rsaquo;
            </a>
        </div>

    </div>
    <?php
endif;