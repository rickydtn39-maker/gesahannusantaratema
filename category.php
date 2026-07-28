<?php
/**
 * Category Archive Page - Enterprise Edition
 */
get_header();
?>

<main id="primary-content" class="container" role="main" style="min-height: 70vh; margin-top: var(--space-md);">
    <header class="archive-header" style="margin-bottom: var(--space-md);">
        <?php 
        if ( class_exists( '\GDS\Classes\Breadcrumb' ) ) {
            \GDS\Classes\Breadcrumb::render(); 
        }
        ?>
        <h1 style="font-size: var(--font-size-lg); font-weight:var(--font-weight-bold); margin-top: var(--space-xs);"><?php single_cat_title(); ?></h1>
        <?php the_archive_description('<p style="color:var(--color-text-muted);">', '</p>'); ?>
    </header>

    <div class="news-grid-main">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                get_template_part( 'template-parts/cards/card-standard' );
            endwhile;
        endif;
        ?>
    </div>
    
    <?php 
    if ( class_exists( '\GDS\Classes\Pagination' ) ) {
        \GDS\Classes\Pagination::render(); 
    } else {
        the_posts_pagination();
    }
    ?>
</main>

<?php
get_footer();