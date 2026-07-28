<?php
/**
 * Render Content Single News (CNN Indonesia Style)
 *
 * @package Gentara_News
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'gn-single-article' ); ?> itemscope itemtype="https://schema.org/NewsArticle">
    
    <!-- 1. Breadcrumbs Jalur Navigasi (Dinamis Namespace Asli) -->
    <?php 
    if ( get_theme_mod( 'ges_single_show_breadcrumbs', true ) ) {
        if ( class_exists( '\Gentara\Core\Breadcrumb' ) ) {
            \Gentara\Core\Breadcrumb::render(); 
        } elseif ( class_exists( '\GDS\Classes\Breadcrumb' ) ) {
            \GDS\Classes\Breadcrumb::render();
        }
    }
    ?>

    <!-- 2. Headline Judul Berita -->
    <h1 class="gn-single-title" itemprop="headline">
        <?php the_title(); ?>
    </h1>

    <!-- 3. Atribut Metadata Artikel (Dinamis) -->
    <?php if ( get_theme_mod('ges_single_show_meta_author', true) || get_theme_mod('ges_single_show_meta_date', true) ) : ?>
        <div class="gn-single-meta">
            <?php if ( get_theme_mod( 'ges_single_show_meta_author', true ) ) : ?>
                <span class="meta-author" itemprop="author">
                    <?php gesahan_posted_by(); ?>
                </span>
            <?php endif; ?>

            <?php if ( get_theme_mod('ges_single_show_meta_author', true) && get_theme_mod('ges_single_show_meta_date', true) ) : ?>
                <span style="color:#CCC; margin:0 8px;">—</span>
            <?php endif; ?>

            <?php if ( get_theme_mod( 'ges_single_show_meta_date', true ) ) : ?>
                <span class="meta-date" itemprop="datePublished" content="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
                    <?php gesahan_posted_on(); ?>
                </span>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- 4. Media Utama Gambar -->
    <div class="gn-single-featured-image" itemprop="image">
        <?php gesahan_post_thumbnail( 'gesahan-hero' ); ?>
    </div>

    <!-- 5. Isi Paragraf Narasi Berita -->
    <div class="gn-single-content" itemprop="articleBody">
        <?php
        the_content();
        
        wp_link_pages( array(
            'before' => '<div class="page-links" style="margin-top: var(--space-md); font-weight:bold;">' . esc_html__( 'Halaman:', 'gentara-news' ),
            'after'  => '</div>',
        ) );
        ?>
    </div>

    <!-- 6. Tag Terkait (Pills Tags) -->
    <?php
    $tags_list = get_the_tag_list( '', ' ' );
    if ( $tags_list ) :
        ?>
        <div class="gn-single-tags">
            <h4 class="gn-tags-title"><?php esc_html_e( 'TOPIK TERKAIT', 'gentara-news' ); ?></h4>
            <div class="gn-tags-container">
                <?php
                $post_tags = get_the_tags();
                if ( $post_tags ) {
                    foreach( $post_tags as $tag ) {
                        echo '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" class="gn-tag-pill">' . esc_html( $tag->name ) . '</a>';
                    }
                }
                ?>
            </div>
        </div>
        <?php
    endif;
    ?>
</article>