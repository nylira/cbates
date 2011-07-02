<?php

add_action('init','of_options');

if (!function_exists('of_options')) {
function of_options(){
	
// VARIABLES
$themename = get_theme_data(STYLESHEETPATH . '/style.css');
$themename = $themename['Name'];
$shortname = "of";

// Populate OptionsFramework option in array for use in theme
global $of_options;
$of_options = get_option('of_options');

$GLOBALS['template_path'] = OF_DIRECTORY;

//Access the WordPress Categories via an Array
$of_categories = array();  
$of_categories_obj = get_categories('hide_empty=0');
foreach ($of_categories_obj as $of_cat) {
    $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
$categories_tmp = array($of_categories);    
       
//Access the WordPress Pages via an Array
$of_pages = array();
$of_pages_obj = get_pages('sort_column=post_parent,menu_order');    
foreach ($of_pages_obj as $of_page) {
    $of_pages[$of_page->ID] = $of_page->post_name; }
$of_pages_tmp = array($of_pages);       

// Image Alignment radio box
$options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 

// Image Links to Options
$options_image_link_to = array("image" => "The Image","post" => "The Post");  

//Stylesheets Reader
$alt_stylesheet_path = OF_FILEPATH . '/styles/';
$alt_stylesheets = array();

if (is_dir($alt_stylesheet_path) ) {
    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) { 
        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
            if(stristr($alt_stylesheet_file, ".css") !== false) {
                $alt_stylesheets[] = $alt_stylesheet_file;
            }
        }    
    }
}

//More Options
$uploads_arr = wp_upload_dir();
$all_uploads_path = $uploads_arr['path'];
$all_uploads = get_option('of_uploads');
$other_entries = array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
$body_repeat = array("no-repeat","repeat-x","repeat-y","repeat");
$body_pos = array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");

// Set the Options Array
$imgurl =  OF_DIRECTORY . '/admin/images/';

$options = array();

// General
$options[] = array( "name" => "General Settings",
                    "type" => "heading");					

$options[] = array( "name" => "Logo",
					"desc" => "Upload or specify a URL. eg: (http://yoursite.com/logo.png) for the logo you would like displaying on the website.",
					"id" => $shortname."_logo",
					"std" => "",
					"type" => "upload");

$options[] = array( "name" => "Custom Favicon",
					"desc" => "Upload or specify a URL. eg: (http://yoursite.com/favicon.png) of a 16px x 16px .png or .gif image that will represent your website's favicon. A favicon is the icon that shows in the left hand side of thr URL bar in your web browser.",
					"id" => $shortname."_favicon",
					"std" => "",
					"type" => "upload");    
					
$options[] = array( "name" => "Email Address",
					"desc" => "Enter the recipient email address that all mail from the in-built contact form should be sent to.",
					"id" => $shortname."_contact_email",
					"std" => "dummy@email.com",
					"type" => "text");   
					
// Preloader
$options[] = array( "name" => "Preloader Settings",
                    "type" => "heading");					

$options[] = array( "name" => "Preloader Color",
					"desc" => "Choose a color you would like for the preloader shown on the fullscreen gallery.",
					"id" => $shortname."_preloader_color",
					"std" => "#ff6900",
					"type" => "color");

$options[] = array( "name" => "Disable",
					"desc" => "Check this box if you would like to disable the preloader.",
					"id" => $shortname."_preloader",
					"std" => "false",
					"type" => "checkbox");         

// Styling    
$options[] = array( "name" => "CSS Settings",
					"type" => "heading");
					
$options[] = array( "name" => "Custom CSS",
                    "desc" => "Quickly add CSS markup to your theme by adding it here. This will override any other styles. E.g: #mycssid { color: #757575; }",
                    "id" => $shortname."_custom_css",
                    "std" => "",
                    "type" => "textarea");

// Typography
$options[] = array( "name" => "Typography",
					"type" => "heading");
					
$options[] = array( "name" => "Main Text",
					"desc" => "Set the default font stack for the main website text.",
					"id" => $shortname."_typography",
				    "std" => array('size' => '12', 'face' => 'droid','style' => 'normal','color' => '#757575'),
					"type" => "typography");
					
$options[] = array( "name" => "Heading Colors",
					"desc" => "Select the color you'd like for the headings and titles.",
					"id" => $shortname."_heading_color",
					"std" => "#353535",
					"type" => "color");
					
$options[] = array( "name" => "Cufon Font Replacement",
					"desc" => "Choose a font type to be used for headings and titles throughout the site. If you do not wish to use Cufon font replacement and would like to default to CSS fonts simply set this to Disabled.",
					"id" => $shortname."_cufon",
					"std" => "Merge",
					"options" => array('Anklada', 'Cantarell', 'Coolvetica', 'Lobster', 'London', 'Maximus', 'Merge', 'Museo', 'Nadia', 'Titillium', 'Quicksand', 'Disabled'),
					"type" => "select");

// Fullscreen Imagery
$options[] = array( "name" => "Fullscreen Imagery",
					"type" => "heading");
								
$options[] = array( "name" => "Disable Image Panning",
					"desc" => "Check this box if you would like to disable the image panning on the fullscreen images.",
					"id" => $shortname."_image_panning",
					"std" => "false",
					"type" => "checkbox");

$options[] = array( "name" => "Disable Image Overlay",
					"desc" => "Check this box if you would like to disable the image overlay. This is the faint crosshatch effect over the fullscreen images. This also has the added benefit of preventing 'right click view image'.",
					"id" => $shortname."_image_overlay",
					"std" => "false",
					"type" => "checkbox");

// Social
$options[] = array( "name" => "Social Integration",
					"type" => "heading");

$options[] = array( "name" => "Twitter",
					"desc" => "Enter your Twitter username. If enabled this option will show the Twitter icon.",
					"id" => $shortname."_twitter",
					"std" => "",
					"type" => "text"); 
					
$options[] = array( "name" => "Facebook",
					"desc" => "Enter your Facebook ID. If enabled this option will show the Facebook icon. Note: Enter the ID only, this is the long number at the end of this URL: profile.php?id=",
					"id" => $shortname."_facebook",
					"std" => "",
					"type" => "text");

// Twitter Widget		
$options[] = array( "name" => "Twitter Widget",
					"type" => "heading");

$options[] = array( "name" => "Twitter",
					"desc" => "Enter your Twitter username.",
					"id" => $shortname."_twitter_widget_username",
					"std" => "",
					"type" => "text");
					
$options[] = array( "name" => "Tweet Number",
					"desc" => "How many recent tweets would you like to display?",
					"id" => $shortname."_twitter_widget_number",
					"std" => "3",
					"type" => "text");
					
$options[] = array( "name" => "Widget Title",
					"desc" => "Enter a title to display above the widget.",
					"id" => $shortname."_twitter_widget_title",
					"std" => "140 Characters",
					"type" => "text");
					
$options[] = array( "name" => "Disable",
					"desc" => "Disable the Twitter widget.",
					"id" => $shortname."_twitter_widget",
					"std" => "false",
					"type" => "checkbox");
					
// Flickr Widget		
$options[] = array( "name" => "Flickr Widget",
					"type" => "heading");

$options[] = array( "name" => "Flickr",
					"desc" => "Enter your Flickr RSS URL. You can find your Flickr feed by going to Flickr.com, log in and then click Your Photostream. After the page loads, scroll down to the bottom and find Subscribe to Your Name's photostream then copy the link.",
					"id" => $shortname."_flickr_widget_feed",
					"std" => "http://api.flickr.com/services/feeds/photos_public.gne?id=99771506@N00&amp;lang=en-us&amp;format=rss_200",
					"type" => "text");
					
$options[] = array( "name" => "Flickr Photo Number",
					"desc" => "How many photos would you like to display?",
					"id" => $shortname."_flickr_widget_number",
					"std" => "16",
					"type" => "text");
					
$options[] = array( "name" => "Widget Title",
					"desc" => "Enter a title to display above the widget.",
					"id" => $shortname."_flickr_widget_title",
					"std" => "Flickr Stream",
					"type" => "text");
					
$options[] = array( "name" => "Disable",
					"desc" => "Disable the Flickr widget.",
					"id" => $shortname."_flickr_widget",
					"std" => "false",
					"type" => "checkbox");

// Popular Widget				
$options[] = array( "name" => "Popular Entries Widget",
					"type" => "heading");  
					
$options[] = array( "name" => "Widget Title",
					"desc" => "Enter a title to display above the widget.",
					"id" => $shortname."_popular_widget_title",
					"std" => "Popular Entries",
					"type" => "text");   
					
$options[] = array( "name" => "Disable",
					"desc" => "Disable the Popular Entries Widget.",
					"id" => $shortname."_popular_widget",
					"std" => "false",
					"type" => "checkbox");
					
// Categories Widget				
$options[] = array( "name" => "Categories Widget",
					"type" => "heading");  
					
$options[] = array( "name" => "Widget Title",
					"desc" => "Enter a title to display above the widget.",
					"id" => $shortname."_categories_widget_title",
					"std" => "Categories",
					"type" => "text");   
					
$options[] = array( "name" => "Disable",
					"desc" => "Disable the Categories Widget.",
					"id" => $shortname."_categories_widget",
					"std" => "false",
					"type" => "checkbox");

// Archives Widget				
$options[] = array( "name" => "Archives Widget",
					"type" => "heading");  
					
$options[] = array( "name" => "Widget Title",
					"desc" => "Enter a title to display above the widget.",
					"id" => $shortname."_archives_widget_title",
					"std" => "Archives",
					"type" => "text");   
					
$options[] = array( "name" => "Disable",
					"desc" => "Disable the Archives Widget.",
					"id" => $shortname."_archives_widget",
					"std" => "false",
					"type" => "checkbox");
					
// Display
$options[] = array( "name" => "Blog Options",
					"type" => "heading"); 

$options[] = array( "name" => "Static Image",
					"desc" => "Upload or specify a URL. eg: (http://yoursite.com/logo.png) for the image that will be shown as the Blog background.",
					"id" => $shortname."_image_static",
					"std" => "",
					"type" => "upload"); 
					   
$options[] = array( "name" => "Display settings",
					"desc" => "How would you like to display your posts? You may show either the full content or the excerpt. Defaults to the excerpt.",
					"id" => $shortname."_post_display",
					"std" => "excerpt",
					"type" => "radio",
					"options" => array('content' => 'Full Content', 'excerpt' => 'The Excerpt')); 

// Analytics
$options[] = array( "name" => "Analytics",
					"type" => "heading");     
					
$options[] = array( "name" => "Tracking Code",
					"desc" => "Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.",
					"id" => $shortname."_analytics",
					"std" => "",
					"type" => "textarea");

// SEO
$options[] = array( "name" => "SEO",
                    "type" => "heading");					

$options[] = array( "name" => "Description",
					"desc" => "Describe your website and/or services.",
					"id" => $shortname."_seo_description",
					"std" => "Website Description",
					"type" => "text");
					
$options[] = array( "name" => "Keywords",
					"desc" => "Enter comma seperated keywords relevant to your site, content and/or services.",
					"id" => $shortname."_seo_keywords",
					"std" => "some, site, keywords, for, seo",
					"type" => "text");
					
update_option('of_template',$options); 					  
update_option('of_themename',$themename);   
update_option('of_shortname',$shortname);

}
}
?>
