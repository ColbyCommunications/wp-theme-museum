<?php
/**
 * Plugin Name: Lunder Institute
 *
 * Description:
 * Version: 0.0.1
 * Author: Colby College
 * Text Domain: lunder-institute
 *
 * @package lunder-institute
 */

global $lunder_institute;

// Run autoloader and autoload classes.
require_once( 'vendor/autoload.php' );

require( 'class-colby-wp-theme.php' );

$lunder_institute = new Colby_Wp_Theme();
