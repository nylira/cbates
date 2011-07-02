<?php
/*
Template Name: Contact
*/
?>

<?php get_header(); ?>
<?php get_sidebar(); ?>

	<div id="pageWrapper">
	<?php if(have_posts()) : while (have_posts()) : the_post(); ?>
		
	<div id="contact">
		
		<div class="one_full">
			<?php global $more; $more = 0; the_content('read more &rarr;', 'specere'); ?>		
		</div>
		
		<div class="one_full">
			
			<h4><?php _e('Contact form', 'specere'); ?></h4>
			
			<form id="contact_form" name="contact_form" method="post" action="<?php bloginfo('template_directory'); ?>/inc/contact_form.php" enctype="multipart/form-data">

				<input name="recipient" value="<?php echo get_option('of_contact_email'); ?>" type="hidden" />
				
				<label for="name"><?php _e('Your Name:', 'specere'); ?></label>
				<input type="text" id="name" name="name" class="required" value="" minlength="3" />
				
				<label for="email"><?php _e('Your Email Address:', 'specere'); ?></label>
				<input type="text" id="email" name="email" class="required" value="" />
				
				<label for="message"><?php _e('Your Message:', 'specere'); ?></label>
				<textarea id="message" name="message" class="required" minlength="4"></textarea>
				
				<input type="submit" id="send_message" name="send_message" value="Send Message" />
			</form>
		</div>
	</div>

	<?php endwhile; else: ?>
		<p>
			<?php _e('Sorry, nothing matches that criteria.', 'specere'); ?>
		</p>
	<?php endif; ?>

	<?php wp_link_pages('before=<div class="postnavi"><ul class="pagination"><li>&after=</li></ul></div>'); ?>
	</div>
	
<?php get_footer(); ?>
