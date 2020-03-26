<?php
/**
* Plugin Name:       Wedevs Academy
* Plugin URI:        http://www.wedevs.org
* Description:       This is a tutorial base plugin.
* Version:           1.0
* Requires at least: 5.2
* Requires PHP:      7.2
* Author:            Monir Hossain
* Author URI:        https://www.facebook.com/fencer.monir
* License:           GPL v2 or later
* License URI:       https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain:       wedevs-academy
* Domain Path:       /languages
*/

if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Require the autoload files
 */
require __DIR__ . '/vendor/autoload.php';

/**
 * Plugin Main Class
 */
final class WeDevs_Academy
{

    /**
     * Plugin version
     * 
     * @return string
     */
    const version = '1.0';

    /**
     * constructor method
     */
    private function __construct()
    {
        $this->define_constants();

        register_activation_hook( __FILE__, [$this, 'activate'] );

        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
    }

    /**
     * Initialize a singleton instance
     * 
     * @return \WeDevs_Academy
     */
    public static function init()
    {
        static $instance = false;

        if( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define constants
     */
    public function define_constants()
    {
        define( 'WD_ACADEMY_VERSION', self::version );
        define( 'WD_ACADEMY_FILE', __FILE__ );
        define( 'WD_ACADEMY_PATH', __DIR__ );
        define( 'WD_ACADEMY_URL', plugins_url('', WD_ACADEMY_FILE) );
        define( 'WP_ACADEMY_ASSETS', WD_ACADEMY_URL . '/assets' );
    }

    /**
     * Initialize the plugin
     */
    public function init_plugin()
    {
        if( is_admin() ) {
            new WeDevs\Academy\Admin();
        }

        new \WeDevs\Academy\Frontend();
    }

    /**
     * Things upon plugin activation
     */
    public function activate()
    {
        $installed = get_option( 'wd_academy_installed' );

        if( ! $installed ) {
            update_option( 'wd_academy_installed', time() );
        }
        update_option( 'wd_academy_version', WD_ACADEMY_VERSION );
    }

}

/**
 * initailizes the main plugin
 * 
 * @return \WeDevs_Academy
 */
function wedevs_academy()
{
    return WeDevs_Academy::init();
}

// kick of the pluign
wedevs_academy();
