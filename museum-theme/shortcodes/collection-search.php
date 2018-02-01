<?php
/**
 * Handles the [collection-search] shortcode.
 *
 * @package colbycomms/wp-theme-museum
 */

/**
 * The shortcode callback.
 *
 * @return string HTML
 */
function collection_search_shortcode() {
	return '<div id=collection-search class=collection-search-container></div>';
}

add_shortcode( 'collection-search', 'collection_search_shortcode' );
