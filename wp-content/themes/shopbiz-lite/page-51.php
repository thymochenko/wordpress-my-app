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
        <?php $q = new WP_Query('cat=-3,-8');  ?>
		<!-- Blog Area -->
			<div class="col-md-12" >
			<div class="col-md-9">
			<!-- /Blog Area -->
      <?php if ($q->have_posts()) :?>
        <?php while ($q->have_posts()) : $q->the_post();?>
<div class="col-md-4 wow pulse animated">
  <div class="ta-blog-post-box"> <a class="ta-blog-thumb" href="<?php the_permalink(); ?>" title="<?php the_title();?>">
   <?php $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );  ?>
    <img src="<?php echo $large_image_url[0] ?>" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="blog3" srcset="<?php echo $large_image_url[0] ?> 1024w, <?php echo $large_image_url[0] ?> 300w, <?php echo $large_image_url[0] ?> 768w" sizes="(max-width: 1024px) 100vw, 1024px" />            <span class="ta-blog-date"> <span class="h3"><?php the_time('d'); ?></span> <span style="font-size:10px"><?php the_time('F'); ?></span> </span> </a>
    <article class="small">
      <h2><a href="<?php the_permalink(); ?>" title="<?php the_title();?>"><?php the_title();?></a> </h2>
      <div class="ta-blog-category"> <i class="fa fa-folder"></i>&nbsp;
                        <a href="<?php the_title();?>" rel="category tag"><?php the_category(" ");?></a>                                <a href="<?php the_author_link(); ?>" <i class="fa fa-user"></i>&nbsp;<?php echo get_the_author(); ?>              </a> </div>
      <p><?php echo wp_trim_words( get_the_content(), 19, '...' ); ?></p>
     </article>
   </div>
 </div>
<?php endwhile; ?>
<?php else : ?>
<h2 class="center">Not Found</h2>
<p class="center">Sorry, but you are looking for something that isn't here.</p>
</div>
<?php endif; ?>

			</div>
			<!--Sidebar Area-->
			<aside class="col-md-3">
				<?php get_sidebar(); ?>
			</aside>
			<!--Sidebar Area-->
			</div>
		</div>
	</div>
</main>


<?php
get_footer();
?>
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
    //alert("porra");
    $("#myContactForm").validate({
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
                  url:"http://localhost/",
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
                          $('#_sucess').fadeIn();
                          $('#_preload').hide();
                      //});
                  }
              });
          }
      });

  });

</script>
