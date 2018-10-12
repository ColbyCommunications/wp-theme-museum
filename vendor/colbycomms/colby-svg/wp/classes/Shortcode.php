<?php
/**
 * Handles the [colby-svg] shortcode.
 *
 * @package colbycomms/colby-svg
 */

namespace ColbyComms\SVG;

use ColbyComms\SVG\SVG;

/**
 * Shortcode [colby-svg name="example"].
 */
class Shortcode {
	/**
	 * Hooks the add_shortcode function to init.
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'add_shortcode' ] );
	}

	/**
	 * Adds the shortcode.
	 */
	public function add_shortcode() {
		if ( ! shortcode_exists( 'colby-svg' ) ) {
			add_shortcode( 'colby-svg', [ $this, 'render_shortcode' ] );
		}
	}

	/**
	 * Renders the shortcode output.
	 *
	 * @param array $atts The shortcode attributes.
	 * @return string The shortcode output.
	 */
	public function render_shortcode( array $atts = [] ) {
		if ( ! isset( $atts['name'] ) ) {
			return '';
		}

		return str_replace( ["\n", "\r"], '', SVG::get( $atts['name'] ) );
	}
}
