<?php get_header(); ?>

<ul class="posts">
	<?php if(have_posts()) : while (have_posts()) : the_post(); ?>

		<li class="post excerpt" id="post-<?php the_ID(); ?>">
      <a href="<?php echo get_permalink() ?>" rel="bookmark">

        <h2><?php the_title(); ?></h2>
        <p class="time"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago'; ?></p>
        
        </a>
		</li>

	<?php endwhile; else: ?>
		<p><?php _e('Sorry, there\'s nothing to see right now.', 'specere'); ?></p>
	<?php endif; ?>
</ul>

<?php get_sidebar(); ?>
<?php include('inc/postnav.php'); ?> 
<?php get_footer(); ?>
