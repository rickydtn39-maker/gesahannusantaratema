<?php
/**
 * Deklarasi Action dan Filter Hooks API Tema (GDS Volume 7)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function ges_before_header() {
    do_action( 'gesahan_before_header' );
}

function ges_after_header() {
    do_action( 'gesahan_after_header' );
}

function ges_before_footer() {
    do_action( 'gesahan_before_footer' );
}

function ges_after_footer() {
    do_action( 'gesahan_after_footer' );
}