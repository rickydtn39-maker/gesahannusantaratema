<?php
/**
 * Template Part: Desktop Modular Category Block Layout
 *
 * @package Gentara_News
 */

$block_index = isset( $args['block_index'] ) ? absint( $args['block_index'] ) : rand(1, 999);
$cat_id      = isset( $args['cat_id'] ) ? absint( $args['cat_id'] ) : 0;
$limit       = isset( $args['limit'] ) ? absint( $args['limit'] ) : 4;
$card_style  = isset( $args['style'] ) ? sanitize_text_field( $args['style'] ) : 'standard';

// Ambil kustomisasi manual dari database
$custom_title = get_theme_mod( 'ges_home_cat_block_' . $block_index . '_title', '' );
$card_size    = (int) get_theme_mod( 'ges_home_cat_block_' . $block_index . '_card_size', 280 );
$title_size   = (int) get_theme_mod( 'ges_home_cat_block_' . $block_index . '_title_size', 16 );

if ( ! empty( $custom_title ) ) {
    $cat_name = $custom_title;
} elseif ( $cat_id > 0 ) {
    $cat_name = get_cat_name( $cat_id );
} else {
    $cat_name = esc_html__( 'Berita Terkini', 'gentara-news' );
}

$cat_url = $cat_id > 0 ? get_category_link( $cat_id ) : '#';

// Mengambil postingan menggunakan Query Manager (PostRepository) untuk performa database maksimal
$post_repository = \Gentara\Core\Theme::get_instance()->get_container()->make( \Gentara\Repositories\PostRepository::class );
$posts = $post_repository->get_category_posts( $cat_id, $limit );

if ( ! empty( $posts ) ) :
    ?>
    <!-- Injeksi Scoped Style untuk Mengatur Ukuran Card & Font Secara Manual per Blok -->
    <style>
        .cat-block-id-<?php echo $block_index; ?> .gds-card-title,
        .cat-block-id-<?php echo $block_index; ?> .gn-list-title,
        .cat-block-id-<?php echo $block_index; ?> .gn-sub-card-title,
        .cat-block-id-<?php echo $block_index; ?> .gds-card-overlay-title {
            font-size: <?php echo $title_size; ?>px !important;
        }
        .cat-block-id-<?php echo $block_index; ?> .category-grid-wrap {
            display: grid !important;
            grid-template-columns: repeat(auto-fill, minmax(<?php echo $card_size; ?>px, 1fr)) !important;
            gap: var(--space-md) !important;
            width: 100% !important;
        }
    </style>

    <section class="category-block-section cat-block-id-<?php echo $block_index; ?>" style="margin-top: 10px !important; border-top: none !important; padding-top: var(--space-sm) !important; width: 100%;">
        
        <!-- Header Kategori dengan Garis Aksentuasi Vertikal Merah (Tebal & Tinggi Melebihi Font) -->
        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 6px; margin-bottom: var(--space-sm);">
            
            <div style="display: inline-flex; align-items: center; gap: 0;">
                <h3 style="font-family: var(--font-sans); font-size: 18px; font-weight: 900; text-transform: uppercase; margin: 0; letter-spacing: 0.5px; color: var(--color-text-main); border-left: 6px solid var(--color-accent); padding-left: 14px; line-height: 1.1; min-height: 24px; display: flex; align-items: center;">
                    <?php echo esc_html( $cat_name ); ?>
                </h3>
            </div>

            <a href="<?php echo esc_url( $cat_url ); ?>" style="color: var(--color-accent); font-size: 11px; text-decoration: none; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px; transition: color var(--duration-fast) var(--ease-standard);">
                <?php esc_html_e( 'Lihat Semua', 'gentara-news' ); ?> &rsaquo;
            </a>
        </div>
        
        <!-- Grid Rendering Modular Terbuka -->
        <div class="category-grid-wrap">
            <?php
            global $post;
            foreach ( $posts as $post ) :
                setup_postdata( $post );
                
                if ( $card_style === 'list' ) {
                    get_template_part( 'template-parts/cards/card-list' );
                } elseif ( $card_style === 'featured' ) {
                    get_template_part( 'template-parts/cards/card-featured' );
                } elseif ( $card_style === 'compact' ) {
                    get_template_part( 'template-parts/cards/card-compact' );
                } else {
                    get_template_part( 'template-parts/cards/card-standard' );
                }
            endforeach;
            wp_reset_postdata();
            ?>
        </div>

    </section>
    <?php
endif;