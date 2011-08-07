<?php /* Template Name: Home */ ?>

<?php get_header(); ?>

<div id="slideshow">
  <ul class="slides">
    <li class="slide"><img src="<?php bloginfo('template_directory'); ?>/img/slides/engagement.jpg">
    <li class="slide"><img src="<?php bloginfo('template_directory'); ?>/img/slides/events.jpg">
    <li class="slide"><img src="<?php bloginfo('template_directory'); ?>/img/slides/film.jpg">
    <li class="slide"><img src="<?php bloginfo('template_directory'); ?>/img/slides/film2.jpg">
    <li class="slide"><img src="<?php bloginfo('template_directory'); ?>/img/slides/lzdeadii.jpg">
    <li class="slide"><img src="<?php bloginfo('template_directory'); ?>/img/slides/wedding.jpg">
    <li class="slide"><img src="<?php bloginfo('template_directory'); ?>/img/slides/music.jpg">
  </ul>
</div>

<script src="<?php bloginfo('template_directory'); ?>/js/jquery.cycle.all.js"></script>
<script>
  $('ul.slides').cycle();
</script>

<?php get_footer(); ?>
