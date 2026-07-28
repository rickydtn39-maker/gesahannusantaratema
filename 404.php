<?php
/**
 * 404 Error State Page (Volume 3 Bab 43, Volume 4 Bab 15)
 */
get_header();
?>

<main id="primary-content" class="container" role="main" style="min-height: 70vh; display:flex; align-items:center; justify-content:center;">
    <section class="error-404 not-found text-center" style="text-align: center; max-width: 600px; padding: var(--space-xl) 0;">
        <span class="error-icon" style="font-size: 5rem; display:block; margin-bottom: var(--space-sm);">🚧</span>
        <h1 style="font-size: var(--font-size-xl); font-weight: var(--font-weight-bold); margin-bottom: var(--space-xs);">404</h1>
        <h2 style="font-size: var(--font-size-md); font-weight: var(--font-weight-medium); margin-bottom: var(--space-sm);">
            <?php esc_html_e( 'Halaman Tidak Ditemukan', 'gesahan-news-pro' ); ?>
        </h2>
        <p style="color: var(--color-text-muted); margin-bottom: var(--space-md);">
            <?php esc_html_e( 'Maaf, halaman yang Anda tuju telah dipindahkan atau tidak pernah ada sebelumnya.', 'gesahan-news-pro' ); ?>
        </p>
        <div style="display:flex; gap:var(--space-sm); justify-content:center;">
            <a href="<?php echo esc_url( home_url('/') ); ?>" class="btn btn-primary btn-md"><?php esc_html_e('Kembali ke Beranda', 'gesahan-news-pro'); ?></a>
        </div>
    </section>
</main>

<?php
get_footer();