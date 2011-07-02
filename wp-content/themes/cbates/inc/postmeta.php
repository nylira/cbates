<div class="postmeta">

	<img src="<?php bloginfo('template_directory'); ?>/img/clock.png" alt="Posted" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php _e('Posted about', 'specere'); ?> <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago'; ?> 
	<?php _e('by'); ?> <?php the_author() ?> &nbsp;&nbsp;&bull;
	<img src="<?php bloginfo('template_directory'); ?>/img/comment.png" alt="Comments" />
	&nbsp;&nbsp;<?php comments_popup_link('0 Comments', '1 Comment', '% Comments'); ?>
	<img src="<?php bloginfo('template_directory'); ?>/img/permalink.png" alt="Permalink" />&nbsp;&nbsp;<a class="tooltip" href="<?php echo get_permalink() ?>" rel="bookmark" title="Direct link to this post">Permalink</a>
	
	<div class="addthis_toolbox addthis_default_style"
	addthis:url="<?php echo get_permalink() ?>"
  	addthis:title="<?php the_title(); ?>">

			<a class="addthis_button" href="http://www.addthis.com/bookmark.php">
				<img src="<?php bloginfo('template_directory'); ?>/img/share.png" width="16" height="16" border="0" alt="Share" />
			</a>
  	
	</div>
	<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4d74e24611203d04"></script>
	
</div>