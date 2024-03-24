<?php

/**
 * Plugin Name: WP Site Maintenance
 * Description: Toggle maintenance mode and customize the maintenance screen.
 * Version: 0.1.1
 * Author: Davide Milani
 * Author URI: https://www.milanidavide.com/
 * License: BSD-3-Clause license
 * License URI: https://opensource.org/licenses/BSD-3-Clause
 * Text Domain: wp-site-maintenance
 * Domain Path: /languages
 * Update URI: false
 *
 * @package WP Site Maintenance
 */

/**
 * Handles maintenance mode for the WordPress site.
 */
function wpsitemaint_handle_maintenance_mode() {
	if (
		defined( 'WPSITEMAINT_IN_MAINTENANCE' )
		&& WPSITEMAINT_IN_MAINTENANCE
		&& ! current_user_can( 'administrator' )
		&& 'wp-login.php' !== $GLOBALS['pagenow']
	) {
		$protocol = wp_get_server_protocol();
		header( "$protocol 503 Service Unavailable", true, 503 );
		header( 'Content-Type: text/html; charset=utf-8' );
		header( 'Retry-After: 60' );

		if ( file_exists( WP_CONTENT_DIR . '/maintenance.php' ) ) {
			require_once WP_CONTENT_DIR . '/maintenance.php';
		}

		die();
	}
}
add_action( 'wp_loaded', 'wpsitemaint_handle_maintenance_mode' );
