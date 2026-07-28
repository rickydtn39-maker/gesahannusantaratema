<?php
/**
 * Template Part: Standard Flat Card (Responsive & Customizer Compliant)
 *
 * @package Gentara_News
 */

$latest_direction = get_theme_mod( 'ges_latest_layout_direction', 'horizontal' );
$card_size_global = get_theme_mod( 'ges_card_size_global', 'medium' );
$title_position   = get_theme_mod( 'ges_card_title_position', 'beside' );

// 1. JIKA MODE OVERLAY DIAKTIFKAN: Render Judul Masuk ke Dalam Gambar
if ( 'overlay' === $title_position ) :
    ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'gds-card gds-card-overlay-mode gds-card-size-' . $card_size_global ); ?> style="background: var(--card-bg) !important; border: var(--card-border) !important; padding: var(--card-padding) !important; border-radius: var(--card-border-radius) !important; transition: transform var(--duration-standard) var(--ease-out), box-shadow var(--duration-standard) var(--ease-out) !important; width: 100%;">
        
        <div class="gds-card-thumbnail" style="border-radius: var(--card-border-radius) !important; overflow: hidden; position: relative;">
            <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true" style="display: block; width: 100%; height: 100%;">
                <?php gesahan_post_thumbnail( 'gesahan-standard' ); ?>
            </a>
            
            <!-- Elemen Overlay Judul di Atas Gambar -->
            <div class="gds-card-overlay-container">
                <span class="gds-card-overlay-badge">
                    <?php 
                    $cats = get_the_category();
                    if ( ! empty( $cats ) ) { echo esc_html( $cats[0]->name ); }
                    ?>
                </span>
                <h3 class="gds-card-overlay-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h3>
                <div class="gds-card-overlay-meta">
                    <?php gesahan_posted_on(); ?>
                </div>
            </div>
        </div>

    </article>
    <?php
// 2. JIKA MODE BESIDE/DEFAULT: Render Judul Di Samping / Di Bawah Gambar (Bebas Excerpt)
else :
    $card_class = 'gds-card';
    if ( $latest_direction === 'horizontal' ) {
        $card_class .= ' gn-list-row';
    } else {
        $card_class .= ' gn-vertical-box';
    }
    $card_class .= ' gds-card-size-' . $card_size_global;
    ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class( $card_class ); ?> style="padding: 12px 0; border-bottom:1px solid var(--color-border); width: 100%; display: flex; gap: var(--space-sm); background: var(--card-bg) !important; border: var(--card-border) !important; padding: var(--card-padding) !important; border-radius: var(--card-border-radius) !important; transition: transform var(--duration-standard) var(--ease-out), box-shadow var(--duration-standard) var(--ease-out) !important;">
        
        <?php if ( $latest_direction === 'vertical' && has_post_thumbnail() ) : ?>
            <!-- THUMBNAIL ATAS -->
            <div class="gds-card-thumbnail" style="margin-bottom: var(--space-xs); overflow: hidden; width: 100%; border-radius: var(--card-border-radius) !important;">
                <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true" style="display: block; width: 100%; height: 100%;">
                    <?php the_post_thumbnail( 'gesahan-standard', array( 'loading' => 'lazy', 'style' => 'width:100%; height:100%; object-fit:cover;' ) ); ?>
                </a>
            </div>
        <?php endif; ?>

        <!-- Detail Konten Teks (Eksklusif: Tanpa Excerpt / Deskripsi) -->
        <div class="gds-card-body gn-list-content" style="padding:0; display: flex; flex-direction: column; flex: 1;">
            <span class="cat-label" style="font-size: 9px; font-weight: 800; color: var(--color-accent); text-transform: uppercase; margin-bottom: 4px; letter-spacing: 0.5px;">
                <?php
                $cats = get_the_category();
                if ( ! empty( $cats ) ) {
                    echo esc_html( $cats[0]->name );
                }
                ?>
            </span>
            
            <h3 class="gds-card-title gn-list-title" style="font-weight:var(--font-weight-bold); line-height:1.25; margin-bottom:6px;">
                <a href="<?php the_permalink(); ?>" style="color:var(--color-text-main); text-decoration:none; transition: color var(--duration-fast) var(--ease-standard);"><?php the_title(); ?></a>
            </h3>

            <div class="gds-card-meta companion-card-meta" style="font-size: 9px; color: var(--color-text-muted); margin-top: auto; font-weight: 500;">
                <?php gesahan_posted_on(); ?>
            </div>
        </div>

        <?php if ( $latest_direction === 'horizontal' && has_post_thumbnail() ) : ?>
            <!-- THUMBNAIL KANAN -->
            <div class="gds-card-thumbnail gn-list-thumb">
                <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true" style="display: block; width: 100%; height: 100%;">
                    <?php the_post_thumbnail( 'gesahan-standard', array( 'loading' => 'lazy', 'style' => 'width:100%; height:100%; object-fit:cover;' ) ); ?>
                </a>
            </div>
        <?php endif; ?>

    </article>
    <?php
endif;