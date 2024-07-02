<?php

namespace Books\Plugin\Admin;

class Enque
{
    function __construct(){
        $this->init_hooks();
    }

    public function init_hooks(){
        add_action( 'init', array( $this, 'register_styles' ) );

//        add_action( 'admin_enqueue_scripts', [ $this, 'books_admin_enqueue_scripts' ] );
    }

    function books_admin_enqueue_scripts() {
        wp_localize_script('jobplace-script', 'myVars', array(
            'rest_nonce'           => wp_create_nonce( 'wp_rest' ),
            'site_url'           => get_site_url().'/',
        ));
    }

    public function register_styles() {
        wp_enqueue_style('bookstemplate', WD_Books_ASSETS.'/css/bookstemplate.css', array(), WD_Books_VERSION, 'all' );
    }

}