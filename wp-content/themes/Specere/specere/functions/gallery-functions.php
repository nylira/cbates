<?php

/* 

Multiple Image Uploader based of origial plugin by bitinn
http://wordpress.org/extend/plugins/faster-image-insert/

*/

function gallery_insert_form() {
  global $post_ID, $temp_ID;
  $id = (int) (0 == $post_ID ? $temp_ID : $post_ID);

  $upload_form = 'gallery_insert_upload_form';
  $noflash = get_option( $upload_form );

?>
<script type="text/javascript">
/* <![CDATA[ */
  jQuery(function($) {
    //intialize
    $('#screen-meta').ready(function() {
      var view = $('#galleryinsert-hide').is(':checked');
      if(view) {
	    <?php if($id > 0) { ?>
        $('#galleryinsert > .inside').html('<iframe frameborder="0" name="gallery_insert" id="gallery_insert" src="<?php echo get_option("siteurl") ?>/wp-admin/media-upload.php?post_id=<?php if($noflash) echo $id.'&#038;flash=0'; else echo $id; ?>&#038;type=image&#038;tab=type" hspace="0"> </iframe>');
        <?php } else { ?>
        $('#galleryinsert > .inside').html('<p><?php _e('Click here to reload after autosave. Or manually save the draft.', 'gallery-image-insert') ?></p>');
        <?php } ?>
      }
    });
    //toggle metabox
    $('#screen-meta #galleryinsert-hide').click(function() {
      var view = $('#galleryinsert-hide').is(':checked');
      if(view) {
	    <?php if($id > 0) { ?>
        $('#galleryinsert > .inside').html('<iframe frameborder="0" name="gallery_insert" id="gallery_insert" src="<?php echo get_option("siteurl") ?>/wp-admin/media-upload.php?post_id=<?php if($noflash) echo $id.'&#038;flash=0'; else echo $id; ?>&#038;type=image&#038;tab=type" hspace="0"> </iframe>');
        <?php } else { ?>
        $('#galleryinsert > .inside').html('<p><?php _e('Click here to reload after autosave. Or manually save the draft.', 'gallery-image-insert') ?></p>');
        <?php } ?>
      }
    });
    <?php if($id < 0) { ?>
	//update state after autosave, bind load event.
    $('#galleryinsert').click(function() {
	  var newid = $('#post_ID').val();
	  if(notSaved == false && newid > 0) {
	    $('#galleryinsert > .inside').html('<iframe frameborder="0" name="gallery_insert" id="gallery_insert" src="<?php echo get_option("siteurl") ?>/wp-admin/media-upload.php?post_id='+newid+'<?php if($noflash) echo '&#038;flash=0'; ?>&#038;type=image&#038;tab=type" hspace="0"> </iframe>');
        $('#gallery_insert').bind("load", function() {
	      if($(this).contents().find('#media-upload').length < 1) {
	        document.getElementById('gallery_insert').contentWindow.location.href = document.getElementById('gallery_insert').contentWindow.location.href;
          }
        });
      }
    });
	<?php } ?>
    <?php if($id > 0) { ?>
	//update state on insert
    $('#gallery_insert').bind("load", function() {
	  if($(this).contents().find('#media-upload').length < 1) {
	    document.getElementById('gallery_insert').contentWindow.location.href = document.getElementById('gallery_insert').contentWindow.location.href;
      }
    });
	<?php } ?>
  });
/* ]]> */
</script>
<?php
}

//replace several scripts for new functions.
function gallery_image_insert() 
{
  //since FII 2.0.0: spot wordpress 3.0+ automagically
  global $wp_version;
  if (version_compare($wp_version, '3.0', '>=')) {
    $compat = true;
  } else {
    $compat = false;
  }
  
  //upload supported custom post type
  $customtype = 'gallery_insert_post_type';
  $ptype = get_option( $customtype );
  
  //integrates manager into page edit inferface.
  if($compat) {
    add_meta_box('galleryinsert', 'Fullscreen Gallery Images', 'gallery_insert_form', 'page', 'normal', 'high');
    $ptypes = explode(",",$ptype);
    foreach ($ptypes as $type) add_meta_box('galleryinsert', 'Gallery Insert', 'gallery_insert_form', $type, 'normal', 'high');
  } else {
    add_meta_box('galleryinsert', 'Fullscreen Gallery Images', 'gallery_insert_form_notice', 'page', 'normal', 'high');
  }
}

// various javascript / css goodies for:
// 1. selected insert
// 2. mass-editing
// 3. styling for iframe and mass-edit table
function gallery_insert_local() {
  
?>
<script type="text/javascript">
/* <![CDATA[ */  
  jQuery(function($) {
  
    //bind current elements and add checkbox
    $('#media-items .new').each(function(e) {
      var id = $(this).parent().attr('id');
      id = id.split("-")[2];
      $(this).prepend('<input type="checkbox" class="item_selection" title="<?php _e('Select items you want to insert','gallery-image-insert'); ?>" id="attachments[' + id.substring() + '][selected]" name="attachments[' + id + '][selected]" value="selected" /> ');
    });
    
    //bind future elements and add checkbox
    $('.ml-submit').live('mouseenter',function(e) {
      $('#media-items .new').each(function(e) {
        var id = $(this).parent().children('input[value="image"]').attr('id');
        id = id.split("-")[2];
        $(this).not(':has("input")').prepend('<input type="checkbox" class="item_selection" title="<?php _e('Select items you want to insert','gallery-image-insert'); ?>" id="attachments[' + id.substring() + '][selected]" name="attachments[' + id + '][selected]" value="selected" /> ');
      });
      //$('.ml-submit').die('mouseenter');
    });
    
    //buttons for enhanced functions
    $('.ml-submit:first').append('<input type="submit" class="button savebutton" name="insertall" id="insertall" value="<?php echo esc_attr( __( 'Insert selected images', 'gallery-image-insert') ); ?>" /> ');  
    $('.ml-submit:first').append('<input type="submit" class="button savebutton" name="invertall" id="invertall" value="<?php echo esc_attr( __( 'Select All', 'gallery-image-insert') ); ?>" /> ');
    $('.ml-submit #invertall').click(
      function(){
        $('#media-items .item_selection').each(function(e) {
          if($(this).is(':checked')) $(this).attr("checked","");
          else $(this).attr("checked","checked");
        });
        return false;
      }
    );
    
    //mass-editing is default function for FII 2.0+
    if($('#gallery-settings').length > 0) {
      $('#gallery-settings').before('<div id="mass-edit"><div class="title"><?php _e('Mass Image Edit','gallery-image-insert'); ?></div></div>');
      $('#gallery-settings .describe').clone().appendTo('#mass-edit');
      $('#mass-edit .describe tr:eq(0)').clone().prependTo("#mass-edit .describe tbody");
      $('#mass-edit').append('<p class="ml-submit"><input type="button" class="button" name="massedit" id="massedit" value="<?php _e('Apply changes','gallery-image-insert'); ?>" /> <span><?php _e('Press "Save all changes" above to save. Only Title, Alt-Text and Caption are permanently saved.','gallery-image-insert'); ?></span></p>');

      //setup the form
      $('#mass-edit tr:eq(0) .alignleft').html('<?php _e('Image Titles','gallery-image-insert'); ?>');
      $('#mass-edit tr:eq(1) .alignleft').html('<?php _e('Image Alt-Texts','gallery-image-insert'); ?>');
      $('#mass-edit tr:eq(2) .alignleft').html('<?php _e('Image Captions','gallery-image-insert'); ?>');
      $('#mass-edit tr:eq(3) .alignleft').html('<?php _e('Image Alignment','gallery-image-insert'); ?>');
      $('#mass-edit tr:eq(4) .alignleft').html('<?php _e('Image Sizes','gallery-image-insert'); ?>');
    
      $('#mass-edit tr:eq(0) .field').html('<input type="text" name="title_edit" id="title_edit" value="" />');
      $('#mass-edit tr:eq(1) .field').html('<input type="text" name="alttext_edit" id="alttext_edit" value="" />');
      $('#mass-edit tr:eq(2) .field').html('<input type="text" name="captn_edit" id="captn_edit" value="" />');
      $('#mass-edit tr:eq(3) .field').html('<input type="radio" name="align_edit" id="align_none" value="none" />\n<label for="align_none" class="radio"><?php _e('None') ?></label>\n<input type="radio" name="align_edit" id="align_left" value="left" />\n<label for="align_left" class="radio"><?php _e('Left') ?></label>\n<input type="radio" name="align_edit" id="align_center" value="center" />\n<label for="align_center" class="radio"><?php _e('Center') ?></label>\n<input type="radio" name="align_edit" id="align_right" value="right" />\n<label for="align_right" class="radio"><?php _e('Right') ?></label>');
      $('#mass-edit tr:eq(4) .field').html('<input type="radio" name="size_edit" id="size_thumb" value="thumbnail" />\n<label for="size_thumb" class="radio"><?php _e('Thumbnail') ?></label>\n<input type="radio" name="size_edit" id="size_medium" value="medium" />\n<label for="size_medium" class="radio"><?php _e('Medium') ?></label>\n<input type="radio" name="size_edit" id="size_large" value="large" />\n<label for="size_large" class="radio"><?php _e('Large') ?></label>\n<input type="radio" name="size_edit" id="size_full" value="full" />\n<label for="size_full" class="radio"><?php _e('Full size') ?></label>');

      //read value and apply
      $('#massedit').click(function() {
        var massedit = new Array();
        massedit[0] = $('#mass-edit .describe #title_edit').val();
        massedit[1] = $('#mass-edit .describe #alttext_edit').val();
        massedit[2] = $('#mass-edit .describe #captn_edit').val();
        massedit[3] = $('#mass-edit tr:eq(3) .field input:checked').val();
        massedit[4] = $('#mass-edit tr:eq(4) .field input:checked').val();
        //alert(massedit);
        var num_count = 0;
        $('.media-item').each(function(e) {
          num_count++;
          if(typeof massedit[0] !== "undefined" && massedit[0].length > 0) {
            $(this).find('.post_title .field input').val(massedit[0] + " (" + num_count + ")");
          }
          if(typeof massedit[1] !== "undefined" && massedit[1].length > 0) {
            $(this).find('.image_alt .field input').val(massedit[1] + " (" + num_count + ")");
          }
          if(typeof massedit[2] !== "undefined" && massedit[2].length > 0) {
            $(this).find('.post_excerpt .field input').val(massedit[2]);
          }
          if(typeof massedit[3] !== "undefined" && massedit[3].length > 0) {
            $(this).find('.align .field input[value='+massedit[3]+']').attr("checked","checked");
          }
          if(typeof massedit[4] !== "undefined" && massedit[4].length > 0) {
            $(this).find('.image-size .field input[value='+massedit[4]+']').attr("checked","checked");
          }
        });
      });
    }
  });

/* ]]> */
</script>
<style type="text/css" media="screen">
#gallery_insert{width:100%;height:500px;}
#mass-edit { display: none; }
#mass-edit th.label{width:160px;}
#mass-edit #basic th.label{padding:5px 5px 5px 0;}
#mass-edit .title{clear:both;padding:0 0 3px;border-bottom-style:solid;border-bottom-width:1px;font-family:Georgia,"Times New Roman",Times,serif;font-size:1.6em;border-bottom-color:#DADADA;color:#5A5A5A;}
#mass-edit .describe td{vertical-align:middle;height:3.5em;}
#mass-edit .describe th.label{padding-top:.5em;text-align:left;}
#mass-edit .describe{padding:5px;width:615px;clear:both;cursor:default;}
#mass-edit .describe select,#mass-edit .describe input[type=text]{width:15em;border:1px solid #dfdfdf;}
#mass-edit label,#mass-edit legend{font-size:13px;color:#464646;margin-right:15px;}
#mass-edit .align .field label{margin:0 1.5em 0 0;}
#mass-edit p.ml-submit{border-top:1px solid #dfdfdf;}
#mass-edit select#columns{width:6em;}
</style>
<?php
}

//used for passing content to edit panel.
function gallery_insert_to_editor($html) {
?>
<script type="text/javascript">
/* <![CDATA[ */
var win = window.dialogArguments || opener || parent || top;
win.send_to_editor('<?php echo str_replace('\\\n','\\n',addslashes($html)); ?>');
/* ]]> */
</script>
  <?php
  exit;
}

//catches the insert selected images post request.
function gallery_insert_form_handler() {
  global $post_ID, $temp_ID;
  $post_id = (int) (0 == $post_ID ? $temp_ID : $post_ID);
  check_admin_referer('media-form');
  
  //load settings
  $customstring = 'gallery_insert_plugin_custom';
  $cstring = get_option( $customstring );
  
  $line_number = 'gallery_insert_line_number';
  $number = get_option( $line_number );
  
  $image_line = 'gallery_insert_image_line';
  $oneline = get_option( $image_line );
  
  if(!is_numeric($number)) $number = 4;

  //modify the insertion string
  if ( !empty($_POST['attachments']) ) {
    $result = '';
    foreach ( $_POST['attachments'] as $attachment_id => $attachment ) {
      $attachment = stripslashes_deep( $attachment );
      if (!empty($attachment['selected'])) {
        $html = $attachment['post_title'];
        if ( !empty($attachment['url']) ) {
          if ( strpos($attachment['url'], 'attachment_id') || false !== strpos($attachment['url'], get_permalink($post_id)) )
            $rel = " rel='attachment wp-att-".esc_attr($attachment_id)."'";
          $html = "$html";
        }
        $html = apply_filters('media_send_to_editor', $html, $attachment_id, $attachment);
        //since 1.5.0: &nbsp; is the same as a blank space, but can be passed onto TinyMCE
        if(!$oneline) $result .= $html.str_repeat("\\n".$cstring."\\n",$number);
        else $result .= $html.str_repeat($cstring,$number);
      }
    }
    return gallery_insert_to_editor($result);
  }

  return $errors;
}

//filter for media_upload_gallery, recognize insertall request.
function gallery_insert_media_upload_gallery() {
  if ( isset($_POST['insertall']) ) {
    $return = gallery_insert_form_handler();
    
    if ( is_string($return) )
      return $return;
    if ( is_array($return) )
      $errors = $return;
  }
}

//filter for media_upload_image, recognize insertall request.
function gallery_insert_media_upload_image() {
  if ( isset($_POST['insertall']) ) {
    $return = gallery_insert_form_handler();
    
    if ( is_string($return) )
      return $return;
    if ( is_array($return) )
      $errors = $return;
  }
}

//filter for media_upload_library, recognize insertall request.
function gallery_insert_media_upload_library() {
  if ( isset($_POST['insertall']) ) {
    $return = gallery_insert_form_handler();
    
    if ( is_string($return) )
      return $return;
    if ( is_array($return) )
      $errors = $return;
  }
}

//hook it up
add_action('admin_menu', 'gallery_image_insert', 20);
add_action('admin_head', 'gallery_insert_local');
add_filter('media_upload_gallery', 'gallery_insert_media_upload_gallery');
add_filter('media_upload_library', 'gallery_insert_media_upload_library');
add_filter('media_upload_image', 'gallery_insert_media_upload_image');

?>