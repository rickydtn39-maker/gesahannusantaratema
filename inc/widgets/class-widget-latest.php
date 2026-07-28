<?php
namespace Gentara\Widgets;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Latest extends \WP_Widget {
    public function __construct() {
        parent::__construct(
            'ges_latest_widget',
            esc_html__( 'Gentara: Berita Terbaru', 'gentara-news' ),
            array( 'description' => esc_html__( 'Menampilkan postingan berita terbaru di sidebar.', 'gentara-news' ) )
        );
    }

    public function widget( $args, $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Berita Terbaru', 'gentara-news' );
        $limit = ! empty( $instance['limit'] ) ? absint( $instance['limit'] ) : 5;

        echo $args['before_widget'];
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
        }

        $latest_query = new \WP_Query( array(
            'posts_per_page' => $limit,
            'post_status'    => 'publish',
        ));

        if ( $latest_query->have_posts() ) {
            echo '<div class="latest-widget-list">';
            while ( $latest_query->have_posts() ) {
                $latest_query->the_post();
                get_template_part( 'template-parts/cards/card-compact' );
            }
            echo '</div>';
            wp_reset_postdata();
        }

        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $limit = ! empty( $instance['limit'] ) ? $instance['limit'] : 5;
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Judul Widget:', 'gentara-news' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php esc_html_e( 'Jumlah Postingan:', 'gentara-news' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" type="number" value="<?php echo esc_attr( $limit ); ?>">
        </p>
        <?php
    }
}