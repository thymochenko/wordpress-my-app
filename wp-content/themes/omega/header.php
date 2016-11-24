<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<!-- theme -->
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
<!-- scrips -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.32/jquery.form.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.11.1/jquery.validate.min.js"></script>
<!-- stop scripts -->
<meta charset="<?php bloginfo( 'charset' ); ?>">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> <?php omega_attr( 'body' ); ?>>
<?php do_action( 'omega_before' ); ?>

<div class="modal fade bs-example-modal-sm" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">BAIXE AGORA EBOOK GRATUITO: Docker e WordPress</h4>
      </div>
      <div class="modal-body">
        <img style="margin-left:25px;"src="http://localhost/wp-content/themes/omega/images/DOCKER-EBOOK-LOGO.jpg" width="500" height="300"/>
      </div>
			<div style="margin-top:-35px;" class="modal-body">
        <form name="" id="" method="post" action="">
        <input style="margin-left:75px;" type="text" name="email" size="37"/><br>
        <input style="margin-left:75px;"  size="41" type="buttom" name="lead-ebook-docker" class="btn btn-default" data-dismiss="modal" value="RECEBER EBOOK DOCKER E WORDPRESS NO EMAIL">
      </form>
      </div>
    </div>
  </div>
</div>
<!-- closeModalBanner -->


<script>
$(function() {
	$("#mymodal").modal('show');
});

</script>
<div class="<?php echo omega_apply_atomic( 'site_container_class', 'site-container' );?>">
	<?php
	do_action( 'omega_before_header' );
	do_action( 'omega_header' );
	do_action( 'omega_after_header' );
	?>
	<div class="site-inner">
<?php do_action( 'omega_before_main' ); ?>
