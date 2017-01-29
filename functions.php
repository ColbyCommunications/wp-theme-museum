<?php

global $lunder_institute;

require_once( 'vendor/autoload.php' );

$lunder_institute = new Colby_College\Wp_Components\Colby_Wp_Theme();

add_action( 'pre_get_posts', function( $query ) {
	if ( is_home() && $query->is_main_query() ) {
		$query->set( 'category__not_in', [ get_cat_ID( 'Media Kit' ) ] );
	}
} );
