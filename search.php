<?php
/**
 * Search Results Page (GDS Volume 3 Bab 42 - Empty/Search State)
 */
get_header();
?>

<main id="primary-content" class="container" role="main" style="min-height: 70vh; margin-top: var(--space-md);">
    <?php if ( have_posts() ) : ?>
        <header class="search-header" style="margin-bottom: var(--space-md);">
            <h1 style="font-size: var(--font-size-lg); font-weight:var(--font-weight-bold);">
                <?php printf( esc_html__( 'Hasil Pencarian: %s', 'gesahan-news-pro' ), '<span>' . get_search_query() . '</span>' ); ?>
            </h1>
        </header>

        <div class="news-grid-main">
            <?php
            while ( have_posts() ) : the_post();
                get_template_part( 'template-parts/cards/card-standard' );
            endwhile;
            ?>
        </div>
        <?php the_posts_pagination(); ?>
    <?php else : ?>
        <!-- GDS Empty State (Volume 3 Bab 42, Volume 4 Bab 15) -->
        <section class="empty-state-container" style="text-align: center; padding: var(--space-xl) 0;">
            <div class="empty-icon" style="font-size: 4rem; margin-bottom: var(--space-sm);">🔍</div>
            <h2 style="font-size: var(--font-size-md); font-weight: var(--font-weight-bold); margin-bottom: var(--space-xs);">
                <?php esc_html_e( 'Pencarian Tidak Ditemukan', 'gesahan-news-pro' ); ?>
            </h2>
            <p style="color: var(--color-text-muted); margin-bottom: var(--space-md); max-width: 500px; margin-left:auto; margin-right:auto;">
                <?php esc_html_e( 'Kata kunci yang Anda cari tidak cocok dengan artikel apa pun di platform kami.', 'gesahan-news-pro' ); ?>
            </p>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary btn-md">
                <?php esc_html_e( 'Kembali ke Beranda', 'gesahan-news-pro' ); ?>
            </a>
        </section>
    <?php endif; ?>
</main>

<?php
get_footer();