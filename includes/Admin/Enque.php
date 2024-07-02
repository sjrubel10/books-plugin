<?php

namespace Books\Plugin\Admin;

class Enque
{
    function __construct(){
        $this->init_hooks();
    }

    public function init_hooks(){
        add_action( 'init', array( $this, 'register_styles' ) );
        add_action( 'admin_enqueue_scripts', [ $this, 'books_plugin_admin_enqueue_scripts' ] );
    }

    function books_plugin_admin_enqueue_scripts() {
        wp_enqueue_script( 'books-plugin-script', WD_Books_ASSETS . '/js/index.js', array( 'wp-element' ), WD_Books_VERSION, true );
        wp_localize_script('books-plugin-script', 'myBooksVars', array(
            'rest_nonce'           => wp_create_nonce( 'wp_rest' ),
            'site_url'           => get_site_url().'/',
        ));
    }
    public function register_styles() {
        wp_enqueue_style('bookstemplate', WD_Books_ASSETS.'/css/bookstemplate.css', array(), WD_Books_VERSION, 'all' );
    }

}