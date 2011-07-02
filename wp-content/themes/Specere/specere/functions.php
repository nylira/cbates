<?php

include_once('functions/custom-functions.php');

include_once('functions/gallery-functions.php');

include_once('functions/shortcodes.php');

if ( STYLESHEETPATH == TEMPLATEPATH ) {
	define('OF_FILEPATH', TEMPLATEPATH);
	define('OF_DIRECTORY', get_bloginfo('template_directory'));
} else {
	define('OF_FILEPATH', STYLESHEETPATH);
	define('OF_DIRECTORY', get_bloginfo('stylesheet_directory'));
}

require_once (OF_FILEPATH . '/admin/admin-functions.php');
require_once (OF_FILEPATH . '/admin/admin-interface.php');

require_once (OF_FILEPATH . '/admin/theme-options.php'); 
require_once (OF_FILEPATH . '/admin/theme-functions.php'); 

?>