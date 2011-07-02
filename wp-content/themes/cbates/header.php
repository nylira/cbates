<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<!-- saved from url=(0014)about:internet -->

<!-- Begin head -->
<head profile="http://gmpg.org/xfn/11">

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="author" content="iKreativ.com" />
<meta name="copyright" content="<?php echo bloginfo('name'); ?>" />
<meta name="robots" content="index, follow" />
<meta name="revisit-after" content="7 days" />
<meta name="distribution" content="global" />
<meta name="resource-type" content="document" />
<meta name="language" content="en" />
<meta name="description" content="<?php echo stripslashes(get_option('of_seo_description')); ?>" />
<meta name="keywords" content="<?php echo stripslashes(get_option('of_seo_keywords')); ?>" />

<title><?php echo bloginfo('name'); ?><?php if(is_single()) { ?> &raquo; Archive <?php } ?><?php wp_title(); ?></title>

<!-- Stylesheets -->
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/style.css" type="text/css" media="screen" />
<!-- End Stylesheets -->

<!-- Google Fonts -->
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Droid+Serif:regular,italic,bold,bolditalic" type="text/css" />
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Droid+Sans:regular,bold" type="text/css" />
<!-- End Google Fonts -->

<!-- Begin Links -->
<link rel="shortcut icon" href="<?php echo get_option('of_favicon'); ?>" type="image/x-icon" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<!-- End Links -->

<!-- Upgrade! -->
<!--[if lt IE 8]>
<meta http-equiv="refresh" content="0; url=http://www.microsoft.com/windows/internet-explorer/default.aspx" />
<script type="text/javascript">
/* <![CDATA[ */
window.top.location = 'http://www.microsoft.com/windows/internet-explorer/default.aspx';
/* ]]> */
</script>
<![endif]-->

<?php if(is_singular()) wp_enqueue_script( 'comment-reply' ); ?>

<!-- WP Head Hook -->
<?php wp_head(); ?>

<!-- These are CSS color overrides set via the options panel. -->
<?php $typo = array(get_option('of_typography')); ?>
<style type="text/css" media="screen">
.QLoader { background-color: <?php echo get_option('of_preloader_color'); ?>; }

h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a, h1 a:visited, h2 a:visited, h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited, .button, a.toggleLink, a:hover, a:visited:hover, #aside ul li a:hover, #twitter_update_list a
{ color: <?php echo get_option('of_heading_color'); ?>; }

p { font-size: <?php echo $typo[0][size] . 'px'; ?>; font-family: <?php echo $typo[0][face]; ?>; font-style: <?php echo $typo[0][style]; ?>; color: <?php echo $typo[0][color]?>; }
</style>
<!-- End CSS color overrides -->

<!-- Custom CSS. Set in options panel. Overrides everything else. -->
<style type="text/css" media="screen">
<?php echo stripslashes(get_option('of_custom_css')); ?>
</style>
<!-- End Custom CSS -->

<!-- Options panel settings for Preloader -->
<?php if(is_page_template('gallery.php')) { ?>
<?php if(get_option('of_preloader') != 'true') { ?>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/loader.js"></script>
<?php } } ?>
<!-- End Preloader -->

<!-- Options panel setting for Image Panning -->
<?php if(is_page_template('gallery.php')) { ?>
<?php if(get_option('of_image_panning') != 'true') { ?>
<script type="text/javascript">
makeScrollable();
function makeScrollable(){
	$(document).bind('mousemove',function(e){
		var top = (e.pageY - $(document).scrollTop()/1) ;
	$(document).scrollTop(top);
	});
}
</script>
<?php } } ?>
<!-- End Image Panning -->

<!-- Check what page we're on. If not gallery fix the background -->
<?php if(!is_page_template('gallery.php')) { ?>
<style type="text/css" media="screen">
body img.preview, body.ie img.preview {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
  display: none;
	}
</style>
<?php } ?>
<!-- End background fix -->

</head>
<!-- End head -->

<!-- Grab the Featured Image of a Page -->
<?php $img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), true, '' ); ?>

<!--[if IE ]>
<body id="index" class="<?php if(is_page_template('gallery.php')) {  echo 'ie fs'; } else { echo 'ie'; } // Add class for fullscreen gallery ?>">
<![endif]-->
<!--[if !IE]>-->
<body id="index" class="<?php if(is_page_template('gallery.php')) { echo 'fs'; } // Add class for fullscreen gallery ?>">
<!--<![endif]-->

	<?php if(is_page_template('gallery.php')) { ?>
		<div id="gallery">
	<?php } ?>
		
	<!-- Initial image shown and also the static image shown behind pages. Set via options panel -->
	<?php if(!is_home()) { ?>
	<img src="<?php echo $img[0]; ?>" class="preview" alt="<?php bloginfo('name'); ?>" />
	<?php } else { ?>
	<img src="<?php echo get_option('of_image_static'); ?>" class="preview" alt="<?php echo bloginfo('name'); ?>"/>
	<?php } ?>
	
	<!-- If set in options panel go ahead and add image overlay -->
	<?php if(get_option('of_image_overlay') != 'true') { ?>
	<div id="overlay"></div>
	<?php } ?>
	
	<!-- Check page, if gallery load up navigation -->
	<?php if(is_page_template('gallery.php')) { ?>
		<div id="loading"></div>
		<div id="next"></div>
		<div id="prev"></div>
	<?php } ?>
	
	<!-- Check page, if not on gallery add content wrapper -->
	<?php if(!is_page_template('gallery.php')) { ?>
	<!-- Content -->
	<div id="contentWrapper">
		<div id="content">
		
		<div id="header">			
			<h1><?php trim(wp_title("")); ?></h1>
		</div>
	<?php } ?>
		
	<noscript>
		<div class="warning_box" style="text-align: center;">
			<img src="img/warning.png" alt="Default" />
			<?php _e('If you can see this notice you have Javascript disabled. Please enable Javascript to view our site in all it\'s glory. Thank You.', 'specere'); ?>
		</div>
	</noscript>
