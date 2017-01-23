<?php

if ( has_post_thumbnail() ) {
    return Colby_College\Wp_Components\Wp_Templates::load( 'page-with-header-image.php' );
}

return Colby_College\Wp_Components\Wp_Templates::load( 'index.php' );
