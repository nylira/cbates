<?php if(!is_page_template('gallery.php')) { ?>
	</div>
</div>
<?php } ?>

<div id="footer">
	<div id="nav">

    <a id="logo" href="<?php bloginfo('url'); ?>" title="Home">
      <?php if(get_option('of_logo')) { ?>
        <img src="<?php echo get_option('of_logo'); ?>" alt="<?php echo bloginfo('name'); ?>" />
      <?php } else { ?>
        <h1><span class="name">Cooper Bates</span> Photography</h1>
      <?php } ?>
    </a>

		<?php if(function_exists('wp_nav_menu')){ ?>
      <?php wp_nav_menu(array( 'sort_column' => 'menu_order', 'container_class' => 'nav', 'theme_location' => 'primary_menu', 'exclude' => '1208' )); ?>
		<?php } else { ?>
      <ul><?php wp_list_pages('sort_column=menu_order&title_li='); ?></ul>
		<?php } ?>

	</div>
</div>

<?php if(get_option('of_twitter_widget') != 'true') { ?>
	<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
	<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/<?php echo get_option('of_twitter_widget_username'); ?>.json?callback=twitterCallback2&amp;count=<?php echo get_option('of_twitter_widget_number'); ?>"></script>
<?php } ?>

<?php if(get_option('of_cufon') != 'Disabled') { ?>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/cufon.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/<?php echo get_option('of_cufon'); ?>.font.js"></script>
	<script type="text/javascript">
		Cufon.replace('h1, h2, h3, h4, h5, h6');
		Cufon.now();
	</script>
<?php } ?>

<?php echo get_option('of_analytics'); ?>

<?php wp_footer(); ?>
