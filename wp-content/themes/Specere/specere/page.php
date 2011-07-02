<?php get_header(); ?>
<?php get_sidebar(); ?>

	<div id="pageWrapper">
	<?php if(have_posts()) : while (have_posts()) : the_post(); ?>

		<?php global $more; $more = 0; the_content('read more &raquo;', 'specere'); ?>	

	<?php endwhile; else: ?>
		<p>
			<?php _e('Sorry, nothing matches that criteria.', 'specere'); ?>
		</p>
	<?php endif; ?>

	<?php wp_link_pages('before=<div class="more-link postnavi"><ul class="pagination"><li>&after=</li></ul></div>'); ?>
	</div>

<?php get_footer(); ?>