<?php // Do not delete these lines or your computer will explode
	if('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
	if(!empty($post->post_password)) { // if there's a password
	if($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
?>

<p><?php _e('This post is password protected. Enter the password to view comments.', 'specere'); ?></p>

<?php
	return;
	}
}

	/* This variable is for alternating comment background */
	$oddcomment = 'alt';
?>

<?php if($comments) : ?>

<div id="comments">

	<h2 class="comments_number">
		<?php comments_number(__('0 Comments', 'specere'), __('1 Comment so far', 'specere'), __('% Comments so far', 'specere')); ?>
	</h2>

	<ul id="commentlist">

		<?php foreach($comments as $comment) : ?>
		<li class="<?php echo $oddcomment; ?>" id="comment-<?php comment_ID() ?>">

	<?php if(the_author('', false) == get_comment_author())
		echo "<div class='singlecomment-admin'>";
		
		else
		echo "<div class='singlecomment'>";
	?>

		<p>
			<?php echo get_avatar($comment,'50','' ); ?><br />
			<span class="small">
				<?php comment_author_link()?><br />
				<?php comment_date('F j') ?><br />
			</span>
		</p>

	</div>

	<?php if($comment->comment_approved == '0') : ?>
		<em><?php _e('Your comment is awaiting moderation.', 'specere'); ?></em>
	<?php endif; ?>

		<?php if(the_author('', false) == get_comment_author())
			echo "<div class='commenttext-admin'>";
		else
			echo "<div class='commenttext'>";
		comment_text();
		echo "</div>";
		?>

	</li>

<?php endforeach; /* end for each comment */ ?>
</ul>
  
<?php else : // this is displayed if there are no comments so far ?>

<?php if ('open' == $post-> comment_status) : ?>

<!-- If comments are open, but there are no comments. -->
<?php else : // comments are closed ?>
 
<!-- If comments are closed. -->
<p class="nocomments"><?php _e('We\'re sorry, but comments are closed.', 'specere'); ?></p>
<?php endif; ?>

<?php if ('open' == $post-> comment_status) : ?>
<?php endif; // If registration required and not logged in ?>
<?php endif; // if you delete this your computer will explode ?>

<div id="commentsform">
  
<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php comment_form(); ?>

<?php do_action('comment_form', $post->ID); ?>
</form>
</div>
</div>
 <!-- End Commentsform -->
