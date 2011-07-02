<div id="aside">
  <ul class="widgets">
    <li class="social widget">
      <h3>Social</h3>
      <ul>
        <?php if(get_option('of_twitter')) { ?> 
          <li><a href="http://twitter.com/<?php echo get_option('of_twitter'); ?>" title="Follow us on Twitter.">@cooperbates</a>
        <?php } ?>	
        <?php if(get_option('of_facebook')) { ?>
          <li><a href="http://www.facebook.com/#!/profile.php?id=<?php echo get_option('of_facebook'); ?>" title="Follow us on Facebook.">Facebook</a>
        <?php } ?>
        <li><a href="<?php bloginfo('url'); ?>/feed" title="Subscribe to our RSS feed.">Subscribe</a>
      </ul>

    <?php if(get_option('of_twitter_widget') != 'true') { ?>
      <li class="twitter widget">
        <h3><?php echo get_option('of_twitter_widget_title'); ?></h3>
        <ul id="twitter_update_list">
          <li>&nbsp;</li>
        </ul>
    <?php } ?>
  
    <?php if(get_option('of_flickr_widget') != 'true') { ?>
      <h3><?php echo get_option('of_flickr_widget_title'); ?></h3>
      
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

      <?php if($maxitems == 0) echo '<h3>No items.</h3>';
      
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
    
    <?php if(get_option('of_popular_widget') != 'true') { ?>
    <li id="popular" class="popular widget">
      <h3><?php echo get_option('of_popular_widget_title'); ?></h3>
      <ul>
      <?php $result = $wpdb->get_results("SELECT comment_count,ID,post_title FROM $wpdb->posts ORDER BY comment_count DESC LIMIT 0, 10");

        foreach ($result as $post) {
          setup_postdata($post);
          $postid = $post->ID;
          $title = $post->post_title;
          $commentcount = $post->comment_count;
        if($commentcount >= 1) { 
      ?>
      <li><a href="<?php echo get_permalink($postid); ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a>
      <?php }} ?>
      </ul>
    <?php } ?>

    <?php if(get_option('of_categories_widget') != 'true') { ?>
    
    <li id="categories" class="categories widget">
      <h3><?php echo get_option('of_categories_widget_title'); ?></h3>
      <ul>
        <?php wp_list_categories('&title_li=&depth=1'); ?>
      </ul>
    <?php } ?>

    <?php if(get_option('of_archives_widget') != 'true') { ?>
      <li id="archives" class="archives widget">
        <h3><?php echo get_option('of_archives_widget_title'); ?></h3>
        <ul>
          <?php wp_get_archives('type=monthly&limit=12'); ?>
        </ul>
    <?php } ?>
    
    <?php // This calls the theme widgets ?>
    <?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
    <?php if(is_404() || is_category() || is_day() || is_month() || is_year() || is_search() || is_paged() ) { ?>

    <?php /* If this is a 404 page */ if(is_404()) { ?>
    <?php /* If this is a category archive */ } elseif (is_category()) { ?>
    <?php } ?>
    <?php }?>

    <?php endif; ?>

  </ul>
</div>
