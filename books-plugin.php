<?php
/**
 * Plugin Name: Books Plugin
 * Description: A Custom Post Type Books plugin Develop
 * Plugin URI: https://sjrubel10.com
 * Author: Md Rubel Mia
 * Author URI: https://sjrubel10.com
 * Version: 1.0
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: books-plugin
 */

use Books\Plugin\Admin\Enque;
use Books\Plugin\Api;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';
new Api();
/**
 * The main plugin class
 */
final class Books {

    /**
     * Plugin version
     *
     * @var string
     */
    const version = '1.0';

    /**
     * Class construcotr
     */
    private function __construct() {
        $this->define_constants();
        register_activation_hook( __FILE__, [ $this, 'activate' ] );
        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );

    }

    /**
     * Initializes a singleton instance
     *
     * @return \Books
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define the required plugin constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'WD_Books_VERSION', self::version );
        define( 'WD_Books_FILE', __FILE__ );
        define( 'WD_Books_PATH', __DIR__ );
        define( 'WD_Books_URL', plugins_url( '', WD_Books_FILE ) );
        define( 'WD_Books_ASSETS', WD_Books_URL . '/assets' );
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin() {
        if ( is_admin() ) {
            new Books\Plugin\Admin();
        } else {
            new Books\Plugin\Frontend();
        }
        new Enque();
    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate() {
        $installed = get_option( 'wd_books_plugin' );
        if ( ! $installed ) {
            update_option( 'wd_books_plugin', time() );
        }

        update_option( 'wd_books_plugin', WD_Books_VERSION );
    }
}

/**
 * Initializes the main plugin
 *
 * @return \Books
 */
function books_plugin_init() {
    return Books::init();
}

// kick-off the plugin
books_plugin_init();
