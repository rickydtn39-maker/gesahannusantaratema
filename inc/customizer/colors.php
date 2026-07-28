<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

function gesahan_customize_colors( $wp_customize ) {
    $wp_customize->add_section( 'ges_colors_section', array(
        'title'    => esc_html__( 'Skema & Gaya Visual', 'gesahan-news-pro' ),
        'panel'    => 'gesahan_theme_options',
        'priority' => 10,
    ));

    // 1. Selector Multi-Preset Warna Industri Media
    $wp_customize->add_setting( 'ges_color_preset', array(
        'default'           => 'cnn_red',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control( 'ges_color_preset_ctrl', array(
        'label'       => esc_html__( 'Pilih Preset Warna Brand', 'gesahan-news-pro' ),
        'description' => esc_html__( 'Pilih preset warna khas portal media besar atau pilih "Kustom" untuk menentukan warna sendiri.', 'gesahan-news-pro' ),
        'section'     => 'ges_colors_section',
        'settings'    => 'ges_color_preset',
        'type'        => 'select',
        'choices'     => array(
            'cnn_red'       => esc_html__( 'CNN Red (Merah Berani)', 'gesahan-news-pro' ),
            'detik_blue'    => esc_html__( 'Detik Blue (Biru Kecepatan)', 'gesahan-news-pro' ),
            'kompas_blue'   => esc_html__( 'Kompas Dark Blue (Biru Wibawa)', 'gesahan-news-pro' ),
            'enviro_green'  => esc_html__( 'Environmental Green (Hijau Komunitas)', 'gesahan-news-pro' ),
            'merdeka_orange'=> esc_html__( 'Merdeka Orange (Oranye Modern)', 'gesahan-news-pro' ),
            'custom'        => esc_html__( '🎨 Mode Kustom (Pilih di bawah)', 'gesahan-news-pro' ),
        ),
    ));

    // 2. Color Picker (Hanya Aktif Jika Memilih Preset 'custom')
    $wp_customize->add_setting( 'ges_accent_color', array(
        'default'           => '#CC0000',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control( new \WP_Customize_Color_Control( $wp_customize, 'ges_accent_color_ctrl', array(
        'label'       => esc_html__( 'Warna Aksen Kustom', 'gesahan-news-pro' ),
        'description' => esc_html__( 'Berlaku hanya jika Anda memilih opsi "Mode Kustom" di atas.', 'gesahan-news-pro' ),
        'section'     => 'ges_colors_section',
        'settings'    => 'ges_accent_color',
    )));

    // 3. KONTROL BARU: Kelengkungan Sudut Kartu (Border Radius)
    $wp_customize->add_setting( 'ges_card_border_radius', array(
        'default'           => 'semi-rounded',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control( 'ges_card_border_radius_ctrl', array(
        'label'       => esc_html__( 'Kelengkungan Sudut Kartu', 'gesahan-news-pro' ),
        'description' => esc_html__( 'Tentukan seberapa tumpul kelengkungan gambar dan bingkai kartu berita.', 'gesahan-news-pro' ),
        'section'     => 'ges_colors_section',
        'settings'    => 'ges_card_border_radius',
        'type'        => 'select',
        'choices'     => array(
            'sharp'        => esc_html__( 'Sharp (Siku / 0px)', 'gesahan-news-pro' ),
            'semi-rounded' => esc_html__( 'Semi-Rounded (Klasik / 6px)', 'gesahan-news-pro' ),
            'rounded'      => esc_html__( 'Rounded (Modern / 12px)', 'gesahan-news-pro' ),
            'pill'         => esc_html__( 'Extreme Pill (Tumpul Bulat / 20px)', 'gesahan-news-pro' ),
        ),
    ));
}

/**
 * INJEKSI CSS DINAMIS DI HEAD (Merespons Cepat Perubahan Warna & Kelengkungan Sudut Kartu)
 */
function ges_inject_dynamic_color_css() {
    $preset = get_theme_mod( 'ges_color_preset', 'cnn_red' );

    // Definisikan kode Hex Preset Warna & Efek Hover
    $accent = '#CC0000';
    $hover  = '#990000';

    switch ( $preset ) {
        case 'detik_blue':
            $accent = '#0055B8';
            $hover  = '#003B80';
            break;
        case 'kompas_blue':
            $accent = '#0A2C5C';
            $hover  = '#061D3D';
            break;
        case 'enviro_green':
            $accent = '#2E7D32';
            $hover  = '#1B5E20';
            break;
        case 'merdeka_orange':
            $accent = '#E65100';
            $hover  = '#B71C1C';
            break;
        case 'custom':
            $accent = get_theme_mod( 'ges_accent_color', '#CC0000' );
            $hover  = ges_adjust_brightness( $accent, -20 );
            break;
    }

    // Kalkulasi nilai kelengkungan sudut berdasarkan preset customizer
    $radius_type = get_theme_mod( 'ges_card_border_radius', 'semi-rounded' );
    $radius_sm = '0px';
    $radius_md = '0px';

    if ( $radius_type === 'semi-rounded' ) {
        $radius_sm = '4px';
        $radius_md = '6px';
    } elseif ( $radius_type === 'rounded' ) {
        $radius_sm = '8px';
        $radius_md = '12px';
    } elseif ( $radius_type === 'pill' ) {
        $radius_sm = '12px';
        $radius_md = '20px';
    }

    echo "\n<style id='ges-dynamic-colors'>\n";
    echo "  :root {\n";
    echo "    --color-accent: " . esc_attr($accent) . " !important;\n";
    echo "    --color-accent-hover: " . esc_attr($hover) . " !important;\n";
    echo "    --color-focus-outline: " . esc_attr($accent) . " !important;\n";
    echo "    --border-radius-sm: " . esc_attr($radius_sm) . " !important;\n";
    echo "    --border-radius-md: " . esc_attr($radius_md) . " !important;\n";
    echo "  }\n";
    echo "  [data-theme='dark'] {\n";
    echo "    --color-accent: " . esc_attr($accent) . " !important;\n";
    echo "    --color-accent-hover: " . esc_attr($hover) . " !important;\n";
    echo "  }\n";
    echo "</style>\n";
}
add_action( 'wp_head', 'ges_inject_dynamic_color_css', 10 );

/**
 * Helper: Menggelapkan/Menerangkan Kode Hex Warna Otomatis
 */
function ges_adjust_brightness( $hex, $steps ) {
    $steps = max( -255, min( 255, $steps ) );
    $hex = str_replace( '#', '', $hex );
    if ( strlen( $hex ) == 3 ) {
        $hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
    }
    $r = hexdec( substr( $hex, 0, 2 ) );
    $g = hexdec( substr( $hex, 2, 2 ) );
    $b = hexdec( substr( $hex, 4, 2 ) );

    $r = max( 0, min( 255, $r + $steps ) );
    $g = max( 0, min( 255, $g + $steps ) );
    $b = max( 0, min( 255, $b + $steps ) );

    $r_hex = str_pad( dechex( $r ), 2, '0', STR_PAD_LEFT );
    $g_hex = str_pad( dechex( $g ), 2, '0', STR_PAD_LEFT );
    $b_hex = str_pad( dechex( $b ), 2, '0', STR_PAD_LEFT );

    return '#' . $r_hex . $g_hex . $b_hex;
}