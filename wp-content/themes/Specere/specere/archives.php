<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>
<?php get_sidebar(); ?>

	<h4><?php _e('Archives by Month:', 'specere'); ?></h4>
	
	<ul>
		<?php wp_get_archives('type=monthly'); ?>
	</ul>

<?php get_footer(); ?>