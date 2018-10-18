<?php
/**
 * MuseumTheme.php
 *
 * @package colbycomms/wp-theme-museum
 */

namespace ColbyComms\MuseumTheme;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Main theme class.
 */
class MuseumTheme {
	/**
	 * Theme version.
	 *
	 * @var string
	 */
	const VERSION = '1.0.2';

	/**
	 * Text domain.
	 *
	 * @var string
	 */
	const TEXT_DOMAIN = 'colbycomms-wp-theme-museum';

	/**
	 * Filter prefix.
	 *
	 * @var string
	 */
	const FILTER_PREFIX = 'colbycomms__wp_theme_museum__';

	/**
	 * Templates where users can't richedit.
	 *
	 * @var array
	 */
	const USER_CANT_RICHEDIT = [
		'page-blanco.php',
	];

	/**
	 * Query vars to add.
	 *
	 * @var array
	 */
	const QUERY_VARS = [
		'source',
		'refresh_embark',
	];

	/**
	 * Post Types to register.
	 *
	 * @var array
	 */
	const POST_TYPES = [
		'collection' => [
			'labels' => [
				'name' => 'Collection Items',
				'singular_name' => 'Collection Item',
			],
			'public' => false,
			'exclude_from_search' => false,
			'publicly_queryable' => true,
			'supports' => [ 'title', 'editor', 'excerpt', 'thumbnail' ],
			'show_in_rest' => true,
		],
	];

	/**
	 * Theme setup.
	 */
	public function __construct() {
		include 'shortcodes/collection-search.php';
		include 'shortcodes/media-kit.php';

		new ThemeOptions();
		new FrontPageFields();

		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );
		add_theme_support( 'html5' );

		add_action( 'wp_enqueue_scripts', [ __CLASS__, 'enqueue_scripts_and_styles' ] );
		add_action( 'wp_enqueue_scripts', [ __CLASS__, 'localize_scripts' ] );
		add_action( 'pre_get_posts', [ __CLASS__, 'exclude_media_kit_from_posts' ] );
		add_action( 'user_can_richedit', [ __CLASS__, 'maybe_turn_off_visual_editor' ] );
		add_filter( 'query_vars', [ __CLASS__, 'add_query_var' ] );
		add_action( 'pre_get_posts', [ __CLASS__, 'maybe_refresh_embark_data' ] );
		add_action( 'init', [ __CLASS__, 'register_post_types' ] );
		add_action( 'wp_head', [ __CLASS__, 'maybe_noindex' ] );
		add_action( 'wp_head', [ __CLASS__, 'do_analytics' ] );
		add_action( 'wp_head', [ __CLASS__, 'do_extra_css' ] );
		add_action( 'acf__settings__remove_wp_meta_box', '__return_false', 20 );
		add_filter( 'the_permalink', [ __CLASS__, 'maybe_override_post_permalink' ] );
	}

	/**
	 * Override the permalink with an ACF field if the field is set.
	 *
	 * @param string $link The permalink.
	 * @return string The filtered link.
	 */
	public static function maybe_override_post_permalink( $link ) {
		if ( ! function_exists( 'get_field' ) ) {
			return $link;
		}

		$redirect_url = get_field( 'redirect_url' );

		return $redirect_url ?: $link;
	}

	/**
	 * Put extra css in head.
	 *
	 * @return void
	 */
	public static function do_extra_css() {
		$extra_css = get_post_meta( get_the_id(), 'extra_css', true );

		if ( ! $extra_css ) {
			return;
		}

		echo "<style>
$extra_css
</style>";
	}

	/**
	 * Echos the analytics code set in the theme options.
	 *
	 * @return void
	 */
	public static function do_analytics() {
		echo ThemeOptions::get( ThemeOptions::ANALYTICS_KEY );
	}

	/**
	 * Noindex this page if a specified meta key is set.
	 *
	 * @return void
	 */
	public static function maybe_noindex() {
		if ( '1' === get_post_meta( get_queried_object_id(), 'noindex', true ) ) {
			?>
			<meta name="robots" content="noindex, nofollow">
			<?php
		}
	}

	/**
	 * Registers post types.
	 *
	 * @return void
	 */
	public static function register_post_types() {
		foreach ( self::POST_TYPES as $type => $settings ) {
			register_post_type( $type, $settings );
		}
	}

	/**
	 * Run the Embark refresher if an admin says so.
	 *
	 * @return void
	 */
	public static function maybe_refresh_embark_data() {
		if ( current_user_can( 'edit_others_posts' && get_query_var( 'refresh_embark' ) ) ) {
			new EmbarkRefresher();
		}
	}

	/**
	 * Add query vars.
	 *
	 * @param array $query_vars Already-set vars.
	 * @return array Modified vars.
	 */
	public static function add_query_var( array $query_vars ) : array {
		return array_merge( $query_vars, self::QUERY_VARS );
	}

	/**
	 * Enqueues scripts and styles.
	 *
	 * @return void
	 */
	public static function enqueue_scripts_and_styles() {
		$dist = get_template_directory_uri() . '/dist';
		$min = PROD ? '.min' : '';
		wp_enqueue_script(
			self::TEXT_DOMAIN,
			"$dist/" . self::TEXT_DOMAIN . "$min.js",
			[],
			self::VERSION,
			true
		);

		wp_enqueue_style(
			self::TEXT_DOMAIN,
			"$dist/" . self::TEXT_DOMAIN . "$min.css",
			[],
			self::VERSION
		);

		wp_enqueue_script( 'jquery' );
		wp_enqueue_style(
			'typekit',
			'https://use.typekit.net/gty7fbd.css'
		);
	}

	/**
	 * Provides data to scripts.
	 *
	 * @return void
	 */
	public static function localize_scripts() {
		$wp_data = [
			'bloginfoUrl' => get_bloginfo( 'url' ),
		];

		$wp_data = apply_filters( 'colby_wp_theme_localized_data', $wp_data );

		if ( empty( $wp_data ) ) {
			return;
		}

		wp_localize_script( self::TEXT_DOMAIN, 'wpData', $wp_data );
	}

	/**
	 * Excludes media kit posts from the archive.
	 *
	 * @param \WP_Query $query The $wp_query object.
	 * @return void
	 */
	public static function exclude_media_kit_from_posts( $query ) {
		if ( is_home() && $query->is_main_query() ) {
			$query->set( 'category__not_in', [ get_cat_ID( 'Media Kit' ) ] );
		}
	}

	/**
	 * Turns off the visual editor for specified pages.
	 *
	 * @param bool $bool Whether the visual editor should show.
	 * @return bool Whether to enable the rich editor.
	 */
	public static function maybe_turn_off_visual_editor( bool $bool ) : bool {
		$screen = get_current_screen();
		if ( is_object( $screen ) && isset( $screen->post_type ) && 'page' === $screen->post_type ) {
			foreach ( self::USER_CANT_RICHEDIT as $template ) {
				if ( strpos( get_page_template(), $template ) !== false ) {
					return false;
				}
			}
		}
		return $bool;
	}
}
