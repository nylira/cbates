<?php  
// Remove wp-autop via [raw][/raw]
function my_formatter($content) {
	$new_content = '';
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

	foreach ($pieces as $piece) {
		if (preg_match($pattern_contents, $piece, $matches)) {
			$new_content .= $matches[1];
		} else {
			$new_content .= wptexturize(wpautop($piece));
		}
	}

	return $new_content;
}

remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');

add_filter('the_content', 'my_formatter', 99);

// One Full
function one_full_shortcode( $atts, $content = null ) {
   return '<div class="one_full">' .do_shortcode($content). '</div>';
}
add_shortcode('one_full', 'one_full_shortcode');

// One Half
function one_half_shortcode( $atts, $content = null ) {
   return '<div class="one_half">' .do_shortcode($content). '</div>';
}
add_shortcode('one_half', 'one_half_shortcode');

// One Half Last
function one_half_last_shortcode( $atts, $content = null ) {
   return '<div class="one_half_last">' .do_shortcode($content). '</div>';
}
add_shortcode('one_half_last', 'one_half_last_shortcode');

// One Third
function one_third_shortcode( $atts, $content = null ) {
   return '<div class="one_third">' .do_shortcode($content). '</div>';
}
add_shortcode('one_third', 'one_third_shortcode');

// One Third Last
function one_third_last_shortcode( $atts, $content = null ) {
   return '<div class="one_third_last">' .do_shortcode($content). '</div>';
}
add_shortcode('one_third_last', 'one_third_last_shortcode');

// Two Third
function two_third_shortcode( $atts, $content = null ) {
   return '<div class="two_third">' .do_shortcode($content). '</div>';
}
add_shortcode('two_third', 'two_third_shortcode');

// Two Third Last
function two_third_last_shortcode( $atts, $content = null ) {
   return '<div class="two_third_last">' .do_shortcode($content). '</div>';
}
add_shortcode('two_third_last', 'two_third_last_shortcode');

// One Quarter
function one_quarter_shortcode( $atts, $content = null ) {
   return '<div class="one_quarter">' .do_shortcode($content). '</div>';
}
add_shortcode('one_quarter', 'one_quarter_shortcode');

// One Quarter Last
function one_quarter_last_shortcode( $atts, $content = null ) {
   return '<div class="one_quarter_last">' .do_shortcode($content). '</div>';
}
add_shortcode('one_quarter_last', 'one_quarter_last_shortcode');

// Default Box
function default_box_shortcode( $atts, $content = null ) {
   return '<div class="default_box"><img src="/wp-content/themes/specere/img/default.png" alt="Default" />' .do_shortcode($content). '</div>';
}
add_shortcode('default_box', 'default_box_shortcode');

// Notice Box
function notice_box_shortcode( $atts, $content = null ) {
   return '<div class="notice_box"><img src="/wp-content/themes/specere/img/error.png" alt="Notice" />' .do_shortcode($content). '</div>';
}
add_shortcode('notice_box', 'notice_box_shortcode');

// Warning Box
function warning_box_shortcode( $atts, $content = null ) {
   return '<div class="warning_box"><img src="/wp-content/themes/specere/img/exclamation.png" alt="Error" />' .do_shortcode($content). '</div>';
}
add_shortcode('warning_box', 'warning_box_shortcode');

// Success Box
function success_box_shortcode( $atts, $content = null ) {
   return '<div class="success_box"><img src="/wp-content/themes/specere/img/tick.png" alt="Success" />' .do_shortcode($content). '</div>';
}
add_shortcode('success_box', 'success_box_shortcode');

// Download Box
function download_box_shortcode( $atts, $content = null ) {
   return '<div class="download_box"><img src="/wp-content/themes/specere/img/down.png" alt="Download" />' .do_shortcode($content). '</div>';
}
add_shortcode('download_box', 'download_box_shortcode');

// Bullet List
function bullet_list_shortcode( $atts, $content = null ) {
   return '<div class="bullet_list">' .do_shortcode($content). '</div>';
}
add_shortcode('bullet_list', 'bullet_list_shortcode');

// Arrow List
function arrow_list_shortcode( $atts, $content = null ) {
   return '<div class="arrow_list">' .do_shortcode($content). '</div>';
}
add_shortcode('arrow_list', 'arrow_list_shortcode');

// Check List
function check_list_shortcode( $atts, $content = null ) {
   return '<div class="check_list">' .do_shortcode($content). '</div>';
}
add_shortcode('check_list', 'check_list_shortcode');

// Blockquote
function blockquote_shortcode( $atts, $content = null ) {
   return '<blockquote>' .do_shortcode($content). '</blockquote>';
}
add_shortcode('blockquote', 'blockquote_shortcode');

// Button
function button_link_shortcode( $atts, $content = null ) {
   return '<div class="button_link">' .do_shortcode($content). '</div>';
}
add_shortcode('button_link', 'button_link_shortcode');

// Accordion
function accordion_shortcode( $atts, $content = null ) {
		extract(shortcode_atts( array(
		'title' => '',
	), $atts ));
	
   return '<div class="accordion"><div class="accordion_title"><a href="#"><img src="/wp-content/themes/specere/img/toggler.png" alt="Toggle" />'.$title.'</a></div>' .do_shortcode($content);
}
add_shortcode('accordion', 'accordion_shortcode');

// Toggle
function toggle_shortcode( $atts, $content = null ) {
   return '<div class="toggle">' .do_shortcode($content). '</div>';
}
add_shortcode('toggle', 'toggle_shortcode');

// Filter
function filter_shortcode( $atts, $content = null ) {
   return '<ul id="filter"><li>Filter by type:</li><li><a href="#">All</a></li>' .do_shortcode($content). '</ul><div class="splitter"></div>';
}
add_shortcode('filter', 'filter_shortcode');

// Filter item
function filter_item_shortcode( $atts, $content = null ) {
   return '<li><a href="#">' .do_shortcode($content). '</a></li>';
}
add_shortcode('filter_item', 'filter_item_shortcode');

// Portfolio
function portfolio_shortcode( $atts, $content = null ) {
   return '<ul id="portfolio">' .do_shortcode($content). '</ul>';
}
add_shortcode('portfolio', 'portfolio_shortcode');

// Item with class attr for filter
function portfolio_item_shortcode( $atts, $content = null ) {
	extract(shortcode_atts( array(
		'class' => '',
	), $atts ));

	return '<li class="portfolio_item '.$class.'"><span class="zoom"></span>' .do_shortcode($content). '</li>';
}
add_shortcode('portfolio_item', 'portfolio_item_shortcode');

// Splitter
function splitter_shortcode( $atts, $content = null ) {
   return '<div class="splitter"></div>';
}
add_shortcode('splitter', 'splitter_shortcode');

// Highlight
function highlight_shortcode( $atts, $content = null ) {
   return '<span class="highlight">' .do_shortcode($content). '</span>';
}
add_shortcode('highlight', 'highlight_shortcode');

?>