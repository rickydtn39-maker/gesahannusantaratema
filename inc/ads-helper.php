<?php
/**
 * Ad Helper System - Gesahan News Pro (Volume 5 Bab 12)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function gesahan_get_ad_code( $slot_id ) {
    $option_name = 'ges_ad_' . $slot_id;
    $ad_code = get_theme_mod( $option_name, '' );

    // Mendukung filter perluasan (GDS Volume 7 Bab 4)
    return apply_filters( 'gesahan_ads_slot', $ad_code, $slot_id );
}

function ges_has_ad_code( $slot_id ) {
    $image_url = get_theme_mod( 'ges_ad_' . $slot_id . '_image', '' );
    if ( ! empty( $image_url ) ) {
        return true;
    }
    $code = gesahan_get_ad_code( $slot_id );
    return ! empty( $code );
}

/**
 * SISTEM RENDERING CERDAS: Memproses rendering gambar responsif atau script AdSense
 */
function ges_render_ad_slot_content( $slot_id ) {
    $image_url = get_theme_mod( 'ges_ad_' . $slot_id . '_image', '' );
    $link_url  = get_theme_mod( 'ges_ad_' . $slot_id . '_link', '' );

    // Jika admin mengunggah file gambar iklan secara manual
    if ( ! empty( $image_url ) ) {
        $target_url = ! empty( $link_url ) ? esc_url( $link_url ) : '#';
        $img_html = '<a href="' . $target_url . '" target="_blank" rel="noopener" style="display: inline-block; max-width: 100%;">';
        $img_html .= '<img src="' . esc_url( $image_url ) . '" style="max-width: 100%; height: auto; display: block; margin: 0 auto; border-radius: var(--border-radius-md);" alt="' . esc_attr( $slot_id ) . ' Advertisement" />';
        $img_html .= '</a>';
        return $img_html;
    }

    // Jika gambar kosong, fallback kembali ke parsing code HTML / AdSense Script
    return ges_sanitize_ad_code( gesahan_get_ad_code( $slot_id ) );
}

function gesahan_display_ad_spot( $slot_id ) {
    // Penanganan khusus untuk Iklan Melayang Mobile Bottom Anchor
    if ( $slot_id === 'interstitial_anchor' ) {
        ges_render_mobile_anchor_ad_markup();
        return;
    }

    if ( ! ges_has_ad_code( $slot_id ) ) {
        return;
    }

    $ad_content = ges_render_ad_slot_content( $slot_id );

    // Hanya tampilkan wrapper pembungkus jika kode/gambar iklan tersedia
    echo '<div class="ad-container ad-slot-' . esc_attr( $slot_id ) . '" aria-hidden="true" style="margin: var(--space-sm) auto; text-align: center; max-width: 100%; overflow: hidden;">';
    echo '<span class="ad-label" style="font-size:10px; color: var(--color-text-muted); text-transform:uppercase; display:block; margin-bottom: 4px;">' . esc_html__( 'Advertisement', 'gesahan-news-pro' ) . '</span>';
    echo $ad_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo '</div>';
}

/**
 * AUTOMATIC INJECTOR ENGINE: Menyisipkan Iklan Di Tengah Paragraf Artikel Secara Cerdas
 */
function ges_inject_mid_article_ad_filter( $content ) {
    if ( ! is_single() || ! is_main_query() ) {
        return $content;
    }

    if ( ! ges_has_ad_code( 'mid_article' ) ) {
        return $content;
    }

    $ad_content = ges_render_ad_slot_content( 'mid_article' );

    // Bangun HTML Wrapper Unit Iklan Tengah Paragraf
    $ad_html = '<div class="ad-container mid-article-ad-wrapper" aria-hidden="true" style="margin: var(--space-md) auto; text-align: center; max-width: 100%; overflow: hidden;">';
    $ad_html .= '<span class="ad-label" style="font-size:10px; color: var(--color-text-muted); text-transform:uppercase; display:block; margin-bottom: 4px;">' . esc_html__( 'Advertisement', 'gesahan-news-pro' ) . '</span>';
    $ad_html .= $ad_content;
    $ad_html .= '</div>';

    // Sisipkan tepat di bawah paragraf ke-4
    $paragraphs = explode( '</p>', $content );
    if ( count( $paragraphs ) > 4 ) {
        $paragraphs[3] .= '</p>' . $ad_html;
        $content = implode( '</p>', $paragraphs );
    } else {
        // Jika tulisan terlalu pendek, sisipkan di paling bawah tulisan
        $content .= $ad_html;
    }

    return $content;
}
add_filter( 'the_content', 'ges_inject_mid_article_ad_filter', 12 );

/**
 * RENDERER: Banner Melayang Mobile Bottom Anchor Dengan Proteksi CSS Flat
 */
function ges_render_mobile_anchor_ad_markup() {
    if ( ! ges_has_ad_code( 'interstitial_anchor' ) ) {
        return;
    }
    $ad_content = ges_render_ad_slot_content( 'interstitial_anchor' );
    ?>
    <div id="mobile-anchor-ad-wrap" style="position: fixed; bottom: 0; left: 0; right: 0; z-index: 99999; background: rgba(255,255,255,0.95); border-top: 1px solid #ddd; text-align: center; box-shadow: 0 -3px 10px rgba(0,0,0,0.1); width: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 4px 0 0 0;">
        <!-- Tombol Tutup Presisi -->
        <button onclick="document.getElementById('mobile-anchor-ad-wrap').style.display='none';" style="position: absolute; top: -24px; right: 8px; background: #000; color: #FFF; border: none; font-size: 11px; font-weight: bold; cursor: pointer; padding: 4px 10px; height: 24px; text-transform: uppercase; font-family: sans-serif; letter-spacing: 0.5px;">
            <?php esc_html_e( 'Tutup', 'gesahan-news-pro' ); ?> &times;
        </button>
        <span style="font-size:8px; color:#aaa; text-transform:uppercase; display:block; font-family:sans-serif; margin-bottom: 2px;">ADVERTISEMENT</span>
        <div style="display:flex; justify-content:center; width:100%; max-height:90px; overflow:hidden;">
            <?php echo $ad_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        </div>
    </div>
    <?php
}