<?php
namespace Gentara\Widgets;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class EditorChoice extends \WP_Widget {
    public function __construct() {
        parent::__construct(
            'ges_editor_choice_widget',
            esc_html__( 'Gentara: Pilihan Redaksi', 'gentara-news' ),
            array( 'description' => esc_html__( 'Menampilkan berita utama pilihan redaksi berdasarkan kategori khusus.', 'gentara-news' ) )
        );
    }

    public function widget( $args, $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Pilihan Redaksi', 'gentara-news' );
        $cat_id = ! empty( $instance['cat_id'] ) ? absint( $instance['cat_id'] ) : 0;

        echo $args['before_widget'];
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
        }

        $query_args = array( 'posts_per_page' => 3, 'post_status' => 'publish' );
        if ( $cat_id > 0 ) {
            $query_args['cat'] = $cat_id;
        }

        $choice_query = new \WP_Query( $query_args );

        if ( $choice_query->have_posts() ) {
            while ( $choice_query->have_posts() ) {
                $choice_query->the_post();
                get_template_part( 'template-parts/cards/card-featured' );
            }
            wp_reset_postdata();
        }

        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $cat_id = ! empty( $instance['cat_id'] ) ? absint( $instance['cat_id'] ) : 0;
        
        $categories = get_categories();
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Judul Widget:', 'gentara-news' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'cat_id' ) ); ?>"><?php esc_html_e( 'Pilih Kategori Sumber:', 'gentara-news' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cat_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cat_id' ) ); ?>">
                <option value="0"><?php esc_html_e( '-- Tampilkan Semua --', 'gentara-news' ); ?></option>
                <?php foreach ( $categories as $cat ) : ?>
                    <option value="<?php echo esc_attr( $cat->term_id ); ?>" <?php selected( $cat_id, $cat->term_id ); ?>><?php echo esc_html( $cat->name ); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <?php
    }
}