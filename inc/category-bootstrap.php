<?php
/**
 * Automatic Category and Primary Menu Bootstrap.
 *
 * Membuat struktur kategori lengkap dan menu primer secara otomatis
 * tanpa menimpa menu primer yang sudah dibuat manual oleh pengguna.
 *
 * @package Gesahan_News_Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Versi struktur kategori/menu.
 *
 * Naikkan angka versi ini apabila struktur kategori bawaan berubah
 * pada pengembangan berikutnya.
 */
define( 'GESAHAN_CATEGORY_SCHEMA_VERSION', '1.0.0' );

/**
 * Menjalankan perbaikan kategori dan pembuatan menu otomatis bila diperlukan.
 *
 * Sistem ini aman dijalankan berulang karena:
 * - Kategori memakai fungsi aman `ges_create_category_safe()`.
 * - Menu hanya dibuat jika lokasi Primary belum memiliki menu.
 */
function gesahan_bootstrap_categories_and_menu() {
    if ( ! function_exists( 'ges_init_default_categories' ) ) {
        return;
    }

    $installed_version = get_option( 'gesahan_category_schema_version', '' );

    /*
     * Jika struktur belum pernah diperiksa dengan sistem baru ini,
     * hapus marker lama agar fungsi kategori memverifikasi dan
     * menciptakan kategori/subkategori yang mungkin belum tersedia.
     */
    if ( GESAHAN_CATEGORY_SCHEMA_VERSION !== $installed_version ) {
        delete_option( 'ges_categories_initialized' );

        ges_init_default_categories();

        update_option( 'gesahan_category_schema_version', GESAHAN_CATEGORY_SCHEMA_VERSION );
    }

    gesahan_create_default_primary_menu();
}

/**
 * Membuat Menu Primary otomatis jika lokasi Primary masih kosong.
 *
 * Penting:
 * - Jika Anda sudah membuat menu sendiri pada Primary Navigation Menu,
 *   fungsi ini tidak melakukan perubahan apa pun.
 * - Jika ingin kembali memakai menu otomatis, hapus assignment menu
 *   Primary melalui Tampilan > Menu > Kelola Lokasi, lalu jalankan ulang
 *   proses ini dengan mengaktifkan ulang tema atau menghapus option
 *   `gesahan_category_schema_version`.
 */
function gesahan_create_default_primary_menu() {
    $locations = get_nav_menu_locations();

    /*
     * Jangan sentuh menu jika Primary Navigation sudah ditetapkan.
     * Ini melindungi menu manual milik administrator.
     */
    if ( ! empty( $locations['primary'] ) ) {
        return;
    }

    $menu_name = 'Navigasi Utama Gesahan';

    $existing_menu = wp_get_nav_menu_object( $menu_name );

    if ( $existing_menu ) {
        $menu_id = (int) $existing_menu->term_id;
    } else {
        $menu_id = wp_create_nav_menu( $menu_name );

        if ( is_wp_error( $menu_id ) ) {
            return;
        }
    }

    /*
     * Jika menu sudah memiliki isi, jangan tambahkan ulang item.
     */
    $existing_items = wp_get_nav_menu_items( $menu_id );

    if ( ! empty( $existing_items ) ) {
        $locations['primary'] = $menu_id;
        set_theme_mod( 'nav_menu_locations', $locations );
        return;
    }

    /*
     * Item Beranda.
     */
    wp_update_nav_menu_item(
        $menu_id,
        0,
        array(
            'menu-item-title'  => esc_html__( 'Home', 'gesahan-news-pro' ),
            'menu-item-url'    => home_url( '/' ),
            'menu-item-status' => 'publish',
            'menu-item-type'   => 'custom',
        )
    );

    /*
     * Kategori induk utama yang ingin ditampilkan di header.
     */
    $main_categories = array(
        'Nasional',
        'Daerah',
        'Internasional',
        'Hukum',
        'Politik',
        'Ekonomi',
        'Olahraga',
        'Lifestyle',
        'Opini',
    );

    foreach ( $main_categories as $category_name ) {
        $category = get_category_by_slug( sanitize_title( $category_name ) );

        if ( ! $category || is_wp_error( $category ) ) {
            continue;
        }

        gesahan_add_category_to_menu_tree( $menu_id, $category->term_id, 0 );
    }

    /*
     * Tetapkan menu hasil otomatis ini ke lokasi Primary Navigation Menu.
     */
    $locations['primary'] = $menu_id;

    set_theme_mod( 'nav_menu_locations', $locations );
}

/**
 * Menambahkan kategori dan seluruh anak kategorinya ke menu secara rekursif.
 *
 * Contoh:
 * Daerah
 * └── Sumatera
 *     ├── Aceh
 *     ├── Riau
 *     └── Lampung
 *
 * @param int $menu_id        ID menu WordPress.
 * @param int $category_id    ID kategori yang akan dimasukkan.
 * @param int $parent_menu_id ID item menu induk.
 * @return void
 */
function gesahan_add_category_to_menu_tree( $menu_id, $category_id, $parent_menu_id = 0 ) {
    $category = get_category( $category_id );

    if ( ! $category || is_wp_error( $category ) ) {
        return;
    }

    $menu_item_id = wp_update_nav_menu_item(
        $menu_id,
        0,
        array(
            'menu-item-title'     => $category->name,
            'menu-item-object'    => 'category',
            'menu-item-object-id' => $category->term_id,
            'menu-item-type'      => 'taxonomy',
            'menu-item-parent-id' => $parent_menu_id,
            'menu-item-status'    => 'publish',
        )
    );

    if ( is_wp_error( $menu_item_id ) ) {
        return;
    }

    $children = get_categories(
        array(
            'taxonomy'   => 'category',
            'parent'     => $category->term_id,
            'hide_empty' => false,
            'orderby'    => 'name',
            'order'      => 'ASC',
        )
    );

    if ( empty( $children ) ) {
        return;
    }

    foreach ( $children as $child_category ) {
        gesahan_add_category_to_menu_tree(
            $menu_id,
            $child_category->term_id,
            $menu_item_id
        );
    }
}

/**
 * Jalankan saat tema diaktifkan.
 *
 * Prioritas 20 memastikan fungsi bawaan kategori di inc/setup.php
 * sudah berjalan lebih dulu pada prioritas default.
 */
add_action( 'after_switch_theme', 'gesahan_bootstrap_categories_and_menu', 20 );

/**
 * Jalankan juga dari admin sebagai fallback.
 *
 * Berguna bila file tema/kode baru dipasang setelah tema telah aktif.
 */
add_action( 'admin_init', 'gesahan_bootstrap_categories_and_menu' );