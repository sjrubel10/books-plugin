<?php

namespace Books\Plugin\Admin;

class Enque
{
    function __construct(){
        $this->init_hooks();
    }

    public function init_hooks(){
        add_action( 'init', array( $this, 'register_styles' ) );
    }

    public function register_styles() {
        wp_enqueue_style('bookstemplate', WD_Books_ASSETS.'/css/bookstemplate.css', array(), WD_Books_VERSION, 'all' );
    }

}