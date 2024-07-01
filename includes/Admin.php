<?php

namespace Books\Plugin;

use Books\Plugin\Admin\AddBooksPost;
use Books\Plugin\Admin\Enque;
use Books\Plugin\Admin\Menu;

/**
 * The admin class
 */
class Admin {

    /**
     * Initialize the class
     */
    function __construct() {
        new Menu();
        new AddBooksPost();
        new Enque();
    }
}
