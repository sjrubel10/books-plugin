<?php

namespace Books\Plugin\API;

use WP_Error;
use WP_Query;
use WP_REST_Controller;
use WP_REST_Response;
use WP_REST_Server;

class BooksListsApi extends WP_REST_Controller{
    public function __construct() {
        $this->namespace = 'books/v1';
        $this->rest_base = 'list';
    }

    public function register_routes() {
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base,
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array( $this, 'get_book_lists' ),
                'permission_callback' => function() {
                    return current_user_can( 'read' ); // Adjust the capability as needed
                },
                'args'                => $this->get_collection_params(),
            )
        );
    }

    public function get_book_lists( $request ){
        $search_term = sanitize_text_field($request->get_param('search_term'));
        $nonce = $request->get_header('X-WP-Nonce');

        if ( !wp_verify_nonce( $nonce, 'wp_rest' ) ) {
            return new WP_Error('invalid_nonce', __('Invalid nonce.', 'review-master'), array('status' => 403));
        }
        $args = array(
            'post_type' => 'books',
            'posts_per_page' => -1,
        );
        $query = new WP_Query($args);
        $books = array();

        if ($query->have_posts()) {
            while ($query->have_posts()) : $query->the_post();
                $books[] = array(
                    'title' => get_the_title(),
                    'author' => get_post_meta(get_the_ID(), '_book_author', true),
                    'published_date' => get_post_meta(get_the_ID(), '_book_published_date', true),
                );
            endwhile;
            wp_reset_postdata();
        }

        return new WP_REST_Response( $books, 200 );
    }

}