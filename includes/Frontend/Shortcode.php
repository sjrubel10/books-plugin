<?php

namespace Books\Plugin\Frontend;

use WP_Query;

/**
 * Shortcode handler class
 */
class Shortcode {

    /**
     * Initializes the class
     */
    function __construct() {
        add_shortcode( 'display_books', [ $this, 'display_books_shortcode' ] );
    }

    /**
     * Shortcode handler function
     *
     * @param  array $atts
     *
     * @return string
     */
    public function display_books_shortcode( $atts ) {
        $books_per_page = get_option('books_per_page');
        $books_per_page = $books_per_page > 1 ? $books_per_page : 10;

        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        $args = array(
            'post_type' => 'book',
            'posts_per_page' => $books_per_page,
            'paged' => $paged,
        );

        // Initialize WP_Query
        $query = new WP_Query($args);

        // Start output
        $output = '';

        if ($query->have_posts()) {
            $output .= '<div class="books-list">';
            while ($query->have_posts()) {
                $query->the_post();
                $author = get_post_meta(get_the_ID(), '_book_author', true);
                $published_date = get_post_meta(get_the_ID(), '_book_published_date', true);
                $genre = get_post_meta(get_the_ID(), '_book_genre', true);
                $thumbnail = get_the_post_thumbnail(get_the_ID(), 'thumbnail', array('class' => 'book-thumbnail'));

                $output .= '<div class="book-item">';
                $output .= '<div class="book-thumbnail">' . $thumbnail . '</div>';
                $output .= '<h2>' . get_the_title() . '</h2>';
                $output .= '<p><strong>Author:</strong> ' . esc_html($author) . '</p>';
                $output .= '<p><strong>Published Date:</strong> ' . esc_html($published_date) . '</p>';
                $output .= '<p><strong>Genre:</strong> ' . esc_html($genre) . '</p>';
                $output .= '<div class="book-content">' . get_the_content() . '</div>';
                $output .= '</div>';
            }
            $output .= '</div>';

            // Pagination links
            $output .= '<div class="pagination">';
            $output .= paginate_links(array(
                'total' => $query->max_num_pages,
                'current' => max(1, $paged),
                'prev_text' => __('&laquo; Previous'),
                'next_text' => __('Next &raquo;'),
            ));
            $output .= '</div>';

            wp_reset_postdata();
        } else {
            $output = '<p>No books found.</p>';
        }

        return $output;
    }
}

