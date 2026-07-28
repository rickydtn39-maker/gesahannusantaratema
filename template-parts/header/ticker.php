<?php
/**
 * Komponen: Baris Headline Berjalan Otomatis (BeritaSatu Desktop Style)
 *
 * @package Gesahan_News_Pro
 */
?>
<div class="trending-bar headline-ticker-bar">
    <div class="container trending-container">
        
        <!-- Headline Solid Red Badge -->
        <span class="trending-label headline-badge">
            <?php esc_html_e( 'HEADLINE', 'gesahan-news-pro' ); ?>
        </span>

        <!-- Ticker News Items wrapper -->
        <div class="ticker-content-wrap">
            <div class="ticker-track">
                <?php
                // Mengambil 5 berita terbaru secara dinamis untuk headline berjalan
                $ticker_query = new WP_Query( array(
                    'posts_per_page'      => 5,
                    'post_status'         => 'publish',
                    'ignore_sticky_posts' => 1
                ) );

                if ( $ticker_query->have_posts() ) :
                    $ticker_items = array();
                    while ( $ticker_query->have_posts() ) : $ticker_query->the_post();
                        $ticker_items[] = array(
                            'link'  => get_permalink(),
                            'title' => get_the_title()
                        );
                    endwhile;
                    wp_reset_postdata();

                    // Render Set 1 & Set 2 (Duplikasi untuk Marquee Loop CSS 100% Seamless)
                    for ( $set = 1; $set <= 2; $set++ ) {
                        foreach ( $ticker_items as $item ) {
                            ?>
                            <span class="ticker-item">
                                <span class="ticker-bullet">&#9632;</span>
                                <a href="<?php echo esc_url( $item['link'] ); ?>"><?php echo esc_html( $item['title'] ); ?></a>
                            </span>
                            <?php
                        }
                    }
                else :
                    // Fallback jika tidak ada post, duplikasi agar animasi tidak patah
                    for ( $set = 1; $set <= 2; $set++ ) {
                        ?>
                        <span class="ticker-item">
                            <span class="ticker-bullet">&#9632;</span>
                            <a href="#"><?php esc_html_e( 'Belum ada headline terbaru hari ini.', 'gesahan-news-pro' ); ?></a>
                        </span>
                        <?php
                    }
                endif;
                ?>
            </div>
        </div>

    </div>
</div>