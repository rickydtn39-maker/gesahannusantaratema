<?php
namespace Gentara\Providers;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Gentara\Core\ServiceProvider;
use Gentara\Repositories\PostRepository;

/**
 * Enterprise Query & Cache Busting Provider
 */
class QueryServiceProvider extends ServiceProvider {

    public function register() {
        require_once GENTARA_DIR . '/inc/repositories/class-post-repository.php';

        $this->container->singleton( PostRepository::class, function() {
            return new PostRepository();
        });
    }

    public function boot() {
        $repository = $this->container->make( PostRepository::class );

        // Picu pembersihan seluruh cache transient instan saat ada perubahan postingan
        add_action( 'save_post', array( $repository, 'flush_cache' ) );
        add_action( 'deleted_post', array( $repository, 'flush_cache' ) );
        add_action( 'switch_theme', array( $repository, 'flush_cache' ) );
    }
}