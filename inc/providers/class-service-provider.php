<?php
namespace Gentara\Core;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Abstract Service Provider
 */
abstract class ServiceProvider {
    /**
     * Referensi ke kontainer aplikasi
     * @var Container
     */
    protected $container;

    /**
     * Konstruktor Provider
     */
    public function __construct( Container $container ) {
        $this->container = $container;
    }

    /**
     * Mendaftarkan fungsionalitas/binding ke dalam container
     */
    abstract public function register();

    /**
     * Mengeksekusi fungsionalitas setelah semua modul terdaftar
     */
    abstract public function boot();
}