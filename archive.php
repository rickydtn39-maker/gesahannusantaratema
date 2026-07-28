<?php
/**
 * Global Archive Controller - Enterprise Edition
 * Menggabungkan seluruh peran fungsional archive.php, author.php, dan tag.php secara dinamis dan aksesibel.
 *
 * @package Gentara_News
 */

get_header();
?>

<main id="primary-content" class="container" role="main" style="min-height: 70vh; margin-top: var(--space-md);">
    
    <!-- Header Arsip Dinamis -->
    <header class="archive-header" style="margin-bottom: var(--space-md); border-bottom: 1px solid var(--color-border); padding-bottom: var(--space-sm);">
        <?php 
        // Menggunakan Breadcrumb Namespace Asli dengan fallback aman
        if ( class_exists( '\Gentara\Core\Breadcrumb' ) ) {
            \Gentara\Core\Breadcrumb::render(); 
        } elseif ( class_exists( '\GDS\Classes\Breadcrumb' ) ) {
            \GDS\Classes\Breadcrumb::render();
        }
        ?>
        
        <h1 style="font-size: var(--font-size-lg); font-weight: var(--font-weight-bold); margin-top: var(--space-xs); line-height: 1.2;">
            <?php
            if ( is_category() ) {
                single_cat_title();
            } elseif ( is_tag() ) {
                printf( esc_html__( 'Tag: %s', 'gentara-news' ), single_tag_title( '', false ) );
            } elseif ( is_author() ) {
                printf( esc_html__( 'Arsip Penulis: %s', 'gentara-news' ), get_the_author() );
            } elseif ( is_day() ) {
                printf( esc_html__( 'Arsip Harian: %s', 'gentara-news' ), get_the_date() );
            } elseif ( is_month() ) {
                printf( esc_html__( 'Arsip Bulanan: %s', 'gentara-news' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'gentara-news' ) ) );
            } elseif ( is_year() ) {
                printf( esc_html__( 'Arsip Tahunan: %s', 'gentara-news' ), get_the_date( _x( 'Y', 'yearly archives date format', 'gentara-news' ) ) );
            } else {
                the_archive_title();
            }
            ?>
        </h1>

        <!-- Deskripsi Arsip (Mendukung deskripsi bio jika arsip Penulis) -->
        <div class="archive-description" style="color: var(--color-text-muted); font-size: var(--font-size-sm); margin-top: var(--space-xs); line-height: var(--line-height-normal);">
            <?php
            if ( is_author() ) {
                echo wp_kses_post( get_the_author_meta( 'description' ) );
            } else {
                the_archive_description();
            }
            ?>
        </div>
    </header>

    <!-- Daftar Postingan Grid -->
    <?php if ( have_posts() ) : ?>
        <div class="news-grid-main">
            <?php
            while ( have_posts() ) : the_post();
                get_template_part( 'template-parts/cards/card-standard' );
            endwhile;
            ?>
        </div>
        
        <!-- Paginasi Bernomor Berstandar Aksesibilitas -->
        <?php 
        if ( class_exists( '\Gentara\Core\Pagination' ) ) {
            \Gentara\Core\Pagination::render(); 
        } elseif ( class_exists( '\GDS\Classes\Pagination' ) ) {
            \GDS\Classes\Pagination::render();
        } else {
            the_posts_pagination( array(
                'mid_size'  => 2,
                'prev_text' => esc_html__( 'Sebelumnya', 'gentara-news' ),
                'next_text' => esc_html__( 'Berikutnya', 'gentara-news' ),
            ) );
        }
        ?>
    <?php else : ?>
        <p style="color: var(--color-text-muted); text-align: center; padding: var(--space-lg) 0;">
            <?php esc_html_e( 'Belum ada berita dalam arsip ini.', 'gentara-news' ); ?>
        </p>
    <?php endif; ?>

</main>

<?php
get_footer();