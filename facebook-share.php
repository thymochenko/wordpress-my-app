
<div id="fb-root"></div>
<script>(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.8&appId=1799355743614933";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<! -- share facebook -->
<?php if(is_single() && have_posts()):
while(have_posts()): the_post(); ?>
  <meta property="og:url"           content="<?php echo get_permalink(); ?>" />
  <meta property="og:type"          content="website" />
  <meta property="fb:app_id" content="1799355743614933">
  <meta property="og:title"         content="<?php the_title(); ?>" />
  <meta property="og:description"   content="<?php $content = get_the_content(); echo mb_strimwidth($content, 0, 100, '...'); ?>"/>
  <meta property="og:image"         content=" <?php $img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );echo $img[0]; ?>" />
  <! -- end-->
 <?php endwhile; ?>
<?php elseif(is_home()): ?>
  <meta property="og:url"           content="<?php echo get_permalink(); ?>" />
  <meta property="og:type"          content="website" />
  <meta property="fb:app_id" content="1799355743614933">
  <meta property="og:title"         content="Timo Cabral - Cursos de Desenvolvimento e criação de sites" />
  <meta property="og:description"   content="Cursos gratuitos, dicas, tutoriais sobre desenvolvimento de software, aplicativos "/>
  <meta property="og:image"         content="http://timocabral-bucket.s3-us-west-2.amazonaws.com/wp-content/uploads/2017/01/software-development.jpg" />
  <! -- end-->
<?php endif;?>
