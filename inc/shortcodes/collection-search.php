<?php

function collection_search_shortcode( $atts ) {
	?><div id=collection-search class=collection-search-container></div><?php
}

add_action( 'init', function() {
	add_shortcode( 'collection-search', 'collection_search_shortcode' );
} );
