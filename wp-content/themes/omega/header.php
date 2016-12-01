<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <style>
  #mymodal{
    background-color:rgba(221, 221, 221, 0.9);
  }
  </style>
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

<div class="modal fade bs-example-modal-lg" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">EBOOK GRATUITO</h4>
      </div>
      <div class="modal-body">
        <img style="margin-left:25px;"src="http://localhost/wp-content/themes/omega/images/DOCKER-EBOOK-LOGO.jpg" width="500" height="300"/>
      </div>
			<div style="margin-top:-35px;" class="modal-body">
        <form id="modal-sqz-pg" name="_modal-sqz-pg"  method="post" action="http://localhost/wp-content/themes/omega/contactForm.php">
        <input style="margin-left:75px;" type="text" name="email" size="37"/><br>
        <input style="margin-left:75px;"  size="41" type="submit" name="lead-ebook-docker" class="btn btn-default" value="RECEBER EBOOK DOCKER E WORDPRESS NO EMAIL">
      </form>
      <br>
      <div id="sucess" class="alert alert-success"><strong>Ok!</strong> Verifique o Ebook no seu Email!</div>
<div id="error" class="alert alert-warning"><strong>Error!</strong> Erro ao solicitar Ebook</div>
<div id="preload"><img src="http://localhost/wp-content/themes/latinabigass/img/load.gif" width="100" height="100" /></div>

      </div>
    </div>
  </div>
</div>
<!-- closeModalBanner -->


<script>

		$(function() {
      $("#mymodal").modal('show');
      $('#sucess').hide();
      $('#error').hide();
      $('#preload').hide();

      $.validator.addMethod("simpleCaptcha", function(value, element) {
        if(value == 13){
          return true;
        }
      }, "A soma esta errada!");

			$('#myContactForm').validate({
						rules: {
								name: {
										required: true,
										minlength: 2
								},
								email: {
										required: true,
										email: true
								},
								captcha: {
										simpleCaptcha : true
								}
						},
						messages: {
								name: {
										required: "O campo nome é um campo que deve ser preenchido",
										minlength: "Você deve digitar 2 caracteres no minimo"
								},
								email: {
										required: "o campo email deve ser digitado"
								},
								msg: {
										required: "O campo mensagem deve ser preenchido",
										minlength: "tudo isso?"
								},
                captcha: {
                  required: "O campo captcha deve ser preenchido",
                  minlength: "tudo isso?"
                }
						},
						submitHandler: function(form) {
								$(form).ajaxSubmit({
										type:"POST",
                    url:"http://localhost/wp-content/themes/omega/contactForm.php",
										data: $(form).serialize(),
                    beforeSend: function (){
											$("#_preload").fadeIn();
										},
										success: function() {
													//  $('#contact').fadeTo( "slow", 0.15, function() {
														$(this).find(':input').attr('disabled', 'disabled');
														$('#_sucess').fadeIn();
														$('#_preload').hide();
												//});
										},
										error: function() {
												//$('#contact').fadeTo( "slow", 0.15, function() {
												    $('#_error').fadeIn();
												//});
										}
								});
						}
				});



        			$('#modal-sqz-pg').validate({
        						rules: {
        								email: {
        										required: true,
        										email: true
        								}
        						},
        						messages: {
        								email: {
        										required: "Coloque o seu melhor email"
        								}
        						},
        						submitHandler: function(form) {
        								$(form).ajaxSubmit({
        										type:"POST",
        										data: $(form).serialize(),
        										url:"http://localhost/wp-content/themes/omega/contactForm.php",
                            beforeSend: function (){
        											$("#preload").fadeIn();
        										},
        										success: function() {
        													//  $('#contact').fadeTo( "slow", 0.15, function() {
        														$(this).find(':input').attr('disabled', 'disabled');
        														$('#sucess').fadeIn();
        														$('#preload').hide();
        												//});
        										},
        										error: function() {
        												//$('#contact').fadeTo( "slow", 0.15, function() {
        												    $('#error').fadeIn();
        												//});
        										}
        								});
        						}
        				});

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
