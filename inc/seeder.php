<?php
/**
 * GDS Enterprise Data Seeder Engine - Gesahan News Pro
 * Dilengkapi dengan sistem penguji otomatis (Auto-Lock Safeguard) dan Auto-Clean Rollback.
 *
 * @package Gesahan_News_Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * HELPER: Memeriksa apakah website sedang berjalan di lingkungan lokal (Development)
 *
 * @return bool True jika di localhost/local.test, False jika di domain produksi asli.
 */
function gds_is_development_environment() {
    // 1. Cek tipe lingkungan bawaan WordPress (jika disetel di wp-config.php)
    if ( function_exists( 'wp_get_environment_type' ) ) {
        $wp_env = wp_get_environment_type();
        if ( in_array( $wp_env, array( 'production', 'staging' ), true ) ) {
            return false; // Kunci jika di set ke produksi/staging
        }
    }

    // 2. Deteksi otomatis berdasarkan nama domain / HTTP Host
    $http_host = isset( $_SERVER['HTTP_HOST'] ) ? strtolower( sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) ) : '';

    if ( empty( $http_host ) ) {
        return false; // Kembalikan ke false demi keamanan jika host tidak terdeteksi
    }

    // Kumpulan pola nama domain lokal (Development)
    $local_signatures = array(
        'localhost',
        '127.0.0.1',
        '::1',
        '.local',
        '.test',
        '.dev',
        'local.test',
        'gesahan-local.test' // Domain lokal spesifik Anda
    );

    foreach ( $local_signatures as $signature ) {
        if ( strpos( $http_host, $signature ) !== false ) {
            return true; // Aktifkan seeder hanya jika cocok dengan domain lokal
        }
    }

    return false; // Blokir secara default jika dijalankan di domain asli publik (.com, .id, .net, dll)
}

/**
 * Registrasi Menu Dasbor Admin WordPress untuk Seeder (Diproteksi Ganda)
 */
function gds_register_seeder_admin_menu() {
    // PROTEKSI UTAMA: Jangan daftarkan menu dan kunci sistem jika berada di domain produksi
    if ( ! gds_is_development_environment() ) {
        return;
    }

    add_theme_page(
        esc_html__( 'Suntik Artikel Dummy', 'gesahan-news-pro' ),
        esc_html__( 'Suntik Artikel', 'gesahan-news-pro' ),
        'manage_options',
        'gds-data-seeder',
        'gds_render_seeder_admin_page'
    );
}
// Jalankan registrasi menu
add_action( 'admin_menu', 'gds_register_seeder_admin_menu' );

/**
 * Render halaman dasbor admin seeder
 */
