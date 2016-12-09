<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @package shopbiz
 */

get_header(); ?>
<?php get_template_part('index','banner'); ?>
<main id="content">
    <div class="container">
      <div class="row">
		<!-- Blog Area -->
			<?php if( class_exists('woocommerce') && (is_account_page() || is_cart() || is_checkout())) { ?>
			<div class="col-md-12" >
			<?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
			<?php the_content(); ?>
			<?php endwhile; else : endif; ?>
			<?php } else { ?>
			<div class="col-md-9">
			<?php if( have_posts()) :  the_post(); ?>
			<?php the_content(); ?>
				<?php endif; ?>
				<?php comments_template( '', true ); // show comments ?>
			<!-- /Blog Area -->
			</div>
			<!--Sidebar Area-->
			<aside class="col-md-3">
				<?php get_sidebar(); ?>
			</aside>
			<?php } ?>
			<!--Sidebar Area-->
			</div>
		</div>
	</div>
</main>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.32/jquery.form.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.11.1/jquery.validate.min.js"></script>
<script>

  $(function() {


    $('#_sucess').hide();
    $('#_error').hide();
    $('#_preload').hide();

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
              msg: {
                required: true
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
                  url:"http://localhost/wp-content/themes/shopbiz-lite/contactForm.php",
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

  });

</script>

<?php
get_footer();
