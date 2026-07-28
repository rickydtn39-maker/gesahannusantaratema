<?php
namespace Gentara\Core;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Enterprise Dependency Injection Container
 */
final class Container {
    /**
     * Menyimpan daftar binding instansi objek
     * @var array
     */
    private $bindings = array();

    /**
     * Menyimpan instansi singleton yang sudah dieksekusi
     * @var array
     */
    private $instances = array();

    /**
     * Mendaftarkan binding ke dalam container
     */
    public function bind( string $key, $resolver, bool $singleton = false ) {
        $this->bindings[$key] = array(
            'resolver'  => $resolver,
            'singleton' => $singleton,
        );
    }

    /**
     * Mendaftarkan singleton ke dalam container
     */
    public function singleton( string $key, $resolver ) {
        $this->bind( $key, $resolver, true );
    }

    /**
     * Menyelesaikan resolusi instansi objek dari container
     */
    public function make( string $key ) {
        if ( isset( $this->instances[$key] ) ) {
            return $this->instances[$key];
        }

        if ( ! isset( $this->bindings[$key] ) ) {
            if ( class_exists( $key ) ) {
                return new $key();
            }
            throw new \Exception( "Target [{$key}] tidak terdaftar di dalam Container Gentara." );
        }

        $resolver  = $this->bindings[$key]['resolver'];
        $singleton = $this->bindings[$key]['singleton'];

        if ( $resolver instanceof \Closure ) {
            $object = $resolver( $this );
        } else {
            $object = new $resolver();
        }

        if ( $singleton ) {
            $this->instances[$key] = $object;
        }

        return $object;
    }
}