function gds_render_seeder_admin_page() {
    // Keamanan lapis kedua: Cek hak akses dan lingkungan saat halaman dibuka
    if ( ! current_user_can( 'manage_options' ) || ! gds_is_development_environment() ) {
        wp_die( esc_html__( 'Maaf, fitur ini dinonaktifkan secara otomatis pada domain produksi asli demi keamanan data Anda.', 'gesahan-news-pro' ) );
    }

    $seeded = false;
    $cleaned = false;
    $post_count = 0;
    $cleaned_count = 0;

    // Aksi 1: Suntik Data
    if ( isset( $_POST['gds_trigger_seeder'] ) && check_admin_referer( 'gds_seeder_action', 'gds_seeder_nonce' ) ) {
        $post_count = gds_execute_news_seeder();
        $seeded = true;
    }

    // Aksi 2: Bersihkan Data (Rollback)
    if ( isset( $_POST['gds_trigger_cleanup'] ) && check_admin_referer( 'gds_cleanup_action', 'gds_cleanup_nonce' ) ) {
        $cleaned_count = gds_execute_news_cleanup();
        $cleaned = true;
    }
    ?>
    <div class="wrap" style="max-width: 800px; margin-top: 30px; font-family: sans-serif;">
        <h1 style="font-weight: 900; font-size: 28px; color: #111; margin-bottom: 10px;">⚡ GDS Enterprise News Seeder</h1>
        <p style="font-size: 15px; color: #555; line-height: 1.6; margin-bottom: 24px;">
            Fitur ini digunakan untuk menyuntikkan <strong>artikel berita demo berkualitas premium</strong> pada server lokal Anda agar tampilan web terlihat ramai saat presentasi.
        </p>

        <?php if ( $seeded ) : ?>
            <div class="notice notice-success is-dismissible" style="padding: 15px; border-left-color: #46b450; margin-bottom: 24px;">
                <p style="font-size: 16px; font-weight: bold; margin: 0 0 5px 0; color: #46b450;">🎉 Berhasil Disuntikkan!</p>
                <p style="font-size: 14px; margin: 0; color: #333;">
                    Sebanyak <strong><?php echo esc_html( $post_count ); ?> Artikel Berita Indonesia</strong> telah berhasil dipasang ke database lokal Anda.
                </p>
            </div>
        <?php endif; ?>

        <?php if ( $cleaned ) : ?>
            <div class="notice notice-warning is-dismissible" style="padding: 15px; border-left-color: #ffb900; margin-bottom: 24px;">
                <p style="font-size: 16px; font-weight: bold; margin: 0 0 5px 0; color: #ffb900;">🧹 Database Dibersihkan!</p>
                <p style="font-size: 14px; margin: 0; color: #333;">
                    Sebanyak <strong><?php echo esc_html( $cleaned_count ); ?> Artikel Demo</strong> telah dihapus total secara bersih dari database Anda. Database Anda kini steril kembali.
                </p>
            </div>
        <?php endif; ?>

        <div style="background: #ffffff; border: 1px solid #ccd0d4; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin-bottom: 20px;">
            <div style="background-color: #fff8e5; border-left: 4px solid #ffb900; padding: 12px; margin-bottom: 20px; font-size: 13px; color: #333;">
                <strong>🛡️ JANGAN DIBAWA SAAT INSTALASI:</strong> Gunakan tombol merah untuk mengisi konten demo saat presentasi, dan gunakan tombol hitam di bawah sebelum Anda mengekspor/menginstal tema ini pada website klien atau server produksi agar database bersih kembali.
            </div>
            
            <h3 style="margin-top: 0; font-size: 18px; font-weight: bold; color: #23282d;">1. Suntik Artikel Demo</h3>
            <p style="font-size: 13px; color: #666;">Mengisi database dengan 150 artikel berita terdistribusi rapi ke seluruh kategori bawaan.</p>
            
            <form method="post" action="" style="margin-top: 15px;">
                <?php wp_nonce_field( 'gds_seeder_action', 'gds_seeder_nonce' ); ?>
                <input type="submit" name="gds_trigger_seeder" class="button button-primary button-large" style="background: #CC0000; border-color: #990000; font-weight: bold; padding: 6px 30px; height: auto; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;" value="Suntik 150 Artikel Demo" />
            </form>
        </div>

        <div style="background: #ffffff; border: 1px solid #ccd0d4; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
            <h3 style="margin-top: 0; font-size: 18px; font-weight: bold; color: #23282d;">2. Bersihkan Database (Auto-Clean Rollback)</h3>
            <p style="font-size: 13px; color: #666;">Menghapus seluruh artikel demo yang disuntikkan oleh sistem seeder ini tanpa merusak artikel asli yang Anda buat manual.</p>
            
            <form method="post" action="" style="margin-top: 15px;">
                <?php wp_nonce_field( 'gds_cleanup_action', 'gds_cleanup_nonce' ); ?>
                <input type="submit" name="gds_trigger_cleanup" class="button button-secondary button-large" style="background: #111111; border-color: #000000; color: #fff; font-weight: bold; padding: 6px 30px; height: auto; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;" value="Hapus Bersih Artikel Demo" onclick="return confirm('Apakah Anda yakin ingin menghapus seluruh artikel demo dari database?');" />
            </form>
        </div>
    </div>
    <?php
}

/**
 * Eksekusi Generator Suntik Data Berita
 */
