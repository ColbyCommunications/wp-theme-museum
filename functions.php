<?php
/**
 * Functions.php
 *
 * Initiate the theme and provide single-purpose hooks..
 *
 * @package colbycomms/wp-theme-museum
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

if ( ! function_exists( 'pp' ) ) {
	/**
	 * Pretty-print data.
	 *
	 * @param mixed   $data Any data.
	 * @param integer $die Truthy to die.
	 */
	function pp( $data, $die = 0 ) {
		echo '<pre>';
		print_r( $data ); // phpcs:ignore
		echo '</pre>';

		if ( $die ) {
			wp_die();
		}
	}
}

if ( isset( $_GET['debug'] ) ) {
	register_shutdown_function(function() {
		print_r( error_get_last() );
	});
}

if ( file_exists( __DIR__ ) . '/vendor/autoload.php' ) {
	require_once 'vendor/autoload.php';
}
