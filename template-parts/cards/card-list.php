<?php
/**
 * Template Part: GN Style Row List Card (Customizer Framework Compliant)
 *
 * @package Gentara_News
 */

$card_size_global = get_theme_mod( 'ges_card_size_global', 'medium' );
$title_position   = get_theme_mod( 'ges_card_title_position', 'beside' );

// 1. JIKA MODE OVERLAY DIAKTIFKAN: Render Judul Masuk ke Dalam Gambar
if ( 'overlay' === $title_position ) :
    ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'gds-card gds-card-overlay-mode gds-card-size-' . $card_size_global ); ?> style="background: var(--card-bg) !important; border: var(--card-border) !important; padding: var(--card-padding) !important; border-radius: var(--card-border-radius) !important; transition: transform var(--duration-standard) var(--ease-out), box-shadow var(--duration-standard) var(--ease-out) !important;">
        
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
// 2. JIKA MODE BESIDE/DEFAULT: Render Judul di Samping Gambar (Spesifikasi Bebas Excerpt)
else :
    ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'gn-list-row gds-card-size-' . $card_size_global ); ?> style="background: var(--card-bg) !important; border: var(--card-border) !important; padding: var(--card-padding) !important; border-radius: var(--card-border-radius) !important; transition: transform var(--duration-standard) var(--ease-out), box-shadow var(--duration-standard) var(--ease-out) !important;">
        
        <!-- Thumbnail Gambar dengan Lebar Dinamis Customizer -->
        <div class="gn-list-thumb">
            <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true" style="display: block; width: 100%; height: 100%;">
                <?php gesahan_post_thumbnail( 'gesahan-standard' ); ?>
            </a>
        </div>

        <!-- Detail Konten Teks (Eksklusif: Tanpa Excerpt / Deskripsi) -->
        <div class="gn-list-content">
            <span class="cat-label" style="font-size: 9px; font-weight: 800; color: var(--color-accent); text-transform: uppercase; margin-bottom: 4px; letter-spacing: 0.5px;">
                <?php 
                $cats = get_the_category();
                if ( ! empty( $cats ) ) {
                    echo esc_html( $cats[0]->name );
                }
                ?>
            </span>
            
            <h3 class="gn-list-title" style="margin: 0 0 6px 0;">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>

            <div class="gds-card-meta companion-card-meta" style="font-size: 9px; color: var(--color-text-muted); margin-top: auto; font-weight: 500;">
                <?php gesahan_posted_on(); ?>
            </div>
        </div>
    </article>
    <?php
endif;