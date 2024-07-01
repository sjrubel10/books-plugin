<?php

namespace Books\Plugin\Admin;

class Enque
{
    function __construct(){
        $this->init_hooks();
    }

    public function init_hooks(){
        add_action( 'admin_enqueue_scripts', [$this,'include_all_files'] );
    }

    public function include_css_files(){
        wp_enqueue_style('bookstemplate', WD_Books_ASSETS . '/css/bookstemplate.css', array(), WD_Books_VERSION );
    }

    public function include_js_files(){
    }

    public function include_all_files(){
        $this->include_css_files();
//        $this->include_js_files();
    }

}