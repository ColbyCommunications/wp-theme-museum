<?php
function embarkSearchResults( $search_term ) { ?>
	<?php

	$embarkURL = 'http://embark.colby.edu/';
	if ( trim( $search_term ) ) {
		$embarkURL .= '4DACTION/HANDLECGI/CTN3?display=por';
	}
	if ( isset( $_GET['x'] ) && isset( $_GET['obj'] ) && is_numeric($_GET['x'] ) ) {
		$args = array();
		if ( substr_count( $_GET['obj'], '?') >= 1 )  {
			$parameters = explode( '?', $_GET['obj'] );
			foreach ( $parameters as $arrayitem ) {
				if ( false !== strpos( $arrayitem, "Obj" ) ) {
					$_GET['obj'] = $arrayitem;
				}
				if ( false !== stripos( $arrayitem, "sid" ) ) {
					$_GET['sid'] = str_ireplace( 'sid=', '', $arrayitem);
				}
			}
		}
		$embarkURL = "http://embark.colby.edu/{$_GET['obj']}";
		if ( false != stripos( $_GET['obj'], '?' ) ) {
			$embarkURL .= '&';
		} else {
			$embarkURL .= '?';
		}
		$embarkURL .= "x={$_GET['x']}";
		if ( isset( $_GET['sid'] ) && is_numeric( $_GET['sid'] ) ) {
			$embarkURL .= "&sid={$_GET['sid']}";
		}
		if ( isset( $_GET['port'] ) && is_numeric( $_GET['port'] ) ) {
			$embarkURL .= "&port={$_GET['port']}";
		}
		$embarkURL = str_replace( '//P', '/P', $embarkURL);
		$embarkURL = str_replace( '//O', '/O', $embarkURL);
		$response = wp_remote_get( $embarkURL );
		if ( isset( $_GET['debug'] ) ) {
			pp( $embarkURL );
			pp( $response, 1 );
		}
	} else {
		if ( isset( $_GET['obj'] ) ) {
			$embarkURL = "http://embark.colby.edu/{$_GET['obj']}";
			if ( isset( $_GET['sid'] ) && is_numeric( $_GET['sid'] ) ) {
				$embarkURL .= "&sid={$_GET['sid']}";
			}

			$response = wp_remote_get( $embarkURL );
		} else {
			// Submit search query via POST.
			$args = [
				'body' => [
					'searchType' => 'all',
					'WholeWord' => '0',
					'RefineSearch' => 'WithinCurrent',
					'theKW' => $search_term,
				]
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
	  		'</a> &bull; <a' => '</a> | <a'
		];
		$response_body = str_replace( array_keys( $replacements ), array_values( $replacements ), $response['body'] );
		$response_body = str_replace( '/academics_cs/museum/search/', "?obj=", $response_body );
	  	echo str_replace( 'its-embark.colby.edu', 'embark.colby.edu', $response_body );
		// If no results, automatically select the 'Museum website search results' tab.
	} catch ( Exception $ex ) {
		echo 'Unable to connect to EmbARK search server.';
	}
}

add_action( 'init', function() {
	add_shortcode( 'embark-search', function ( $atts ) {
		$cq = isset( $_GET['cq'] ) ? sanitize_text_field( $_GET['cq'] ) : '';

		if ( ! $cq ) {
			$_GET['obj'] = isset( $_GET['obj'] ) ? $_GET['obj'] : 'Prt1410';
		}

		ob_start(); ?>
		<div class=collection-container>
			<?php /* <form class=collection__search-form>
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
			<?php endif; */ ?>

			<?php embarkSearchResults( $cq ?: 'lunder'  ); ?>
		</div>

		<?php
		$html = ob_get_clean();

		if ( $cq ) {
			$html = str_replace( '&sid=', "&cq=$cq&sid=", $html );
		}

		return preg_replace("/<script.*?\/script>/s", "", $html) ?: $html;
	} );
} );
