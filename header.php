<?php

if ( ! function_exists( 'three_column_header_draw_left_column' ) ) :
function three_column_header_draw_left_column() {
    ob_start(); ?>

    <div class=lunder-logo-container>
        <a href=<?php bloginfo( 'url' ); ?>>
            <?php include 'lunder-institute.svg'; ?>
        </a>
    </div>

    <?php
    return ob_get_clean();
}
endif;

if ( ! function_exists( 'three_column_header_draw_middle_column' ) ) :
function three_column_header_draw_middle_column() {
    ob_start();

    wp_nav_menu( [
        'menu' => 'Site Menu',
        'menu_class' => 'site-menu',
        'container' => 'nav',
        'container_class' => 'site-menu-container',
        'depth' => 2,
    ] );

    $lists = explode( '</ul>', ob_get_clean() );

    $lists[count($lists) - 2] .= '<li><div id=header-search></div></li>';
    $lists = implode( '</ul>', $lists );

    return $lists;
}
endif;

if ( ! function_exists( 'three_column_header_draw_right_column' ) ) :
function three_column_header_draw_right_column() {
    ob_start(); ?>

    <span class=colby-museum-logo-container>
        <a href=//colby.edu/museum/>
            <?php Colby_College\Wp_Components\Wp_Parts::load_svg( 'colby-museum-logo' ); ?>
        </a>
    </span>

    <span class=colby-logo-container>
        <a href=//colby.edu>
            <?php Colby_College\Wp_Components\Wp_Parts::load_svg( 'colby-logo' ); ?>
        </a>
    </span>

    <?php
    return ob_get_clean();
}
endif;

Colby_College\Wp_Components\Wp_Parts::load( 'head.php' );
Colby_College\Wp_Components\Wp_Parts::load( 'three-column-header.php' );
