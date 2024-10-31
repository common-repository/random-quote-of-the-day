<?php
/**
 *
 * @wordpress-plugin
 * Plugin Name:       Random Daily Quote
 * Plugin URI:        http://www.curatedquotes.com
 * Description:       Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Version:           1.0.0
 * Author:            Curated Quotes
 * Author URI:        http://www.curatedquotes.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

require_once( plugin_dir_path( __FILE__ ) . '/includes/class-curatedquotes.php' );
require_once( plugin_dir_path( __FILE__ ) . '/includes/widget-curatedquotes.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 *
 */
register_activation_hook( __FILE__, array( 'Curated_Quotes', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Curated_Quotes', 'deactivate' ) );

add_action( 'plugins_loaded', array( 'Curated_Quotes', 'get_instance' ) );


/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'includes/class-curatedquotes-admin.php' );
	add_action( 'plugins_loaded', array( 'Curated_Quotes_Admin', 'get_instance' ) );

}


