<?php

namespace Books\Plugin\Admin;

/**
 * The Menu handler class
 */
class Menu {

    /**
     * Initialize the class
     */
    function __construct() {
        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
//        add_action('admin_init', [ $this, 'books_settings_init' ] );
    }

    /**
     * Register admin menu
     *
     * @return void
     */
    public function admin_menu() {
        add_options_page(__( 'Books Settings', 'books-plugin' ), __( 'Books Settings', 'books-plugin' ), 'manage_options', 'books-settings', [ $this, 'books_settings_page' ] );
    }

    /**
     * Render the plugin page
     *
     * @return void
     */
    public function books_settings_page() {

        require_once plugin_dir_path( __FILE__ ) . 'templates/books_Settings.php';
    }

}
