<?php
/**
 * Kumpulan tag template visual berstandar aksesibilitas tinggi (GDS Volume 5)
 * Diperkaya dengan utilitas pencatatan view artikel, estimasi baca, dan metadata gambar.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * HELPER: Menerjemahkan nama hari dan bulan Inggris ke Bahasa Indonesia secara absolut
 */
function ges_translate_to_indonesian( $date_string ) {
    $english = array(
        'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday',
        'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat',
        'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December',
        'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
    );
    
    $indonesian = array(
        'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu',
        'Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab',
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',
        'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
    );

    return str_replace( $english, $indonesian, $date_string );
}

if ( ! function_exists( 'gesahan_posted_on' ) ) :
    /**
     * MENGUBAH FUNGSI UTAMA PENANGGALAN: Menampilkan format waktu relatif secara global (Time Ago)
     */
    function gesahan_posted_on() {
        $post_time = get_the_time( 'U' );
        $current_time = current_time( 'timestamp' );
        $diff = (int) abs( $current_time - $post_time );

        $time_string = '';

        if ( $diff < MINUTE_IN_SECONDS ) {
            $time_string = esc_html__( 'Baru saja', 'gesahan-news-pro' );
        } elseif ( $diff < HOUR_IN_SECONDS ) {
            $mins = round( $diff / MINUTE_IN_SECONDS );
            $time_string = sprintf( esc_html__( '%s menit yang lalu', 'gesahan-news-pro' ), $mins );
        } elseif ( $diff < DAY_IN_SECONDS ) {
            $hours = round( $diff / HOUR_IN_SECONDS );
            $time_string = sprintf( esc_html__( '%s jam yang lalu', 'gesahan-news-pro' ), $hours );
        } elseif ( $diff < WEEK_IN_SECONDS ) {
            $days = round( $diff / DAY_IN_SECONDS );
            $time_string = sprintf( esc_html__( '%s hari yang lalu', 'gesahan-news-pro' ), $days );
        } elseif ( $diff < MONTH_IN_SECONDS ) {
            $weeks = round( $diff / WEEK_IN_SECONDS );
            $time_string = sprintf( esc_html__( '%s minggu yang lalu', 'gesahan-news-pro' ), $weeks );
        } elseif ( $diff < YEAR_IN_SECONDS ) {
            $months = round( $diff / MONTH_IN_SECONDS );
            $time_string = sprintf( esc_html__( '%s bulan yang lalu', 'gesahan-news-pro' ), $months );
        } else {
            $years = round( $diff / YEAR_IN_SECONDS );
            $time_string = sprintf( esc_html__( '%s tahun yang lalu', 'gesahan-news-pro' ), $years );
        }

        $time_html = sprintf(
            '<time class="entry-date published updated" datetime="%1$s">%2$s</time>',
            esc_attr( get_the_date( DATE_W3C ) ),
            esc_html( $time_string )
        );

        echo '<span class="posted-on" style="display:inline-flex; align-items:center;">' . $time_html . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
endif;

/**
 * UTILITY: Mengonversi waktu postingan menjadi format waktu relatif Bahasa Indonesia (Time Ago)
 */
if ( ! function_exists( 'ges_posted_on_relative' ) ) :
    function ges_posted_on_relative() {
        gesahan_posted_on();
    }
endif;

if ( ! function_exists( 'gesahan_posted_by' ) ) :
    function gesahan_posted_by() {
        $byline = sprintf(
            esc_html_x( '%s', 'post author', 'gesahan-news-pro' ),
            '<span class="author vcard" itemprop="name" style="color:var(--color-accent); font-weight:800; text-transform:uppercase;">' . esc_html( get_the_author() ) . '</span>'
        );

        echo '<span class="byline" itemprop="author" itemscope itemtype="https://schema.org/Person"> ' . $byline . '</span>'; 
    }
endif;

/**
 * SMART FEATURE: GN Auto Editorial Placeholder Engine
 */
if ( ! function_exists( 'gesahan_post_thumbnail' ) ) :
    function gesahan_post_thumbnail( $size = 'gesahan-standard', $class = '' ) {
        if ( has_post_thumbnail() ) {
            the_post_thumbnail( $size, array( 'class' => $class, 'loading' => 'lazy' ) );
        } else {
            $width = 640;
            $height = 360;
            if ( $size === 'gesahan-hero' ) {
                $width = 1200; $height = 675;
            } elseif ( $size === 'gesahan-compact' ) {
                $width = 80; $height = 80;
            }
            
            echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 ' . $width . ' ' . $height . '" class="' . esc_attr( $class ) . '" style="width:100%; height:100%; display:block; background: linear-gradient(135deg, #161e2e 0%, #0b0f19 100%);">';
            echo '<rect width="100%" height="100%" fill="none"/>';
            echo '<text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-family="sans-serif" font-weight="900" font-size="' . ( $size === 'gesahan-compact' ? '12' : '24' ) . '" fill="#374151" letter-spacing="2">GN NEWS</text>';
            echo '</svg>';
        }
    }
endif;

/**
 * AUTOMATIC EDITORIAL FEATURE: Injeksi Kotak Pilihan Redaksi di Tengah Artikel secara Aman
 */
function gesahan_inject_pilihan_redaksi( $content ) {
    if ( ! is_single() || ! is_main_query() ) {
        return $content;
    }

    if ( ! get_theme_mod( 'ges_single_show_pilihan_redaksi', true ) ) {
        return $content;
    }

    $categories = get_the_category();
    if ( empty( $categories ) ) {
        return $content;
    }

    $related = new WP_Query( array(
        'cat'                 => $categories[0]->term_id,
        'post__not_in'        => array( get_the_ID() ),
        'posts_per_page'      => 1,
        'orderby'             => 'rand',
        'ignore_sticky_posts' => 1,
    ) );

    if ( ! $related->have_posts() ) {
        return $content;
    }

    $related_post = $related->posts[0];
    
    $callout_html = '<div class="pilihan-redaksi-callout" aria-label="' . esc_attr__( 'Pilihan Redaksi', 'gesahan-news-pro' ) . '">';
    $callout_html .= '<span class="pilihan-redaksi-label">' . esc_html__( 'Pilihan Redaksi', 'gesahan-news-pro' ) . '</span>';
    $callout_html .= '<h4 class="pilihan-redaksi-title"><a href="' . esc_url( get_permalink( $related_post->ID ) ) . '">' . esc_html( get_the_title( $related_post->ID ) ) . '</a></h4>';
    $callout_html .= '</div>';

    $paragraphs = explode( '</p>', $content );
    if ( count( $paragraphs ) > 2 ) {
        $paragraphs[1] .= '</p>' . $callout_html;
        $content = implode( '</p>', $paragraphs );
    } else {
        $content .= $callout_html;
    }

    return $content;
}
add_filter( 'the_content', 'gesahan_inject_pilihan_redaksi', 10 );

/**
 * AUTOMATIC EDITORIAL FEATURE: Tambahkan Kredit/Inisial Editor di Akhir Artikel
 */
function gesahan_inject_author_initials( $content ) {
    if ( ! is_single() || ! is_main_query() ) {
        return $content;
    }

    if ( ! get_theme_mod( 'ges_single_show_author_initials', true ) ) {
        return $content;
    }

    $author_name = get_the_author_meta('display_name');
    $words = explode(' ', $author_name);
    $initials = '';
    foreach ($words as $w) {
        $initials .= strtolower(substr($w, 0, 1));
    }
    
    if (empty($initials)) {
        $initials = 'gn';
    }

    $credit_html = '<p class="author-credit-initials">(' . esc_html( $initials ) . '/nva)</p>';
    $content .= $credit_html;

    return $content;
}
add_filter( 'the_content', 'gesahan_inject_author_initials', 15 );

/**
 * UTILITY: Pelacak Jumlah Pembaca (Post Views Tracker)
 */
function ges_set_post_views( $post_id ) {
    $count_key = '_ges_post_views_count';
    $count = get_post_meta( $post_id, $count_key, true );
    if ( '' === $count ) {
        $count = 0;
        delete_post_meta( $post_id, $count_key );
        add_post_meta( $post_id, $count_key, '0' );
    } else {
        $count++;
        update_post_meta( $post_id, $count_key, $count );
    }
}

function ges_get_post_views( $post_id ) {
    $count_key = '_ges_post_views_count';
    $count = get_post_meta( $post_id, $count_key, true );
    if ( '' === $count ) {
        delete_post_meta( $post_id, $count_key );
        add_post_meta( $post_id, $count_key, '0' );
        return '0';
    }
    return number_format_i18n( $count );
}

/**
 * UTILITY: Estimasi Waktu Membaca Artikel
 */
function ges_calculate_reading_time( $content ) {
    $word_count = str_word_count( strip_tags( $content ) );
    $reading_time = ceil( $word_count / 200 ); // Estimasi 200 kata per menit
    return $reading_time > 0 ? $reading_time : 1;
}