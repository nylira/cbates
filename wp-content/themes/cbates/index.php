<?php get_header(); ?>

<div id="pageWrapper">
<ul class="posts">
	<?php if(have_posts()) : while (have_posts()) : the_post(); ?>

		<li class="post excerpt" id="post-<?php the_ID(); ?>">
      <a href="<?php echo get_permalink() ?>" rel="bookmark">

        <h2><?php the_title(); ?></h2>
        <p class="time"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago'; ?></p>
        
        </a>

	<?php endwhile; else: ?>
		<li><?php _e('Sorry, there\'s nothing to see right now.', 'specere'); ?>
	<?php endif; ?>
</ul>

<?php include('inc/postnav.php'); ?> 
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
