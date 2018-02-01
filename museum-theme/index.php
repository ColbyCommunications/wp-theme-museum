<?php
/**
 * Theme entry point.
 *
 * @package colbycomms/wp-theme-museum
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

if ( ! defined( 'PROD' ) ) {
	define( 'PROD', true );
}

require 'rest-filters.php';
new ColbyComms\MuseumTheme\MuseumTheme();
