<?php
/**
 * Gentara News Enterprise Edition Bootstrapper
 *
 * @package Gentara_News
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Proteksi keamanan akses langsung
}

// 1. DEFINISI KONSTANTA BARU (GENTARA NEWS)
define( 'GENTARA_VERSION', '2.0.0' );
define( 'GENTARA_DIR', get_template_directory() );
define( 'GENTARA_URI', get_template_directory_uri() );

// 2. DEFENSIVE CONSTANT ALIASING (Proteksi Mutlak dari Error Undefined Constant)
define( 'GESAHAN_VERSION', GENTARA_VERSION );
define( 'GESAHAN_DIR', GENTARA_DIR );
define( 'GESAHAN_URI', GENTARA_URI );

// Memuat modul keandalan keamanan terlebih dahulu
require_once GENTARA_DIR . '/inc/security.php';

// Memuat kelas Bootstrap Utama Tema skala Enterprise
require_once GENTARA_DIR . '/inc/classes/class-theme.php';

// Menginisialisasi Core Theme Gentara News
\Gentara\Core\Theme::get_instance();