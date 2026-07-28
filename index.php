<?php
/**
 * Index Default Template Fallback
 */
get_header();
?>

<main id="primary-content" class="container" role="main" style="min-height: 70vh; margin-top: var(--space-md);">
    <?php if ( have_posts() ) : ?>
        <div class="news-grid-main">
            <?php
            while ( have_posts() ) : the_post();
                get_template_part( 'template-parts/cards/card-standard' );
            endwhile;
            ?>
        </div>
        <?php the_posts_pagination(); ?>
    <?php else : ?>
        <p><?php esc_html_e( 'Belum ada konten tersedia.', 'gesahan-news-pro' ); ?></p>
    <?php endif; ?>
</main>

<?php
get_footer();