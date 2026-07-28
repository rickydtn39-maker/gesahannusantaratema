<?php
/**
 * Render Content Single News (CNN Indonesia Style - Premium Editorial Edition)
 *
 * @package Gentara_News
 */

// Naikkan pelacakan jumlah pembaca secara otomatis saat artikel dimuat
ges_set_post_views( get_the_ID() );

// Hitung estimasi waktu baca
$reading_time = ges_calculate_reading_time( get_the_content() );
?>

<!-- 1. READING PROGRESS BAR VIEWPORT -->
<div class="reading-progress-container">
    <div id="reading-progress-bar"></div>
</div>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'gn-single-article' ); ?> itemscope itemtype="https://schema.org/NewsArticle">
    
    <!-- 2. BREADCRUMB JALUR NAVIGASI -->
    <?php 
    if ( get_theme_mod( 'ges_single_show_breadcrumbs', true ) ) {
        if ( class_exists( '\Gentara\Core\Breadcrumb' ) ) {
            \Gentara\Core\Breadcrumb::render(); 
        } elseif ( class_exists( '\GDS\Classes\Breadcrumb' ) ) {
            \GDS\Classes\Breadcrumb::render();
        }
    }
    ?>

    <!-- 3. BADGE KATEGORI INDUK UTAMA -->
    <?php
    $categories = get_the_category();
    if ( ! empty( $categories ) ) :
        ?>
        <a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>" class="single-category-badge">
            <?php echo esc_html( $categories[0]->name ); ?>
        </a>
    <?php endif; ?>

    <!-- 4. HEADLINE JUDUL UTAMA BERITA -->
    <h1 class="gn-single-title" itemprop="headline">
        <?php the_title(); ?>
    </h1>

    <!-- 5. BLOK META PENULIS DENGAN AVATAR BULAT -->
    <div class="gn-single-author-wrapper">
        <div class="gn-author-avatar">
            <?php echo get_avatar( get_the_author_meta( 'ID' ), 44 ); ?>
        </div>
        <div class="gn-meta-detail-author">
            <span class="gn-author-name">
                Oleh <strong><?php the_author(); ?></strong>
            </span>
            <span class="gn-publish-date-bar">
                <?php gesahan_posted_on(); ?>
                <?php 
                // Cek apakah postingan pernah diperbarui
                $u_time = get_the_modified_time( 'U' );
                $p_time = get_the_time( 'U' );
                if ( $u_time >= $p_time + 86400 ) { // Diperbarui minimal selisih 1 hari
                    $relative_modified = human_time_diff( $u_time, current_time( 'timestamp' ) ) . ' yang lalu';
                    echo ' • <span class="modified-time-label">Update ' . esc_html( $relative_modified ) . '</span>';
                }
                ?>
            </span>
        </div>
    </div>

    <!-- 6. METRICS BAR: VIEWS, KOMENTAR, & ESTIMASI BACA -->
    <div class="gn-metrics-meta-bar">
        <div class="gn-metric-item">
            <span class="metric-icon">👁</span>
            <span><?php echo esc_html( ges_get_post_views( get_the_ID() ) ); ?> Views</span>
        </div>
        <div class="gn-metric-item">
            <span class="metric-icon">💬</span>
            <span><?php echo esc_html( get_comments_number() ); ?> Komentar</span>
        </div>
        <div class="gn-metric-item">
            <span class="metric-icon">⏱</span>
            <span><?php echo esc_html( $reading_time ); ?> Menit Baca</span>
        </div>
    </div>

    <!-- 7. MEDIA GAMBAR UTAMA DENGAN CAPTION & KREDIT FOTOGRAFER -->
    <div class="gn-single-featured-image" itemprop="image">
        <?php 
        $thumbnail_id = get_post_thumbnail_id();
        $alt_text = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
        if ( empty( $alt_text ) ) {
            $alt_text = get_the_title();
        }
        
        if ( has_post_thumbnail() ) {
            the_post_thumbnail( 'gesahan-hero', array( 'alt' => $alt_text, 'loading' => 'eager' ) );
        } else {
            gesahan_post_thumbnail( 'gesahan-hero' );
        }
        ?>

        <!-- CAPTION & DOKUMEN HUMAS / KREDIT FOTO -->
        <div class="gn-image-caption-container">
            <p class="gn-image-caption-text">
                <?php 
                $caption = get_the_post_thumbnail_caption();
                if ( ! empty( $caption ) ) {
                    echo esc_html( $caption );
                } else {
                    esc_html_e( 'Foto Dokumentasi Editorial Portal Berita Nasional', 'gentara-news' );
                }
                ?>
                <span class="gn-image-credit-text">
                     / Foto: <?php echo esc_html( get_bloginfo( 'name' ) ); ?> / Dok. Humas
                </span>
            </p>
        </div>
    </div>

    <!-- 8. ISI NASKAH BERITA -->
    <div class="gn-single-content" itemprop="articleBody">
        
        <!-- INJEKSI MANUAL QUICK INFO FACT BOX (Fakta Singkat) -->
        <aside class="gn-info-box" aria-label="<?php esc_attr_e( 'Fakta Singkat', 'gentara-news' ); ?>">
            <h4 class="gn-info-box-title"><?php esc_html_e( 'FAKTA SINGKAT', 'gentara-news' ); ?></h4>
            <div class="gn-info-box-row">
                <div class="gn-info-box-label"><?php esc_html_e( 'Fokus Informasi', 'gentara-news' ); ?></div>
                <div class="gn-info-box-value"><?php echo esc_html( $categories[0]->name ); ?></div>
            </div>
            <div class="gn-info-box-row">
                <div class="gn-info-box-label"><?php esc_html_e( 'Estimasi Efisiensi', 'gentara-news' ); ?></div>
                <div class="gn-info-box-value"><?php esc_html_e( 'Skala Nasional', 'gentara-news' ); ?></div>
            </div>
            <div class="gn-info-box-row">
                <div class="gn-info-box-label"><?php esc_html_e( 'Sektor Pelaksana', 'gentara-news' ); ?></div>
                <div class="gn-info-box-value"><?php esc_html_e( 'Pemerintah Pusat', 'gentara-news' ); ?></div>
            </div>
        </aside>

        <?php
        the_content();
        
        wp_link_pages( array(
            'before' => '<div class="page-links" style="margin-top: var(--space-md); font-weight:bold;">' . esc_html__( 'Halaman:', 'gentara-news' ),
            'after'  => '</div>',
        ) );
        ?>
    </div>

    <!-- 9. HASHTAG TOPIK POPULER (Menjadi Badge Capsule) -->
    <?php
    $post_tags = get_the_tags();
    if ( $post_tags ) :
        ?>
        <div class="gn-single-tags">
            <h4 class="gn-tags-title"><?php esc_html_e( 'TOPIK TERKAIT', 'gentara-news' ); ?></h4>
            <div class="gn-tags-container">
                <?php
                foreach( $post_tags as $tag ) {
                    echo '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" class="gn-tag-hashtag">' . esc_html( $tag->name ) . '</a>';
                }
                ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- 10. ENRICHED FOOTER ARTIKEL UTILITY TOOLBAR (Tanpa border garis pembatas) -->
    <div class="gn-article-footer-toolbar">
        <div class="gn-footer-utility-links">
            <button id="utility-bookmark" class="gn-utility-btn">Bookmark</button>
            <button onclick="window.print();" class="gn-utility-btn">Cetak</button>
            <button id="utility-report-error" class="gn-utility-btn">Laporkan Kesalahan</button>
        </div>
    </div>

</article>