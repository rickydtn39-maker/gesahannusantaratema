<?php
/**
 * Standard Page Template
 */
get_header();
?>

<main id="primary-content" class="container" role="main" style="min-height: 70vh; margin-top: var(--space-lg);">
    <?php
    while ( have_posts() ) : the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="page-header" style="margin-bottom: var(--space-md);">
                <h1 style="font-size: var(--font-size-xl); font-weight:var(--font-weight-bold);"><?php the_title(); ?></h1>
            </header>
            <div class="entry-content" style="line-height: var(--line-height-normal);">
                <?php the_content(); ?>
            </div>
        </article>
        <?php
    endwhile;
    ?>
</main>

<?php
get_footer();