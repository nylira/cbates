<?php

// WP3 Menus
add_action( 'init', 'register_my_menus' );

function register_my_menus() {
	register_nav_menus(
		array(
			'primary_menu' => __( 'Primary Menu' )
		)
	);
}

// Localization support
load_theme_textdomain( 'specere', TEMPLATEPATH.'/language' );

$locale = get_locale();
$locale_file = TEMPLATEPATH."/language/$locale.php";
if (is_readable($locale_file) )
	require_once($locale_file);

// Wordpress 3 Menu Support
add_theme_support('menus');

// Widgetized Sidebar Function
if (function_exists('register_sidebar') )
register_sidebar(array(
'before_widget' => '<li id="%1$s" class="widget %2$s">',
'after_widget' => '</li>',
'before_title' => '',
'after_title' => '',
));

// Search Function
function SearchFilter($query) {
if ($query->is_search) {
$query->set('post_type', 'post');
}
return $query;
}

add_filter('pre_get_posts','SearchFilter');

// Excerpt Link
function my_trim_excerpt($text) {
	global $post;
	if ( '' == $text ) {
		$text = get_the_content('');
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]&gt;', $text);
		$text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
		$text = strip_tags($text, '<p>');
		$excerpt_length = 25;
		$words = explode(' ', $text, $excerpt_length + 1);
		if (count($words)> $excerpt_length) {
			array_pop($words);
			array_push($words, '...<br /><span class="more-link"><a href='.get_permalink().'>read more &raquo;</a></span>');
			$text = implode(' ', $words);
		}
	}
	return $text;
}

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'my_trim_excerpt');

// Comment hack: this code automatically rejects any request for comment posting coming from a browser (or, more commonly, a bot) that has no referrer in the request
function check_referrer() {
if (!isset($_SERVER['HTTP_REFERER']) || $_SERVER['HTTP_REFERER'] == со) {
wp_die( __('Please enable referrers in your browser, or, if you\'re a spammer, bugger off!') );
}
}

add_action('check_comment_flood', 'check_referrer');

// Remove wp-generator to prevent version hacking
remove_action('wp_head', 'wp_generator');

// Remove wlwmanifest
remove_action( 'wp_head', 'wlwmanifest_link');

// Enable support for post-thumbnails
add_theme_support('post-thumbnails');

// We want to ensure that we only call this function if
// the user is working with WP 2.9 or higher,
// let's instead make sure that the function exists first
if ( function_exists('add_theme_support') ) {
	add_theme_support('post-thumbnails');
}

// Load theme scripts for frontend only
if(!is_admin()) {

function load_theme_scripts() {
  wp_deregister_script('jquery');
  wp_enqueue_script( 'jquery', get_template_directory_uri() . '/js/jquery.js', true);
  wp_enqueue_script( 'ui-core', get_template_directory_uri() . '/js/ui-core.js', true);
  wp_enqueue_script( 'easing', get_template_directory_uri() . '/js/easing.js', 'jquery', true );
  wp_enqueue_script( 'localscroll', get_template_directory_uri() . '/js/localscroll.js', 'jquery', true );
  wp_enqueue_script( 'scrollto', get_template_directory_uri() . '/js/scrollto.js', 'jquery', true );
  wp_enqueue_script( 'validate', get_template_directory_uri() . '/js/validate.js', 'jquery', true );
  wp_enqueue_script( 'form', get_template_directory_uri() . '/js/form.js', 'jquery', true );
  wp_enqueue_script( 'colorbox', get_template_directory_uri() . '/js/colorbox.js', 'jquery', true );
  wp_enqueue_script( 'tipsy', get_template_directory_uri() . '/js/tipsy.js', 'jquery', true );
  wp_enqueue_script( 'global', get_template_directory_uri() . '/js/global.js', '', true );
  wp_enqueue_script( 'gallery', get_template_directory_uri() . '/js/gallery.js', '', true );
}   
 
add_action('init', 'load_theme_scripts');

}

?>