<?php

namespace Books\Plugin\Admin;

use WP_Post;

/**
 * Class AddBooksPost
 *
 * This class handles the creation and management of the custom post type 'Book' in WordPress.
 */
class AddBooksPost{

    /**
     * Constructor method.
     *
     * Initializes the class by setting up WordPress hooks.
     */
    function __construct(){
        add_action('init', [ $this, 'books_plugin_init' ] );
        add_action('add_meta_boxes', [ $this, 'books_add_meta_boxes' ] );
        add_action('save_post', [ $this, 'books_save_meta_boxes' ] );
    }

    /**
     * Initialize the 'Book' custom post type.
     *
     * Sets up labels and arguments for the custom post type and registers it.
     */
    public function books_plugin_init() {
        $labels = array(
            'name' => __('Books'),
            'singular_name' => __('Book'),
            'add_new' => __('Add New Book'),
            'add_new_item' => __('Add New Book'),
            'edit_item' => __('Edit Book'),
            'new_item' => __('New Book'),
            'all_items' => __('All Books'),
            'view_item' => __('View Book'),
            'search_items' => __('Search Books'),
            'not_found' => __('No books found'),
            'not_found_in_trash' => __('No books found in Trash'),
            'menu_name' => __('Books')
        );
        $args = array(
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail'),
            'menu_position' => 5,
            'rewrite' => array('slug' => 'books'),
        );

        register_post_type('book', $args);
    }

    /**
     * Save meta box data.
     *
     * Handles the saving of custom meta box data for the 'Book' post type.
     *
     * @param int $post_id The ID of the current post being saved.
     */
    public function books_save_meta_boxes($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if ( !isset( $_POST['book_author'] ) || !isset($_POST['book_published_date']) || !isset($_POST['book_genre'])) return;

        update_post_meta($post_id, '_book_author', sanitize_text_field($_POST['book_author']));
        update_post_meta($post_id, '_book_published_date', sanitize_text_field($_POST['book_published_date']));
        update_post_meta($post_id, '_book_genre', sanitize_text_field($_POST['book_genre']));
    }

    /**
     * Add meta boxes.
     *
     * Registers custom meta boxes for the 'Book' post type.
     */
    public function books_add_meta_boxes() {
        add_meta_box('book_author', 'Author', [ $this, 'book_author_callback' ], 'book', 'side');
        add_meta_box('book_published_date', 'Published Date', [ $this, 'book_published_date_callback' ], 'book', 'side');
        add_meta_box('book_genre', 'Genre', [ $this, 'book_genre_callback' ], 'book', 'side');
    }

    /**
     * Author meta box callback.
     *
     * Displays the input field for the 'Author' meta box.
     *
     * @param WP_Post $post The current post object.
     */
    public function book_author_callback($post) {
        $value = get_post_meta($post->ID, '_book_author', true);
        echo '<input type="text" name="book_author" value="' . esc_attr($value) . '" class="widefat" />';
    }

    /**
     * Published Date meta box callback.
     *
     * Displays the input field for the 'Published Date' meta box.
     *
     * @param WP_Post $post The current post object.
     */
    public function book_published_date_callback($post) {
        $value = get_post_meta($post->ID, '_book_published_date', true);
        echo '<input type="date" name="book_published_date" value="' . esc_attr($value) . '" class="widefat" />';
    }

    /**
     * Genre meta box callback.
     *
     * Displays the select dropdown for the 'Genre' meta box.
     *
     * @param WP_Post $post The current post object.
     */
    public function book_genre_callback($post) {
        $value = get_post_meta($post->ID, '_book_genre', true);
        $options = array('Fiction', 'Non-Fiction', 'Mystery', 'Sci-Fi', 'Biography');
        echo '<select name="book_genre" class="widefat">';
        foreach ($options as $option) {
            echo '<option value="' . $option . '" ' . selected($value, $option, false) . '>' . $option . '</option>';
        }
        echo '</select>';
    }

}