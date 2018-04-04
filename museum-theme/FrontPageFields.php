<?php
/**
 * FrontPageFields.php
 *
 * @package colbycomms/wp-theme-museum
 */

namespace ColbyComms\MuseumTheme;

use Carbon_Fields\Helper\Helper;
use Carbon_Fields\{Container, Field};

/**
 * Sets up an options page using Carbon Fields.
 */
class FrontPageFields {
    const PANELS_KEY = 'page_panels';
    const CONTENT_KEY = 'content';
    const IMAGE_KEY = 'image';
    const CSS_CLASS_KEY = 'css_class';

	/**
	 * Adds hooks.
	 */
	public function __construct() {
		add_action( 'after_setup_theme', [ 'Carbon_Fields\\Carbon_Fields', 'boot' ] );
		add_action( 'carbon_fields_register_fields', [ $this, 'create_container' ] );
		add_action( 'carbon_fields_register_fields', [ $this, 'add_fields' ] );
	}

	/**
	 * Creates the options page.
	 */
	public function create_container() {
        $this->container = Container::make( 'post_meta', 'Panels' )
            ->where( 'post_template', '=', 'page-panels.php' );
    }

    public static function get_panel_fields() {
        return [
            Field::make( 'rich_text', self::CONTENT_KEY, 'Content' ),
            Field::make( 'image', self::IMAGE_KEY, 'Background Image' ),
            Field::make( 'text', self::CSS_CLASS_KEY, 'Extra CSS class' )
        ];
    }
    
    public static function get_fields() {
        return [
            Field::make( 'complex', self::PANELS_KEY, 'Sections' )
                ->add_fields( self::get_panel_fields() ),
        ];
    }

	/**
	 * Adds the theme options.
	 */
	public function add_fields() {
		$this->container->add_fields( self::get_fields() );
	}

	/**
	 * Gets an option value.
	 *
	 * @param string $key The option key.
	 * @return mixed The value.
	 */
	public static function get( string $key, $post_id = null ) {
        $post_id = empty( $post_id ) ? get_the_id() : $post_id;

		return Helper::get_post_meta( $post_id, $key );
	}
}
