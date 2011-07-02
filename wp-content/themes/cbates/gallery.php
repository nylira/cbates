<?php
/*
Template Name: Gallery
*/
?>

<?php get_header(); ?>
			
		<div id="imageWrapper">
			<div id="image_scroller">
				<div class="container">
						
					<?php if(have_posts()) : while (have_posts()) : the_post(); ?>
					
					<?php
					// Get the all post content in a variable
					$posttext = $post->post_content;
					$posttext1 = $post->post_content;
 
					// Search for the src="" in the post content
					$regular_expression = '~src="[^"]*"~';
					$regular_expression1 = '~<img [^\>]*\ />~';
 
					// Grab all the images from the post in an array $allpics using preg_match_all
					preg_match_all( $regular_expression, $posttext, $allpics );
 
					// Count the number of images found.
					$NumberOfPics = count($allpics[0]);
 
					// This time we replace/remove the images from the content
					$only_post_text = preg_replace($regular_expression1, '' , $posttext1);
					
					/*Only text will be printed*/
					echo $only_post_text;
 
					// Check to see if we have at least 1 image
					if ($NumberOfPics > 0) {
 
					for ($i=0; $i < $NumberOfPics ; $i++) {           
					$str1=$allpics[0][$i];
					$str1=trim($str1);
					$len=strlen($str1);
					$imgpath=substr_replace(substr($str1,5,$len),"",-1);
					
					?>

						<div class="image">
							<a href="#">
								<img src="<?php bloginfo('template_directory'); ?>/inc/timthumb.php?src=<?php echo $imgpath; ?>&h=120&w=180&zc=1" alt="<?php echo $imgpath; ?>" class="thumb" />
							</a>
						</div>
					<?php }; }; ?>
						
					<?php endwhile; endif; ?>
														
				</div>
			</div>
		</div>
			
	<div id="toggle">View Thumbs</div>
			
	</div>

<?php get_footer(); ?>
