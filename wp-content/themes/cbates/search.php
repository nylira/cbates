<?php get_header(); ?>
<?php get_sidebar(); ?>

	<div class="post">

		<h4><?php _e('Search Results for', 'specere'); ?> &quot;<?php the_search_query() ?>&quot;</h4>							
		<p><?php _e('Below is a list of posts that contain your search term', 'specere'); ?> <span class="highlight">&quot;<?php the_search_query(); ?>&quot;</span>.</p> 

	</div>
		
	<?php if(have_posts()) : while (have_posts()) : the_post(); ?>

	<div class="post" id="post-<?php the_ID(); ?>">

		<?php include('inc/postmeta.php'); ?>
			
		<h4><a href="<?php echo get_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
		
		<?php the_excerpt(__('read more &rarr;', 'specere')); ?>

	</div>	

	<?php endwhile; else: ?>
		<div class="post">
		
			<h6>&mdash;<?php _e('Nothing found.', 'specere'); ?></h6>
			<p><?php _e('If you cannot find what you are looking for, please try again using a different search term for your search.', 'specere'); ?></p>
		</div>
	<?php endif; ?>
	
	<?php include('inc/postnav.php'); ?> 	

<?php get_footer(); ?>