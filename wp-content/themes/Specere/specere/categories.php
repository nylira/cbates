<?php
/*
Template Name: Categories
*/
?>

<?php get_header(); ?>
<?php get_sidebar(); ?>

	<h4><?php _e('Categories', 'specere'); ?></h4>
	
	<ul>
		<?php wp_list_categories(); ?>
	</ul>

	<h4><?php _e('Tags', 'specere'); ?></h4>
	
	<ul>
		<?php the_tags(' ', ',', ''); ?>
	</ul>

<?php get_footer(); ?>