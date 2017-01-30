<?php
/**
 * Embark-search.php
 *
 * Shortcode for displaying assets in the embark server.
 *
 * @package lunder-institute
 */

/**
 * Function by last web developer.
 *
 * @param string $search_term The current search term.
 */
function embark_search_results( $search_term ) {
	?>
	<?php

	$embark_url = 'http://embark.colby.edu/';
	if ( trim( $search_term ) ) {
		$embark_url .= '4DACTION/HANDLECGI/CTN3?display=por';
	}
	if ( isset( $_GET['x'] ) && isset( $_GET['obj'] ) && is_numeric( $_GET['x'] ) ) {
		$args = array();
		if ( substr_count( $_GET['obj'], '?' ) >= 1 ) {
			$parameters = explode( '?', $_GET['obj'] );
			foreach ( $parameters as $arrayitem ) {
				if ( false !== strpos( $arrayitem, 'Obj' ) ) {
					$_GET['obj'] = $arrayitem;
				}
				if ( false !== stripos( $arrayitem, 'sid' ) ) {
					$_GET['sid'] = str_ireplace( 'sid=', '', $arrayitem );
				}
			}
		}
		$embark_url = "http://embark.colby.edu/{$_GET['obj']}";
		if ( false !== stripos( $_GET['obj'], '?' ) ) {
			$embark_url .= '&';
		} else {
			$embark_url .= '?';
		}

		$embark_url .= "x={$_GET['x']}";
		if ( isset( $_GET['sid'] ) && is_numeric( $_GET['sid'] ) ) {
			$embark_url .= "&sid={$_GET['sid']}";
		}
		if ( isset( $_GET['port'] ) && is_numeric( $_GET['port'] ) ) {
			$embark_url .= "&port={$_GET['port']}";
		}
		$embark_url = str_replace( '//P', '/P', $embark_url );
		$embark_url = str_replace( '//O', '/O', $embark_url );
		$response = wp_remote_get( $embark_url );
		if ( isset( $_GET['debug'] ) ) {
			pp( $embark_url );
			pp( $response, 1 );
		}
	} else {
		if ( isset( $_GET['obj'] ) ) {
			$embark_url = "http://embark.colby.edu/{$_GET['obj']}";
			if ( isset( $_GET['sid'] ) && is_numeric( $_GET['sid'] ) ) {
				$embark_url .= "&sid={$_GET['sid']}";
			}

			$response = wp_remote_get( $embark_url );
		} else {
			// Submit search query via POST.
			$args = [
				'body' => [
					'searchType' => 'all',
					'WholeWord' => '0',
					'RefineSearch' => 'WithinCurrent',
					'theKW' => $search_term,
				],
			];
			$response = wp_remote_post( $args );
		}
	}
	try {
		$replacements = [
			'/academics_cs/museum/images/' => '/wp-content/themes/colbymuseum/images/',
	  		'BACK TO SINGLE OBJECT VIEW' => '< Back to Single Object View',
		  		'SINGLE OBJECT' => 'Single Object',
		  		'THUMBNAILS' => 'Thumbnails',
		  		'LIST VIEW' => 'List View',
		  		'BACK TO TOP' => 'Back to Top &uarr;',
		  		'ENLARGE/ZOOM IMAGE' => 'Enlarge/Zoom Image',
		  		'BACKGROUND:' => 'Background:',
		  		'ENLARGE/ZOOM IMAGE' => 'Enlarge/Zoom Image',
	  		'LIGHT' => 'Light',
	  		'MEDIUM' => 'Medium',
	  		'DARK' => 'Dark',
	  		'</a> &bull; <a' => '</a> | <a',
		];
		$response_body = str_replace( array_keys( $replacements ), array_values( $replacements ), $response['body'] );
		$response_body = str_replace( '/academics_cs/museum/search/', '?obj=', $response_body );
	  	echo str_replace( 'its-embark.colby.edu', 'embark.colby.edu', $response_body );
		// If no results, automatically select the 'Museum website search results' tab.
	} catch ( Exception $ex ) {
		echo 'Unable to connect to EmbARK search server.';
	}
}
/** End function by last web developer. */

add_action( 'init', function() {
	add_shortcode( 'embark-search', function ( $atts ) {
		$cq = isset( $_GET['cq'] ) ? sanitize_text_field( $_GET['cq'] ) : '';

		if ( ! $cq ) {
			$_GET['obj'] = isset( $_GET['obj'] ) ? $_GET['obj'] : 'Prt1410';
		}

		ob_start(); ?>
		<div class=collection-container>
			<?php

			/*
			<form class=collection__search-form>
				<input
					name=cq
					type=text
					placeholder="Search the collection"
					value="<?php echo isset( $_GET['cq'] ) ? $_GET['cq'] : ''; ?>"
					/>
			</form>
			<?php if ( $cq ) : ?>
			<a class=collection__reset-link href=<?php bloginfo( 'url' ); ?>/collection>
				Reset
			</a>
			<?php endif;
			*/ ?>

			<?php embark_search_results( $cq ?: 'lunder' ); ?>
		</div>

		<?php
		$html = ob_get_clean();

		if ( $cq ) {
			$html = str_replace( '&sid=', "&cq=$cq&sid=", $html );
		}

		return preg_replace( '/<script.*?\/script>/s', '', $html ) ?: $html;
	} );
} );
