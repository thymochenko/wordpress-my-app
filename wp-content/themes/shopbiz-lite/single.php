<!-- =========================
     Page Breadcrumb : posts page
============================== -->

<?php get_header();
get_template_part('index','banner'); ?>
<div class="clearfix"></div>
<!-- =========================
     Page Content Section
============================== -->

 <main id="content">
  <div class="container">
    <div class="row">
      <!--/ Main blog column end -->

      <div class="col-md-<?php echo ( !is_active_sidebar( 'sidebar_primary' ) ? '12' :'9' ); ?> col-md-9">
        <div class="row">
		      <?php if(have_posts())
		        {
		      while(have_posts()) { the_post(); ?>
          <div class="col-md-12">
            <div class="ta-blog-post-box"> <a href="#" class="ta-blog-thumb">
			        <?php if(has_post_thumbnail()): ?>
			         <?php $defalt_arg =array('class' => "img-responsive"); ?>
			         <?php the_post_thumbnail('', $defalt_arg); ?>
                <span class="ta-blog-date"> <span class="h3"><?php echo esc_attr(get_the_date('j')); ?></span>
                  <span><?php echo esc_attr(get_the_date('M')); ?></span>
                </span>
			        <?php endif; ?></a>
              <article class="small">
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<!-- facebook  -->

	               <div class="fb-share-button"

		               data-href="<?php echo get_permalink(); ?>"

		                 data-layout="button_count">

	                  </div>

                    <!-- endfacebook -->
<div class="ta-blog-category">
                  <i class="fa fa-folder"></i>&nbsp;
                  <?php $cat_list = get_the_category_list();
				          if(!empty($cat_list)) { ?> <?php the_category(', '); ?>
                  <?php } ?>
                  <a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) ));?>">
                    <i class="fa fa-user"></i> <?php the_author(); ?>
                  </a>
                </div>
                <?php the_content(); ?>
                <!-- form call to action -->
                <section class="ta-subscriber" style="background-image:url('https://themeansar.com/demo/wp/shopbiz/default/wp-content/uploads/2016/11/sub-back.jpg');">
                  <div class="overlay" style="background-color:">
                    <div class="container">
                      <div class="row">
                        <div class="col-md-6 col-md-offset-1 text-center">
                          <h4>Você Quer receber atualizações, promoções, videos, conteúdo exclusivo gratuito?</h4>          <h2>Coloque aqui o seu melhor <span>Email</span></h2>          <!-- MAILCHIMP SUBSCRIBE FORM -->
                          <form id="newslleter" name="newslleter" class="_subscription-form ma_ilchimp f_orm-inline_" method="POST" action="http://localhost">
                						<input type="hidden" name="method" value="newslleter">
                            <!-- SUBSCRIPTION SUCCESSFUL OR ERROR MESSAGES -->
                            <h6 class="subscription-success"></h6>
                            <h6 class="subscription-error"></h6>

                            <!-- EMAIL INPUT BOX -->
                            <input type="email" name="email" id="subscriber-email_" placeholder="Seu Email" class="form-control email int-box_">

                            <!-- SUBSCRIBE BUTTON -->
                            <button type="submit" id="subscribe-button_" class="btn btn-theme">
                            Assinar            </button>
                          </form>
                					<!-- mensagens form -->
                					<div id="sucess" class="alert alert-success"><strong>Ok!</strong> Verifique o Ebook no seu Email!</div>
                					<div id="error" class="alert alert-warning"><strong>Error!</strong> Erro ao solicitar Ebook</div>
                					<div id="preload"><img src="<?php echo get_site_url(); ?>/wp-content/themes/latinabigass/img/load.gif" width="100" height="100" /></div>
                          <!-- end message form -->

                          <!-- /END SUBSCRIPTION FORM -->
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
                <!-- form call to action -->
              </article>
            </div>
          </div>
		      <?php } ?>

          <div class="col-md-12">
            <div class="media ta-info-author-block"> <a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) ));?>" class="ta-author-pic"> <?php echo get_avatar( get_the_author_meta( 'ID') , 150); ?> </a>
              <div class="media-body">
                <h4 class="media-heading"><span><i class="fa fa-user"></i>By</span><a href "<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) ));?>"><?php the_author(); ?></a></h4>
                <p><?php the_author_meta( 'description' ); ?></p>
                <div class="row">
                  <div class="col-md-6 col-pad7">
                    <ul class="list-inline info-author-social">
          					<?php
          					$facebook_profile = get_the_author_meta( 'facebook_profile' );
          					if ( $facebook_profile && $facebook_profile != '' ) {
          					echo '<li class="facebook"><a href="' . esc_url($facebook_profile) . '"><i class="fa fa-facebook-square"></i></a></li>';
          					}

          					$twitter_profile = get_the_author_meta( 'twitter_profile' );
          					if ( $twitter_profile && $twitter_profile != '' )
          					{
          					echo '<li class="twitter"><a href="' . esc_url($twitter_profile) . '"><i class="fa fa-twitter-square"></i></a></li>';
          					}

          					$google_profile = get_the_author_meta( 'google_profile' );
          					if ( $google_profile && $google_profile != '' ) {
          					echo '<li class="googleplus"><a href="' . esc_url($google_profile) . '" rel="author"><i class="fa fa-google-plus-square"></i></a></li>';
          					}
          					$linkedin_profile = get_the_author_meta( 'linkedin_profile' );
          					if ( $linkedin_profile && $linkedin_profile != '' ) {
          					   echo '<li class="linkedin"><a href="' . esc_url($linkedin_profile) . '"><i class="fa fa-linkedin-square"></i></a></li>';
          					}
          					?>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
		      <?php } ?>
         <?php comments_template('',true); ?>
        </div>
      </div>
      <div class="col-md-3">
      <?php get_sidebar(); ?>
      </div>
    </div>
    <!--/ Row end -->
  </div>
</main>
<style>
#mymodal{
  background-color:rgba(221, 221, 221, 0.9);
}
</style>
<!-- <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">-->
<!-- theme -->
<!--<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">-->
<!-- scrips -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.32/jquery.form.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.11.1/jquery.validate.min.js"></script>
<script>

  $(function() {
$('input[name="ebook_hidden"]:hidden').val($("#modal-download-start").val());
    $("#modal-download-start").click(function(){
        alert($("#modal-download-start").val());
        $("#mymodal").modal('show');


    });


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
                  url:"<?php echo get_site_url() ?>",
                  data: $(form).serialize(),
                  beforeSend: function (){
                    data['button'] = $("#modal-download-start").val();
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

      $('#sucess').hide();
      $('#error').hide();
      $('#preload').hide();

      $('#newslleter').validate({
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
                     url:"<?php echo get_site_url(); ?>",
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



            $('#modal-ebook-download').validate({
                  rules: {
                      email: {
                          required: true,
                          email: true
                      },
                      nome: {
                          required: true
                      },
                  },
                  messages: {
                      email: {
                          required: "Coloque o seu melhor email"
                      },
                      nome: {
                              required: "Coloque o seu nome"
                          }
                  },
                  submitHandler: function(form) {
                      $(form).ajaxSubmit({
                          type:"POST",
                          data: $(form).serialize(),
                          url:"<?php echo get_site_url(); ?>/wp-content/themes/shopbiz-lite/contactForm.php",
                          beforeSend: function (){
                            $("#preload").fadeIn();
                          },
                          success: function() {
                                //  $('#contact').fadeTo( "slow", 0.15, function() {
                                  $(this).find(':input').attr('disabled', 'disabled');
                                  alert(data);
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

<?php get_footer(); ?>
