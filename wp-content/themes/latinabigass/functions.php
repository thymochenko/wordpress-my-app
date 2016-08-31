  <?php
  //register menus
  function register_my_menus() {
    register_nav_menus(
      array( 'header-menu' => __( 'Header Menu' ) )
    );
  }

  add_action( 'init', 'register_my_menus' );
  // register widgets
  function osmag_widgets_init() {
  	register_sidebar (array(
  		'name'          => __('Sidebar','osmag'),
  		'id'            => "sidebar-widget-area",
  		'before_widget' => '<li id="%1$s" class="widget %2$s">',
  		'after_widget'  => '</li>',
  		'before_title'  => '<h2 class="widgettitle">',
  		'after_title'   => '</h2>' )
  		);
  	register_sidebar (array(
  		'name'          => __('Left Footer','osmag'),
  		'id'            => "footer-left-widget-area",
  		'before_widget' => '<li id="%1$s" class="widget %2$s">',
  		'after_widget'  => '</li>',
  		'before_title'  => '<h2 class="widgettitle">',
  		'after_title'   => '</h2>' )
  		);
  	register_sidebar (array(
  		'name'          => __('Right Footer','osmag'),
  		'id'            => "footer-right-widget-area",
  		'before_widget' => '<li id="%1$s" class="widget %2$s">',
  		'after_widget'  => '</li>',
  		'before_title'  => '<h2 class="widgettitle">',
  		'after_title'   => '</h2>' )
  		);
  }

  class Repository {
  	public static function findImageForTags($_category_name = null){
      $tags = get_tags(['order'=>'DESC']);
      //mais para frente, ordenar por tag com maior quantidade de hits
      $mostImportantTagPorCount = [];

      for($c=0; $c < count($tags); $c++){
          $mostImportantTagPorCount[$c]["id"] = $tags[$c]->term_id;
          $mostImportantTagPorCount[$c]["name"] = $tags[$c]->name;
          $mostImportantTagPorCount[$c]["count"] = $tags[$c]->count;
          $mostImportantTagPorCount[$c]["tag_link"]  = get_tag_link($tags[$c]->term_id);
      }

      $query_images_args = [
          'post_type'      => 'attachment',
          'post_mime_type' => 'image',
          'post_status'    => 'inherit',
          'posts_per_page' => 8
      ];

      if(isset($_category_name)){
          $query_images_args["category_name"] = $_category_name;
      }

      $query_images = new WP_Query($query_images_args);
      //var_dump($query_images);
      $images = array();

      for($i=0; $i < count($query_images->posts); $i++) {
          $images[$i]["url"] = wp_get_attachment_url($query_images->posts[$i]->ID );
          $images[$i]["name"] = $query_images->posts[$i]->post_title;
      }

      $repository["images"] = $images;
      $repository["tags"] = $mostImportantTagPorCount;

      for($j=0; $j < count($repository["images"]); $j++){
        for($k=0; $k < count($repository["tags"]); $k++){
          if($repository["images"][$j]["name"] == $repository["tags"][$k]["name"] && $j <= 5){
              $result[$k]["nome"] = $repository["images"][$j]["name"];
              $result[$k]["url"] = $repository["images"][$j]["url"];
              $result[$k]["tag_link"] = $repository["tags"][$k]["tag_link"];
          }
        }
      }

      return $result;
    }

    public static function findCategoryForIndexMenu(){
      $category = get_categories([
        'orderby'                  => 'count',
        'order'                    => 'DESC',
        'hide_empty' => 0,
        'exclude' => [14,17,1,9]
      ]);
      return $category;
    }

    function findImageForCategories($_category_name = null){
      $q = new WP_Query(['category_name' => 'pornstar', 'posts_per_page' => 4]);
      $coll = [];
      //var_dump($q);
      while ($q->have_posts()) {
        $q->the_post();
        //the_ID();
        //the_permalink();
        $coll["category"] = get_the_category($q->ID);
        $coll["tag"][] =  get_the_tags();
        $coll["tag_link"] =  get_tag_link($q->ID);
        if ( has_post_thumbnail() ) {
           $coll["thumb"][] = get_the_post_thumbnail($q->ID, 'large' );
        }
      }

        $view = [];
        for($z=0; $z < count($coll["tag"]); $z++){
          $view[$z]["tag_slug"] = $coll["tag"][$z][0]->slug;
          $view[$z]["name"] = $coll["tag"][$z][0]->name;

          $pos = strpos($coll["thumb"][$z], $coll["tag"][$z][0]->slug);
          if($pos === false){
            $view[$z]["thumb"] = null;
          }
          else{
            $view[$z]["thumb"] = $coll["thumb"][$z];
          }
        }

        return($view);
    }

  public static function findRelatedCategoryPosts($id) {
      $tags = wp_get_post_tags($id);
      if ($tags) {
        $first_tag = $tags[0]->term_id;
        $args=[
          'tag__in' => [$first_tag],
          'category__not_in' => [9],
          'post__not_in' => [$id],
          'posts_per_page'=>4,
          'caller_get_posts'=>1
        ];

        $q = new WP_Query($args);
        return $q;
      }
    }
    //for use in the loop, list 5 post titles related to first tag on current post

/*if( $my_query->have_posts() ) {
while ($my_query->have_posts()) : $my_query->the_post(); ?>
<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>

<?php
endwhile;
}
wp_reset_query();
}*/

  	public static function findByPostsForBlog(){
  		return array('category_name' => 'blog','posts_per_page' => 5 );
  	}

  	public static function findByVideosForIndex(){
  		return array('category_name' => 'video-principal-box1','posts_per_page' => 2 );
  	}

  	public static function findByVideosForCategory2(){
  		return array('category_name' => 'video-principal-box2','posts_per_page' => 2 );
  	}

    public function getCategoryPornsStar(){
      return array('category_name' => 'video,pornstar','posts_per_page' => 4 );
    }
  }
  function exclude_widget_categories($args){
    $exclude = "14,17,1,9"; // The IDs of the excluding categories
    $args["exclude"] = $exclude;
    return $args;
  }
  function custom_breadcrumbs() {

    // Settings
    $separator          = '&gt;';
    $breadcrums_id      = 'breadcrumbs';
    $breadcrums_class   = 'breadcrumbs';
    $home_title         = 'Homepage';

    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = 'product_cat';

    // Get the query & post information
    global $post,$wp_query;

    // Do not display on the homepage
    if ( !is_front_page() ) {

        // Build the breadcrums
        echo '<ul id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';

        // Home page
        echo '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>';
        echo '<li class="separator separator-home"> ' . $separator . ' </li>';

        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {

            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . post_type_archive_title($prefix, false) . '</strong></li>';

        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {

            // If post is a custom post type
            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if($post_type != 'post') {

                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);

                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';

            }

            $custom_tax_name = get_queried_object()->name;
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . $custom_tax_name . '</strong></li>';

        } else if ( is_single() ) {

            // If post is a custom post type
            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if($post_type != 'post') {

                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);

                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';

            }

            // Get post category info
            $category = get_the_category();

            if(!empty($category)) {

                // Get last category post is in
                $last_category = end(array_values($category));

                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);

                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<li class="item-cat">'.$parents.'</li>';
                    $cat_display .= '<li class="separator"> ' . $separator . ' </li>';
                }

            }

            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {

                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;

            }

            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

            // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {

                echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

            } else {

                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

            }

        } else if ( is_category() ) {

            // Category page
            echo '<li class="item-current item-cat"><strong class="bread-current bread-cat">' . single_cat_title('', false) . '</strong></li>';

        } else if ( is_page() ) {

            // Standard page
            if( $post->post_parent ){

                // If child page, get parents
                $anc = get_post_ancestors( $post->ID );

                // Get parents in the right order
                $anc = array_reverse($anc);

                // Parent page loop
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                    $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
                }

                // Display parent pages
                echo $parents;

                // Current page
                echo '<li class="item-current item-' . $post->ID . '"><strong title="' . get_the_title() . '"> ' . get_the_title() . '</strong></li>';

            } else {

                // Just display current page if not parents
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</strong></li>';

            }

        } else if ( is_tag() ) {

            // Tag page

            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;

            // Display the tag name
            echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><strong class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</strong></li>';

        } elseif ( is_day() ) {

            // Day archive

            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';

            // Month link
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';

            // Day display
            echo '<li class="item-current item-' . get_the_time('j') . '"><strong class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></li>';

        } else if ( is_month() ) {

            // Month Archive

            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';

            // Month display
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><strong class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</strong></li>';

        } else if ( is_year() ) {

            // Display year archive
            echo '<li class="item-current item-current-' . get_the_time('Y') . '"><strong class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</strong></li>';

        } else if ( is_author() ) {

            // Auhor archive

            // Get the author information
            global $author;
            $userdata = get_userdata( $author );

            // Display author name
            echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><strong class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</strong></li>';

        } else if ( get_query_var('paged') ) {

            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var('paged') . '"><strong class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</strong></li>';

        } else if ( is_search() ) {

            // Search results page
            echo '<li class="item-current item-current-' . get_search_query() . '"><strong class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</strong></li>';

        } elseif ( is_404() ) {

            // 404 page
            echo '<li>' . 'Error 404' . '</li>';
        }

        echo '</ul>';

    }

}

  add_filter("widget_categories_args","exclude_widget_categories");

  add_action('init', 'osmag_widgets_init');
  // featured image support
  add_theme_support( 'post-thumbnails' );

  /*
  $query = "SELECT * FROM $wpdb->posts
    LEFT JOIN $wpdb->postmeta ON($wpdb->posts.ID = $wpdb->postmeta.post_id)
    LEFT JOIN $wpdb->term_relationships ON($wpdb->posts.ID = $wpdb->term_relationships.object_id)
    LEFT JOIN $wpdb->term_taxonomy ON($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id)
    WHERE $wpdb->term_taxonomy.term_id = 19
    AND $wpdb->term_taxonomy.taxonomy = 'category'
     ";

    $query2 = "SELECT * FROM $wpdb->posts
  LEFT JOIN $wpdb->term_relationships ON ($wpdb->posts.ID = $wpdb->term_relationships.object_id)
  LEFT JOIN $wpdb->term_taxonomy ON ($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id)
  WHERE post_status = 'publish'
  AND ID IN (
    SELECT DISTINCT post_parent
    FROM $wpdb->posts
    WHERE post_parent > 0
    AND post_type = 'attachment'
    AND post_mime_type IN ('image/jpeg', 'image/png')
  )
  AND $wpdb->term_taxonomy.taxonomy = 'category'
  AND $wpdb->term_taxonomy.term_id = '" . 19 . "'
  ORDER BY RAND() LIMIT 0,18
  ";

  /*global $wpdb;

    $query3 =  "SELECT DISTINCT *
            FROM $wpdb->posts
            WHERE post_type = 'attachment'
            AND post_mime_type IN ('image/jpeg', 'image/png')
            ORDER BY id DESC LIMIT 1
            ";
    $pageposts = $wpdb->get_results($query3, OBJECT);
    $coll = [];

    for($k=0; $k < count($pageposts);$k++) {
        $coll[$k]["category_name"] = the_category(", ");
        $coll[$k]["tags_name"] = get_tags($pageposts[$k]->ID);
        $coll[$k]["post_id"] = $pageposts[$k]->ID;
        $coll[$k]["guid"] = $pageposts[$k]->guid;
        $coll[$k]["post_name_tag_ref"] = $pageposts[$k]->post_title;
    }
    */
    //o nome da imagem é o nome da tag...
    //var_dump($pageposts);
    /*
    *
    SELECT * FROM wp_posts p, wp_postmeta m WHERE p.post_mime_type
     LIKE "image/%" AND p.ID = m.post_ID
    *
    */


  ?>
