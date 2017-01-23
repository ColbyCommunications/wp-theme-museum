<?php

global $lunder_institute;

// Run autoloader and autoload classes.
require_once( 'vendor/autoload.php' );

require( 'class-colby-wp-theme.php' );

$lunder_institute = new Colby_Wp_Theme();

add_action( 'wp_head', function() {
    if ( ! is_singular() ) {
        return;
    }


    $extra_css = get_post_meta( get_the_id(), 'extra_css', true );

    if ( ! $extra_css ) {
        return;
    }

    echo "<style>$extra_css</style>";
} );
