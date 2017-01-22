<?php

class Colby_Wp_Theme {
    public function __construct() {
        $this->theme = wp_get_theme();

        $this->text_domain = $this->theme->get( 'Text Domain' );
        $this->version = $this->theme->get( 'Version' );
        $this->path = trailingslashit( get_stylesheet_directory() );
        $this->url = trailingslashit( get_template_directory_uri() );
        $this->assets_url = str_replace( ['http:', 'https:' ], '', $this->url ) . 'assets/';

        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'localize_scripts' ] );
    }

    public function enqueue_styles() {
        $styles = [
            [
                $this->text_doman,
                get_stylesheet_uri(),
                [],
                $this->version,
            ]
        ];

        $styles = apply_filters( 'colby_wp_theme_styles', $styles );

        foreach ( $styles as $style ) {
            call_user_func_array( 'wp_enqueue_script', $style );
        }
    }

    public function enqueue_scripts() {
        $scripts = [
            [
                $this->text_doman,
                "{$this->assets_url}{$this->text_domain}.js",
                [],
                $this->version,
                true
            ]
        ];

        $scripts = apply_filters( 'colby_wp_theme_scripts', $scripts );

        foreach ( $scripts as $script ) {
            call_user_func_array( 'wp_enqueue_script', $script );
        }
    }

    public function localize_scripts() {
        $wp_data = [
    		'bloginfoUrl' => get_bloginfo( 'url' ),
    	];

        if ( empty( $wp_data = apply_filters( 'colby_wp_theme_localized_data', $wp_data ) ) ) {
            return;
        }

        wp_localize_script( $this->text_domain, 'wpData',  $wp_data );
    }
}
