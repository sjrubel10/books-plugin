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
        add_action('admin_init', [ $this, 'books_settings_init' ] );
    }

    /**
     * Register admin menu
     *
     * @return void
     */
    public function admin_menu() {
//        add_menu_page( __( 'Books Settings', 'books-plugin' ), __( 'Books Settings', 'books-plugin' ), 'manage_options', 'books-settings', [ $this, 'books_settings_page' ], 'dashicons-welcome-learn-more' );
        add_options_page(__( 'Books Settings', 'books-plugin' ), __( 'Books Settings', 'books-plugin' ), 'manage_options', 'books-settings', [ $this, 'books_settings_page' ] );

    }

    /**
     * Render the plugin page
     *
     * @return void
     */
    public function books_settings_page() {
        ?>
        <div class="wrap">
            <h1>Books Settings</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('books_settings');     // Output nonce, action, and option_page fields
                do_settings_sections('books-settings'); // Output settings sections
                submit_button('Save Settings');        // Output save settings button
                ?>
            </form>
        </div>
        <?php
    }

    public function books_settings_init() {
        register_setting(
            'books_settings',      // Option group
            'books_per_page',      // Option name
            [ $this, 'sanitize_books_per_page'] // Sanitization callback
        );

        add_settings_section(
            'books_settings_section', // ID of the section
            'Books Per Page Settings', // Title of the section
            [ $this, 'books_settings_section_callback'], // Callback to display content
            'books-settings' // Page to add section to
        );

        add_settings_field(
            'books_per_page_field', // ID of the field
            'Books Per Page', // Label
            [ $this, 'books_per_page_field_callback'], // Callback to display field
            'books-settings', // Page to add field to
            'books_settings_section' // Section to add field to
        );
    }

    public function books_settings_section_callback() {
        echo '<p>Set the number of books displayed per page for the [display_books] shortcode.</p>';
    }

    public function books_per_page_field_callback() {
        $books_per_page = get_option('books_per_page', 10); // Default to 10 if not set
        echo '<input type="number" name="books_per_page" value="' . esc_attr($books_per_page) . '" min="1" />';
    }

    public function sanitize_books_per_page( $input ) {
        $sanitized_value = absint($input); // Ensure input is a positive integer
        return ($sanitized_value >= 1) ? $sanitized_value : 10; // Default to 10 if validation fails
    }

}
