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
    
    echo "<style type='text/css'>$extra_css</style>";
}, 10 );

add_shortcode( 'lunder-logo-svg', function() {
    ob_start();
    echo '<div class=liaa-logo-container>';
    include 'lunder-institute-aa.svg';
    echo '</div>';
    return ob_get_clean();
} );

add_filter( 'typekit_embed', function( $content ) {
    return '
<script src="https://use.typekit.net/gty7fbd.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>
    ';

} );
