<?php

namespace Books\Plugin;

use Books\Plugin\API\BooksListsApi;

class Api
{
    function __construct(){
        add_action( 'rest_api_init', [$this, 'register_api']);
    }

    public function register_api(){
        $book_lists = new BooksListsApi();
        $book_lists->register_routes();
    }
}