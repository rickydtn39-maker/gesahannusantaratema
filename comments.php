<?php
/**
 * Template Kolom Komentar Minimalis - CNN Indonesia Style
 *
 * @package Gentara_News
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( post_password_required() ) {
    return;
}

// Callback Kustom untuk List Komentar agar Identik dengan CNN Indonesia
if ( ! function_exists( 'gn_comment_callback' ) ) {
    function gn_comment_callback( $comment, $args, $depth ) {
        ?>
        <li id="comment-<?php comment_ID(); ?>" <?php comment_class( 'gn-comment-item' ); ?> style="list-style:none; padding: 15px 0; border-bottom: 1px solid var(--color-border);">
            <div class="comment-body" style="display:flex; gap:12px; align-items:flex-start;">
                <!-- Avatar Bulat -->
                <div class="gn-comment-avatar" style="width:40px; height:40px; border-radius:50%; overflow:hidden; flex-shrink:0; background-color: var(--color-border);">
                    <?php echo get_avatar( $comment, 40 ); ?>
                </div>
                <!-- Isi Komentar -->
                <div class="comment-main" style="flex-grow:1;">
                    <div class="comment-meta" style="font-size:11px; color:var(--color-text-muted); margin-bottom:4px; font-family: var(--font-sans);">
                        <span class="comment-author-name" style="font-weight:bold; color:#000; margin-right:8px;"><?php comment_author(); ?></span>
                        <span class="comment-date"><?php printf( esc_html__( '%1$s pada %2$s', 'gentara-news' ), get_comment_date(), get_comment_time() ); ?></span>
                    </div>
                    <div class="comment-content-text" style="font-size:13px; color:#333333; line-height:1.4; font-family: var(--font-sans);">
                        <?php comment_text(); ?>
                    </div>
                    <div class="comment-reply" style="margin-top:6px; font-family: var(--font-sans);">
                        <?php
                        comment_reply_link( array_merge( $args, array(
                            'depth'     => $depth,
                            'max_depth' => $args['max_depth'],
                            'reply_text'=> esc_html__( 'Balas', 'gentara-news' ),
                        ) ) );
                        ?>
                    </div>
                </div>
            </div>
        </li>
        <?php
    }
}
?>

<div id="comments" class="gn-comments-area">

    <!-- Header Jumlah Komentar -->
    <h3 class="gn-comments-title">
        <?php
        $comment_count = get_comments_number();
        if ( '0' === $comment_count ) {
            esc_html_e( '0 Komentar', 'gentara-news' );
        } else {
            printf(
                /* translators: 1: comment count number */
                esc_html( _nx( '%1$s Komentar', '%1$s Komentar', $comment_count, 'comments title', 'gentara-news' ) ),
                number_format_i18n( $comment_count )
            );
        }
        ?>
    </h3>

    <!-- Formulir Input Komentar Minimalis -->
    <?php
    comment_form( array(
        'title_reply'          => '',
        'title_reply_to'       => '',
        'comment_notes_before' => '',
        'comment_notes_after'  => '',
        'logged_in_as'         => '',
        'class_form'           => 'comment-form gn-comment-form',
        
        // Input Utama: Flex row Avatar + Textarea + Submit Button
        'comment_field'        => '
            <div class="gn-comment-form-container">
                <div class="gn-comment-avatar">' . get_avatar( get_current_user_id(), 40 ) . '</div>
                <div class="gn-comment-input-row">
                    <textarea id="comment" name="comment" class="gn-comment-textarea" placeholder="' . esc_attr__( 'Tulis Komentar...', 'gentara-news' ) . '" rows="1" required></textarea>
                </div>
            </div>
        ',

        // Field Tambahan hanya muncul untuk Tamu (Guest)
        'fields'               => array(
            'author' => '<input id="author" name="author" type="text" class="gn-comment-guest-input" placeholder="' . esc_attr__( 'Nama *', 'gentara-news' ) . '" required />',
            'email'  => '<input id="email" name="email" type="email" class="gn-comment-guest-input" placeholder="' . esc_attr__( 'Email *', 'gentara-news' ) . '" required />',
            'url'    => '', // Sembunyikan field website
            'cookies'=> '', // Sembunyikan persetujuan cookie
        ),

        'submit_button'        => '<button name="%1$s" type="submit" id="%2$s" class="gn-comment-submit-btn">' . esc_html__( 'Kirim', 'gentara-news' ) . '</button>',
        'submit_field'         => '<div class="gn-submit-row">%1$s %2$s</div>',
    ) );
    ?>

    <!-- Daftar Komentar -->
    <?php if ( have_comments() ) : ?>
        <ol class="gn-comment-list" style="margin-top: var(--space-md); padding: 0;">
            <?php
            wp_list_comments( array(
                'callback'   => 'gn_comment_callback',
                'short_ping' => true,
            ) );
            ?>
        </ol>

        <!-- Paginasi Komentar -->
        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
            <nav class="navigation comment-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Navigasi Komentar', 'gentara-news' ); ?>" style="margin-top: var(--space-md);">
                <div class="nav-links" style="display: flex; justify-content: space-between; font-size:12px; font-weight:bold; font-family: var(--font-sans);">
                    <div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Komentar Lama', 'gentara-news' ) ); ?></div>
                    <div class="nav-next"><?php next_comments_link( esc_html__( 'Komentar Baru &rarr;', 'gentara-news' ) ); ?></div>
                </div>
            </nav>
        <?php endif; ?>

    <?php endif; ?>

</div>