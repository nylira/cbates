<?php get_header(); ?>
<?php get_sidebar(); ?>

<?php if(have_posts()) : while (have_posts()) : the_post(); ?>

	<div class="post" id="post-<?php the_ID(); ?>">

		<?php include('inc/postmeta.php'); ?>

		<h4><a href="<?php echo get_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
		<?php the_post_thumbnail(); ?><?php the_content('',FALSE,'');?>

		<div id="back" class="button_link">
			<a href="javascript:history.go(-1)">&laquo; <?php _e('Back to articles', 'specere'); ?></a>
		</div>

	</div>

	<?php
	
	//for use in the loop, list 5 post titles related to first tag on current post
	$tags = wp_get_post_tags($post->ID);
	if ($tags) {
  		echo "<div class=\"post\"><h4>You may also like:</h4>";
  		$first_tag = $tags[0]->term_id;
  		$args=array(
    		'tag__in' => array($first_tag),
    		'post__not_in' => array($post->ID),
    		'showposts'=>5,
    		'caller_get_posts'=>1
   			);
  		$my_query = new WP_Query($args);
  		if($my_query->have_posts() ) {
    		while ($my_query->have_posts()) : $my_query->the_post(); ?>
      
      <p class="default_box"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></p>
      </div>
      
    <?php
    	endwhile;
  			}
		}
	?>

	<div class="post">
		<?php echo comments_template(); ?>
	</div>

	<?php endwhile; else: ?>
		<p><?php _e('Sorry, no posts matched your criteria.', 'specere'); ?></p>
	<?php endif; ?>

<?php get_footer(); ?>