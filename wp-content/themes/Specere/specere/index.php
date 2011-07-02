<?php get_header(); ?>
<?php get_sidebar(); ?>

	<?php if(have_posts()) : while (have_posts()) : the_post(); ?>

		<div class="post" id="post-<?php the_ID(); ?>">

			<?php include('inc/postmeta.php'); ?>
			
			<h4><a href="<?php echo get_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
			
			<?php $post_display = array(get_option('of_post_display')); if($post_display[0] == 'content') { ?>
				<?php the_post_thumbnail(); ?><?php the_content(__('read more &raquo;', 'specere'));?>
				
			<?php } elseif($post_display[0] == 'excerpt') { ?>
			
				<?php the_post_thumbnail(); ?><?php the_excerpt(__('read more &raquo;', 'specere'));?>
			<?php } ?>

		</div>

	<?php endwhile; else: ?>
		<p><?php _e('Sorry, there\'s nothing to see right now.', 'specere'); ?></p>
	<?php endif; ?>

<?php include('inc/postnav.php'); ?> 

<?php get_footer(); ?>