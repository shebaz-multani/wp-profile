<?php

/**
 * Plugin Name: WP Profile
 * Description: Add functionality to manage profiles and add [wp-profiles] shortcode to list, search & filter in profiles on frontend
 * Version:           1.0.0
 * Author:            Shebaz Multani
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-profile
 */

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Currently plugin version.
 */
define( 'WP_PROFILE_VERSION', '1.0.0' );

/**
 * Main Class
 */
class WPProfile 
{
    
    function __construct()
    {   
        //Include wp profile cpt class
        require_once plugin_dir_path( __FILE__ ) . '/includes/wp-profile-cpt.php';
        new WPProfileCPT();

        //Include wp profile shortcode class
        require_once plugin_dir_path( __FILE__ ) . '/includes/wp-profile-shortcode.php';
        new WPProfileShortcode();

    }


    /**
     * The code that runs during plugin activation.
     */
    public static function activate()
    {

    }

    /**
     * The code that runs during plugin deactivation.
     */
    public static function deactivate()
    {
        
    }

}


function activate_wp_profiles() {
    WPProfile::activate();
}

function deactivate_wp_profiles() {
    WPProfile::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_profiles' );
register_deactivation_hook( __FILE__, 'deactivate_wp_profiles' );

/**
 * Begins execution of the plugin.
 */
function WPProfileInit() {
    //Init
    new WPProfile();
}

WPProfileInit();