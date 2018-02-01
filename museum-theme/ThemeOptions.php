<?php
/**
 * ThemeOptions.php
 *
 * @package colbycomms/wp-theme-twentyeighteen
 */

namespace ColbyComms\MuseumTheme;

use Carbon_Fields\Helper\Helper;
use Carbon_Fields\{Container, Field};

/**
 * Sets up an options page using Carbon Fields.
 */
class ThemeOptions {
	const ANALYTICS_KEY = 'analytics_code';

	/**
	 * Adds hooks.
	 */
	public function __construct() {
		add_action( 'after_setup_theme', [ 'Carbon_Fields\\Carbon_Fields', 'boot' ] );
		add_action( 'carbon_fields_register_fields', [ $this, 'create_container' ] );
		add_action( 'carbon_fields_register_fields', [ $this, 'add_plugin_options' ] );
	}

	/**
	 * Creates the options page.
	 */
	public function create_container() {
		$this->container = Container::make( 'theme_options', 'Theme Options' );
	}

	/**
	 * Adds the plugin options.
	 */
	public function add_plugin_options() {
		$this->container->add_fields(
			[
				Field::make( 'textarea', self::ANALYTICS_KEY, 'Google Analytics code' )
					->set_help_text( 'Place this site\'s Analytics embed code in this box.' ),
			]
		);
	}

	/**
	 * Gets an option value.
	 *
	 * @param string $key The option key.
	 * @return mixed The value.
	 */
	public static function get( string $key ) {
		return Helper::get_theme_option( $key );
	}
}