function gds_execute_news_seeder() {
    if ( ! gds_is_development_environment() ) {
        return 0;
    }

    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    $unsplash_images = array(
        'https://images.unsplash.com/photo-1541872703-74c5e44368f9?w=800&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1526470608268-f674ce90ebd4?w=800&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1590283603385-17ffb3a7f29f?w=800&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1508098682722-e99c43a406b2?w=800&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1540747737956-37872404a8de?w=800&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=800&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1498654896293-37aacf113fd9?w=800&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1533929736458-ca588eb77445?w=800&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=800&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=800&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=800&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1506012787146-f92b2d7d6d96?w=800&auto=format&fit=crop&q=80'
    );

    $attachment_ids = array();
    foreach ( $unsplash_images as $index => $img_url ) {
        $desc = "GDS Editorial Image " . ($index + 1);
        $att_id = media_sideload_image( $img_url, 0, $desc, 'id' );
        if ( ! is_wp_error( $att_id ) ) {
            $attachment_ids[] = $att_id;
        }
    }

    if ( empty( $attachment_ids ) ) {
        $existing_attachments = get_posts( array(
            'post_type'      => 'attachment',
            'posts_per_page' => 10,
            'fields'         => 'ids'
        ) );
        if ( ! empty( $existing_attachments ) ) {
            $attachment_ids = $existing_attachments;
        }
    }

    $news_templates = array(
        'Nasional' => array(
            'titles' => array(
                'Pembangunan Tol Trans-Sumatera Tahap II Dipercepat, Ditargetkan Rampung Akhir Tahun',
                'Pemerintah Resmi Salurkan Subsidi Energi Tepat Sasaran Mulai Bulan Depan',
                'Kementerian BUMN Alokasikan Anggaran Rp5 Triliun untuk Pengembangan UMKM Daerah',
                'Infrastruktur IKN Nusantara Masuk Tahap Akhir, Istana Presiden Siap Digunakan',
                'Sistem Transportasi Massal Baru LRT Jabodebek Catatkan Rekor 1 Juta Penumpang'
            ),
            'paragraphs' => array(
                'Langkah ini diambil guna mendukung mobilitas dan konektivitas antardaerah yang menjadi urat nadi perekonomian nasional.',
                'Menteri Keuangan menegaskan pentingnya efisiensi alokasi anggaran agar target pertumbuhan ekonomi nasional sebesar 5,2 persen dapat tercapai sesuai rencana.',
                'Masyarakat menyambut baik kebijakan ini, berharap dapat menekan biaya logistik dan harga kebutuhan pokok di pasar tradisional secara signifikan.'
            )
        )
    );

    $trending_tags = array( 'BadanGiziNasional', 'PialaAFF2026', 'InfrastrukturIKN', 'TransformasiDigital' );

    $total_posts_to_seed = 150;
    $seeded_count = 0;

    $categories = get_categories( array( 'hide_empty' => false ) );
    if ( empty( $categories ) ) {
        return 0;
    }

    for ( $i = 0; $i < $total_posts_to_seed; $i++ ) {
        $cat_object = $categories[ array_rand( $categories ) ];
        $cat_name   = $cat_object->name;

        $template_key = isset( $news_templates[$cat_name] ) ? $cat_name : 'Nasional';
        $title_pool   = $news_templates[$template_key]['titles'];
        $para_pool    = $news_templates[$template_key]['paragraphs'];

        $base_title = $title_pool[ array_rand( $title_pool ) ];
        $post_title = $base_title . " (Demo " . ($seeded_count + 1) . ")";

        $p1 = $para_pool[0];
        $p2 = $para_pool[1];
        $p3 = $para_pool[2];
        $p4 = "Hal ini menegaskan komitmen kuat dari seluruh pihak yang terlibat untuk terus melakukan perbaikan tata kelola serta mengutamakan kepentingan masyarakat.";
        $post_content = "<p>{$p1}</p><p>{$p2}</p><p>{$p3}</p><p>{$p4}</p>";

        $random_days_ago = rand( 0, 30 );
        $post_date = date( 'Y-m-d H:i:s', strtotime( "-{$random_days_ago} days" ) );

        $post_data = array(
            'post_title'    => $post_title,
            'post_content'  => $post_content,
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_date'     => $post_date,
            'post_category' => array( $cat_object->term_id ),
        );

        $inserted_post_id = wp_insert_post( $post_data );

        if ( ! is_wp_error( $inserted_post_id ) ) {
            // Tandai artikel demo menggunakan meta key khusus agar bisa dihapus bersih nantinya
            update_post_meta( $inserted_post_id, '_gds_is_seeded', '1' );

            if ( ! empty( $attachment_ids ) ) {
                $random_thumb_id = $attachment_ids[ array_rand( $attachment_ids ) ];
                set_post_thumbnail( $inserted_post_id, $random_thumb_id );
            }

            $assigned_tags = array();
            $tag_count = rand( 1, 2 );
            for ( $t = 0; $t < $tag_count; $t++ ) {
                $assigned_tags[] = $trending_tags[ array_rand( $trending_tags ) ];
            }
            wp_set_post_tags( $inserted_post_id, implode( ',', $assigned_tags ), true );

            $seeded_count++;
        }
    }

    return $seeded_count;
}

/**
 * Eksekusi Pembersihan (Rollback) Database Artikel Demo
 */
function gds_execute_news_cleanup() {
    if ( ! gds_is_development_environment() ) {
        return 0;
    }

    // Cari seluruh artikel yang memiliki meta key demo khusus
    $seeded_posts = get_posts( array(
        'post_type'      => 'post',
        'posts_per_page' => -1,
        'post_status'    => 'any',
        'meta_query'     => array(
            array(
                'key'   => '_gds_is_seeded',
                'value' => '1',
            )
        )
    ));

    if ( empty( $seeded_posts ) ) {
        return 0;
    }

    $deleted_count = 0;
    foreach ( $seeded_posts as $seeded_post ) {
        // Hapus artikel secara permanen (by-pass trash)
        $deleted = wp_delete_post( $seeded_post->ID, true );
        if ( $deleted ) {
            $deleted_count++;
        }
    }

    return $deleted_count;
}