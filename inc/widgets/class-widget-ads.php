<?php
namespace Gentara\Widgets;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Ads extends \WP_Widget {
    public function __construct() {
        parent::__construct(
            'ges_ads_widget',
            esc_html__( 'Gentara: Unit Iklan Sidebar', 'gentara-news' ),
            array( 'description' => esc_html__( 'Memasukkan script unit iklan responsif di bilah samping.', 'gentara-news' ) )
        );
    }

    public function widget( $args, $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $code  = ! empty( $instance['ad_code'] ) ? $instance['ad_code'] : '';

        echo $args['before_widget'];
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
        }

        echo '<div class="ad-widget-wrapper" style="text-align:center; margin:0 auto;">';
        if ( ! empty( $code ) ) {
            echo ges_sanitize_ad_code( $code ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        } else {
            echo '<div style="background-color: var(--color-bg-surface); border:1px dashed var(--color-border); padding:var(--space-md); color:var(--color-text-muted); font-size:var(--font-size-xs);">';
            esc_html_e( '[GDS Iklan Sidebar: Konfigurasikan Script Iklan Anda]', 'gentara-news' );
            echo '</div>';
        }
        echo '</div>';

        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $code  = ! empty( $instance['ad_code'] ) ? $instance['ad_code'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Label Iklan (Opsional):', 'gentara-news' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'ad_code' ) ); ?>"><?php esc_html_e( 'Script Kode Iklan:', 'gentara-news' ); ?></label>
            <textarea class="widefat" rows="8" id="<?php echo esc_attr( $this->get_field_id( 'ad_code' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ad_code' ) ); ?>"><?php echo esc_textarea( $code ); ?></textarea>
        </p>
        <?php
    }
}