<?php
/*
Template Name: Contact
*/
?>

<?php get_header(); ?>

	<div id="pageWrapper">
	<?php if(have_posts()) : while (have_posts()) : the_post(); ?>
    <?php global $more; $more = 0; the_content('read more &rarr;', 'specere'); ?>		
		
  <form id="contact_form" name="contact_form" method="post" action="<?php bloginfo('template_directory'); ?>/inc/contact_form.php" enctype="multipart/form-data">
    <input name="recipient" value="<?php echo get_option('of_contact_email'); ?>" type="hidden" />
    <ul class="fields">
      <li class="field">
        <input type="text" id="name" name="name" class="required" value="" minlength="3" placeholder="Your Name">
      <li class="field">
        <input type="text" id="email" name="email" class="required" value="" placeholder="Your Email Address">
      <li class="field">
        <textarea id="message" name="message" class="required" minlength="4" placeholder="Your Message"></textarea>
      <li class="field submit">
        <input type="submit" id="send_message" name="send_message" value="Send Message" />
    </ul>
  </form>


	<?php endwhile; else: ?>
		<p>
			<?php _e('Sorry, nothing matches that criteria.', 'specere'); ?>
		</p>
	<?php endif; ?>

	</div>

  <div class="champagne">
  <img src="<?php bloginfo('template_directory'); ?>/img/champagne.jpg">
  </div>
	
<?php get_footer(); ?>
