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
    return ob_get_clean();
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
?>

<header class=three-column-header>
    <div class=three_column-header__left>
        <?php echo apply_filters( 'three_column_header_left_column', three_column_header_draw_left_column() ); ?>
    </div>

    <div class=three-column-header__collapsible-columns>
        <div class=three_column-header__middle>
            <?php echo apply_filters( 'three_column_header_middle_column', three_column_header_draw_middle_column() ); ?>
        </div>

        <div class=three_column-header__right>
            <?php echo apply_filters( 'three_column_header_right_column', three_column_header_draw_right_column() ); ?>
        </div>
    </div>

    <a class=menu-icon-container href=#>
        <svg id=menu-icon viewbox="0 0 20 20">
            <title>Menu</title>
            <path d="M0,6 20,6" stroke="currentColor" stroke-width="3" />
            <path d="M0,16 20,16" stroke="currentColor" stroke-width="3" />
        </svg>
    </a>

</header>
