<div class="avata-comments-area">
<?php

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'avata'); ?></p> 
	<?php
		return;
	}
?>

<?php if ( have_comments() ) : ?>
	<h3 id="comments"><?php comments_number(__('No comment', 'avata'), __('Has one comment', 'avata'), __('% comments', 'avata'));?> <?php printf(__('to &#8220;%s&#8221;', 'avata'), the_title('', '', false)); ?></h3>
<div class="upcomment"><?php _e('You can ','avata'); ?><a id="leaverepond" href="#comments"><?php _e('leave a reply','avata'); ?></a>  <?php _e(' or ','avata'); ?> <a href="<?php trackback_url(true); ?>" rel="trackback"><?php _e('Trackback','avata'); ?></a> <?php _e('this post.','avata'); ?></div>
	<ol id="thecomments" class="commentlist comments-list">
	<?php wp_list_comments('type=comment&callback=avata_comment');?>
	</ol>

<!-- comments pagenavi Start. -->
	<?php
	if (get_option('page_comments')) {
		$comment_pages = paginate_comments_links('echo=0');
		if ($comment_pages) {
?>
		<div id="commentnavi">
			<span class="pages"><?php _e('Comment pages', 'avata'); ?></span>
			<div id="commentpager">
				<?php echo $comment_pages; ?>
				
			</div>
			<div class="fixed"></div>
		</div>
<?php
		}
	}
?>

 <?php else :  ?>

	<?php if ( comments_open() ) : ?>

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments"></p>

	<?php endif; ?>
<?php endif; ?>


<?php if ( comments_open() ) : ?>

<div id="respond" class="respondbg">

<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
<p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.', 'avata'), wp_login_url( get_permalink() )); ?></p>
<?php else : ?>
<?php 

    add_filter( 'comment_form_default_fields', 'avata_comment_fields', 10 );
	function avata_comment_fields( $fields ) {
    		// get the current commenter if available
    		$commenter = wp_get_current_commenter();
 
    		// core functionality
    		$req      = get_option( 'require_name_email' );
    		$aria_req = ( $req ? " aria-required='true'" : '' );
    		$html_req = ( $req ? " required='required'" : '' );
			
			$fields =  array(

			'author' =>
			  '<div class="row"><section class="comment-form-author form-group col-md-4">
			  <label for="author" class="screen-reader-text">'. __( 'Name', 'avata' ).'</label> 
			  <input id="author" class="input-name form-control" name="author" placeholder="'.__('Name', 'avata'). ( $req ? ' *' : '' ).'"  type="text" value="' . esc_attr( $commenter['comment_author'] ) .
			  '" size="30" ' . $aria_req . $html_req. ' /></section>',
		
			'email' =>
			  '<section class="comment-form-email form-group col-md-4">
			  <label for="email" class="screen-reader-text">'. __( 'Email', 'avata' ).'</label> 
			  <input id="email" class="input-name form-control" name="email" placeholder="'.__('Email', 'avata'). ( $req ? ' *' : '' ).'"  type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
			  '" size="30" ' . $aria_req . $html_req. ' /></section>',
		
			'url' =>
			  '<section class="comment-form-url form-group col-md-4">
			  <label for="url" class="screen-reader-text">'. __( 'Website', 'avata' ).'</label> 
			  <input id="url" class="input-name form-control" placeholder="'.__('Website', 'avata').'" name="url"  type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .'" size="30" /></section></div>'
    );
	  
    		return $fields;
 
	}
 global $required_text;
 $comments_args = array(
      'class_submit' => 'submit btn btn-sm',
         'comment_notes_before' => '<p class="comment-notes">' .
    __( 'Your email address will not be published.', 'avata' ) . ( $req ? $required_text : '' ) .
    '</p>',
        // change the title of the reply section
        'title_reply'=>__('Leave a Reply', 'avata'),
        // remove "Text or HTML to be displayed after the set of comment fields"
        'comment_notes_after' => '',
        // redefine textarea (the comment body)
        'comment_field' => '<div class="clear"></div><p class="form-allowed-tags"></p><section class="comment-form-comment form-group"><div id="comment-textarea">
		 <label for="comment" class="screen-reader-text">'. __( 'Message', 'avata' ).'</label> 
		<textarea id="comment" name="comment" placeholder="'.__('Message', 'avata').' *"  cols="45" rows="8"  class="textarea-comment form-control" aria-required="true"></textarea></div></section>'
);

?>
<?php comment_form( $comments_args);?>

<?php endif;  ?>
</div>
<?php endif;  ?>
</div>