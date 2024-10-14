<?php
/*
 * Plugin Name:       pkgs.fun
 * Plugin URI:        https://pkgs.fun/wordpress/plugins/pkgs/
 * Description:       Offload WordPress themes and plugins to pkgs.fun
 * Version:           1.0.0
 * Requires at least: 2.9.0
 * Tested up to:      6.6.2
 * Requires PHP:      5.0
 * Author:            pkgs.fun
 * Author URI:        https://pkgs.fun/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

function pkgs_fun_wp_api( $_default, $args, $url ) {
	$urls = array(
		// plugins
		'api.wordpress.org/plugins/info',
		'api.wordpress.org/plugins/update-check',

		// themes
		'api.wordpress.org/themes/info',
		'api.wordpress.org/themes/update-check'
	);

	$intercepted = false;
	foreach ( $urls as $u ) {
		if ( strpos( $url, $u ) !== false ) {
			$intercepted = str_replace( 'api.wordpress.org/', 'pkgs.fun/api/wp/', $url );
			break;
		}
	}

	// if not intercepted, return the default
	if ( ! $intercepted ) {
		return $_default;
	}

	return wp_remote_request( $intercepted, $args );
}

add_filter( 'pre_http_request', 'pkgs_fun_wp_api', 10, 3 );
