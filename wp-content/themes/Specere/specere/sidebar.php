	<div id="aside">
	
		<!-- Social Links. Enabled by entering the relevant username in the Social section of the options panel. -->
		<div id="social">
			
			<!-- Twitter -->
			<?php if(get_option('of_twitter')) { ?> 
			<a class="tooltip" href="http://twitter.com/<?php echo get_option('of_twitter'); ?>" title="Follow us on Twitter.">
				<img src="<?php bloginfo('template_directory'); ?>/img/twitter.png" alt="Twitter" />
			</a>
			<?php } ?>	
			
			<!-- Facebook -->
			<?php if(get_option('of_facebook')) { ?>
			<a class="tooltip" href="http://www.facebook.com/#!/profile.php?id=<?php echo get_option('of_facebook'); ?>" title="Follow us on Facebook.">
				<img src="<?php bloginfo('template_directory'); ?>/img/facebook.png" alt="Facebook" />
			</a>
			<?php } ?>
			
			<!-- RSS -->
			<a class="tooltip" href="<?php bloginfo('url'); ?>/feed" title="Subscribe to our RSS feed.">
				<img src="<?php bloginfo('template_directory'); ?>/img/feed.png" alt="RSS Feed" />
			</a>

		</div>
		<!-- End Social Links -->
		
		<!-- Include the search form -->
		<?php get_search_form() ?>
		
		<!-- Twitter Widget. Set via options panel -->
		<?php if(get_option('of_twitter_widget') != 'true') { ?>
			<h6><?php echo get_option('of_twitter_widget_title'); ?></h6>
			
				<ul id="twitter_update_list">
					<li>&nbsp;</li>
				</ul>
		<?php } ?>
		<!-- End Twitter Widget -->
		
		<!-- Flickr Widget. Set via options panel -->
		<?php if(get_option('of_flickr_widget') != 'true') { ?>
		  <h6><?php echo get_option('of_flickr_widget_title'); ?></h6>
		  
		  <div id="flickr">
			<?php // Get RSS Feed(s)

				include_once(ABSPATH . WPINC . '/feed.php');
				include_once(TEMPLATEPATH . '/inc/flickr.php');

				$rss = fetch_feed(get_option('of_flickr_widget_feed'));
				$thumb = 'square';
				$full = 'medium';

				$maxitems = $rss->get_item_quantity(get_option('of_flickr_widget_number')); 
	
				// Build an array of all the items, starting with element 0 (first element).
				$rss_items = $rss->get_items(0, $maxitems);
			?>

			<?php if($maxitems == 0) echo '<h6>No items.</h6>';
			
			else

			// Loop through each feed item and display each item as a hyperlink.
			foreach ( $rss_items as $item ):
		  		$url = flickr::find_photo($item->get_description());
		  		$title = flickr::cleanup($item->get_title());
		  		$full_url = flickr::photo($url, $full);
		  		$thumb_url = flickr::photo($url, $thumb);
			?>

			<a class="tooltip-e" href="<?php echo $item->get_permalink(); ?>" title="<?php echo $item->get_title(); ?>" target="_blank">
    			<img src="<?php echo $thumb_url; ?>" alt="<?php echo $item->get_title(); ?>" />
			</a>
		
			<?php endforeach; ?>
		  </div> 
		<?php } ?>
		<!-- End Flickr Widget -->
		
		<!-- Popular Entries Widget. Set via options panel. -->
		<?php if(get_option('of_popular_widget') != 'true') { ?>
		<div id="popular">
			<h6><?php echo get_option('of_popular_widget_title'); ?></h6>
			
			<ul>

			<?php $result = $wpdb->get_results("SELECT comment_count,ID,post_title FROM $wpdb->posts ORDER BY comment_count DESC LIMIT 0, 10");

				foreach ($result as $post) {
					setup_postdata($post);
					$postid = $post->ID;
					$title = $post->post_title;
					$commentcount = $post->comment_count;
				if($commentcount >= 1) { 
			?>

			<li>
				<a href="<?php echo get_permalink($postid); ?>" title="<?php echo $title; ?>">
					<?php echo $title; ?>
				</a>
			</li>
			
			<?php }} ?>
			
			</ul>
		</div>
		<?php } ?>
		<!-- End Popular Entries Widget -->

		<!-- Categories Widget. Set via options panel. -->
		<?php if(get_option('of_categories_widget') != 'true') { ?>
		
		<div id="categories">
			<h6><?php echo get_option('of_categories_widget_title'); ?></h6>

			<ul>
				<?php wp_list_categories('&title_li=&depth=1&show_count=1'); ?>
			</ul>
		</div>
		<?php } ?>
		<!-- End Categories Widget -->

		<!-- Archives Widget. Set via options panel. -->
		<?php if(get_option('of_archives_widget') != 'true') { ?>
		
		<div id="archives">
			<h6><?php echo get_option('of_archives_widget_title'); ?></h6>
			
			<ul>
				<?php wp_get_archives('type=monthly&limit=12'); ?>
			</ul>
		</div>
		
		<?php } ?>
		<!-- End Archives Widget -->
		
		<?php // This calls the theme widgets ?>
		<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
		<?php if(is_404() || is_category() || is_day() || is_month() || is_year() || is_search() || is_paged() ) { ?>

		<?php /* If this is a 404 page */ if(is_404()) { ?>
		<?php /* If this is a category archive */ } elseif (is_category()) { ?>
		<?php } ?>
		<?php }?>

		<?php endif; ?>

	</div>