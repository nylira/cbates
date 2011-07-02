<?php if(!is_page_template('gallery.php')) { ?>
	</div>
</div>
<!-- End Content -->
<?php } ?>

<!-- Footer -->
<div id="footer">

	<!-- Logo -->
	<div id="logo">
			
		<!-- Check if a logo has been uploaded, if so display. Set in the General section of the options panel. -->
		<?php if(get_option('of_logo')) { ?>
					
		<a href="<?php bloginfo('url'); ?>" title="Home">
			<img src="<?php echo get_option('of_logo'); ?>" alt="<?php echo bloginfo('name'); ?>" />
			<span class="slogan">&mdash;&nbsp; <?php bloginfo('description'); ?></span>
		</a>
					
		<?php } else { ?>
				
		<!-- If no logo set, fallback and show the site title. -->	
		<a href="<?php bloginfo('url'); ?>" title="Home">
			<h1><?php echo bloginfo('name'); ?></h1>
			<span class="slogan">&mdash;&nbsp; <?php bloginfo('description'); ?></span>
		</a>
						
		<?php } ?>
		
	</div>
	<!-- End Logo -->

	<!-- Navigation -->
	<div id="nav">

		<!-- Navigation Links. Check if Wordpress version >= 3, if so use WP3 menu. -->
		<?php if(function_exists('wp_nav_menu')){ ?>
		<?php wp_nav_menu(array( 'sort_column' => 'menu_order', 'container_class' => 'nav', 'theme_location' => 'primary_menu' )); ?>
		
		<?php } else { ?>
			
		<!-- If not Wordpress 3 then fallback to default navigation. -->
		<ul><?php wp_list_pages('sort_column=menu_order&title_li='); ?></ul>
			
		<?php } ?>
		<a href="#index" title="Going up?"><img id="up" src="<?php bloginfo('template_directory'); ?>/img/top.png" alt="Going up?" /></a>
		<!-- End Navigation Links -->

	</div>
	<!-- End Navigation -->
		
</div>
<!-- End Footer -->

<!-- Check if we are in the blog, if so include the Javascript for the Twitter widget. -->
<?php if(get_option('of_twitter_widget') != 'true') { ?>
	<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
	<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/<?php echo get_option('of_twitter_widget_username'); ?>.json?callback=twitterCallback2&amp;count=<?php echo get_option('of_twitter_widget_number'); ?>"></script>
<?php } ?>

<!-- Check if Cufon is enabled, if so include the Cufon Javascript and font. Enabled in the Typography section of the options panel. -->
<?php if(get_option('of_cufon') != 'Disabled') { ?>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/cufon.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/<?php echo get_option('of_cufon'); ?>.font.js"></script>
	<script type="text/javascript">
		Cufon.replace('h1, h2, h3, h4, h5, h6');
		Cufon.now();
	</script>
<?php } ?>

<!-- Show Google Analytics. Enter details in the Footer section of the options panel. -->
<?php echo get_option('of_analytics'); ?>

<!-- WP Footer Hook -->
<?php wp_footer(); ?>

</body> 
</html>