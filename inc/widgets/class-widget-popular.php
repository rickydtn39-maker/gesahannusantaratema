<?php
namespace Gentara\Widgets;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Custom Popular Posts Widget with Numeric Ranks
 */
class Popular extends \WP_Widget {
    public function __construct() {
        parent::__construct(
            'ges_popular_widget',
            esc_html__( 'Gentara: Berita Populer (Numerik)', 'gentara-news' ),
            array( 'description' => esc_html__( 'Menampilkan postingan terpopuler lengkap dengan ranking urut.', 'gentara-news' ) )
        );
    }

    public function widget( $args, $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Paling Populer', 'gentara-news' );
        $limit = ! empty( $instance['limit'] ) ? absint( $instance['limit'] ) : 5;

        echo $args['before_widget'];
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
        }

        $pop_query = new \WP_Query( array(
            'posts_per_page' => $limit,
            'orderby'        => 'comment_count', // Sederhana & Cepat tanpa plugin counter tambahan
            'post_status'    => 'publish',
        ));

        if ( $pop_query->have_posts() ) {
            $rank = 1;
            echo '<div class="popular-widget-list" style="display:flex; flex-direction:column; gap: var(--space-sm);">';
            while ( $pop_query->have_posts() ) {
                $pop_query->the_post();
                ?>
                <div class="popular-item" style="display:flex; gap:var(--space-sm); align-items:center;">
                    <span class="popular-rank" style="font-size: var(--font-size-md); font-weight:var(--font-weight-bold); color: var(--color-accent); line-height:1; min-width:24px;">
                        #<?php echo esc_html( $rank ); ?>
                    </span>
                    <div class="popular-info">
                        <h4 style="font-size: var(--font-size-xs); line-height: var(--line-height-tight); font-weight: var(--font-weight-bold); margin:0;">
                            <a href="<?php the_permalink(); ?>" style="color:var(--color-primary); text-decoration:none;"><?php the_title(); ?></a>
                        </h4>
                    </div>
                </div>
                <?php
                $rank++;
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
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Judul:', 'gentara-news' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php esc_html_e( 'Jumlah Tampilan:', 'gentara-news' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" type="number" value="<?php echo esc_attr( $limit ); ?>">
        </p>
        <?php
    }
}