<div class="entry-meta">
	<time <?php omega_attr( 'entry-published' ); ?>><?php echo get_the_date(); ?></time>
	<?php echo omega_post_comments( array('before' => ' / ') ); ?>
	<?php edit_post_link( __('Edit', 'me'), ' / ' ); ?>
</div><!-- .entry-meta -->