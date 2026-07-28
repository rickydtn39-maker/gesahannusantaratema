<?php
namespace Gentara\Repositories;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Query Manager & Cache Layer (Repository Pattern)
 */
class PostRepository {
    /**
     * Durasi cache transient (1 jam)
     */
    private $cache_lifespan = HOUR_IN_SECONDS;

    /**
     * Mengambil versi cache transient aktif untuk auto-busting cache
     */
    public function get_cache_version() {
        $version = get_transient( 'gentara_cache_version' );
        if ( false === $version ) {
            $version = time();
            set_transient( 'gentara_cache_version', $version, YEAR_IN_SECONDS );
        }
        return $version;
    }

    /**
     * Menaikkan versi cache global untuk menghancurkan seluruh cache lama secara instan
     */
    public function flush_cache() {
        set_transient( 'gentara_cache_version', time(), YEAR_IN_SECONDS );
    }

    /**
     * Mendapatkan kunci transient unik yang aman
     */
    private function get_cache_key( string $identifier, array $params = array() ) {
        $version = $this->get_cache_version();
        return 'gent_' . substr( md5( $identifier . serialize( $params ) . '_' . $version ), 0, 30 );
    }

    /**
     * QUERY: Berita Populer (Berdasarkan jumlah komentar)
     */
    public function get_popular_posts( int $limit = 5 ) {
        $cache_key = $this->get_cache_key( 'popular', array( $limit ) );
        $posts     = get_transient( $cache_key );

        if ( false === $posts ) {
            $query = new \WP_Query( array(
                'posts_per_page'      => $limit,
                'orderby'             => array( 'comment_count' => 'DESC', 'date' => 'DESC' ),
                'post_status'         => 'publish',
                'ignore_sticky_posts' => 1,
            ) );
            $posts = $query->get_posts();
            set_transient( $cache_key, $posts, $this->cache_lifespan );
        }

        return $posts;
    }

    /**
     * QUERY: Berita Terbaru dengan sistem eksklusi ID (Mencegah duplikasi dari Hero)
     */
    public function get_latest_posts( int $limit = 6, array $exclude_ids = array() ) {
        $cache_key = $this->get_cache_key( 'latest', array( $limit, $exclude_ids ) );
        $posts     = get_transient( $cache_key );

        if ( false === $posts ) {
            $args = array(
                'posts_per_page'      => $limit,
                'post_status'         => 'publish',
                'ignore_sticky_posts' => 1,
            );
            if ( ! empty( $exclude_ids ) ) {
                $args['post__not_in'] = $exclude_ids;
            }
            $query = new \WP_Query( $args );
            $posts = $query->get_posts();
            set_transient( $cache_key, $posts, $this->cache_lifespan );
        }

        return $posts;
    }

    /**
     * QUERY: Berita Kategori Tertentu
     */
    public function get_category_posts( int $cat_id, int $limit = 4 ) {
        $cache_key = $this->get_cache_key( 'category_block', array( $cat_id, $limit ) );
        $posts     = get_transient( $cache_key );

        if ( false === $posts ) {
            $args = array(
                'posts_per_page'      => $limit,
                'post_status'         => 'publish',
                'ignore_sticky_posts' => 1,
            );
            if ( $cat_id > 0 ) {
                $args['cat'] = $cat_id;
            }
            $query = new \WP_Query( $args );
            $posts = $query->get_posts();
            set_transient( $cache_key, $posts, $this->cache_lifespan );
        }

        return $posts;
    }

    /**
     * QUERY: Ticker / Berita Berjalan
     */
    public function get_ticker_posts( int $limit = 5 ) {
        $cache_key = $this->get_cache_key( 'ticker', array( $limit ) );
        $posts     = get_transient( $cache_key );

        if ( false === $posts ) {
            $query = new \WP_Query( array(
                'posts_per_page'      => $limit,
                'post_status'         => 'publish',
                'ignore_sticky_posts' => 1,
            ) );
            $posts = $query->get_posts();
            set_transient( $cache_key, $posts, $this->cache_lifespan );
        }

        return $posts;
    }

    /**
     * QUERY: Pilihan Redaksi
     */
    public function get_editors_choice_posts( int $cat_id, int $limit = 3 ) {
        $cache_key = $this->get_cache_key( 'editors_choice', array( $cat_id, $limit ) );
        $posts     = get_transient( $cache_key );

        if ( false === $posts ) {
            $args = array(
                'posts_per_page'      => $limit,
                'post_status'         => 'publish',
                'ignore_sticky_posts' => 1,
            );
            if ( $cat_id > 0 ) {
                $args['cat'] = $cat_id;
            }
            $query = new \WP_Query( $args );
            $posts = $query->get_posts();
            set_transient( $cache_key, $posts, $this->cache_lifespan );
        }

        return $posts;
    }
}