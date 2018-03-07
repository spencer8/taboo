<?php

/* DEFINE
================================================== */
define ( 'TBUCHILD_CSS' , get_stylesheet_directory_uri() . '/css' );
define ( 'TBUCHILD_ADMIN' , get_stylesheet_directory_uri() . '/admin' );
define ( 'TBUCHILD_INCLUDES' , get_stylesheet_directory_uri() . '/includes' );
$version = "?v="."20160810";

function hb_tbu_styles_setup () {

	// Enqueue child theme styles
	wp_register_style( 'taboo_style_overrides', TBUCHILD_CSS . '/style.css'. $version );

	wp_enqueue_style( 'taboo_style_overrides' );
	wp_enqueue_style( 'google-fonts' );
  wp_enqueue_style( 't8_icomoon', get_template_directory_uri() . '/css/icons.css', false, $version, 'all' );

}
add_action('wp_enqueue_scripts', 'hb_tbu_styles_setup');


//clean up Parent Theme:
 
function tbu_customize_menu_items() {
    remove_menu_page( 'edit.php?post_type=portfolio' );
    remove_menu_page( 'edit.php?post_type=clients' );
    remove_menu_page( 'edit.php?post_type=faq' );
    remove_menu_page( 'edit.php?post_type=hb_testimonials' );
    remove_menu_page( 'edit.php?post_type=hb_pricing_table' );
    //remove_menu_page( 'edit.php?post_type=gallery' );

    global $menu;
      //print_r($menu); //Print menus and find out the index of your custom post type menu from it.
      $menu[106][0] = 'Calendars'; // Replace the 27 with your custom post type menu index from displayed above $menu array 
      $menu[100][0] = 'Taboo Girls'; 
}
add_action( 'admin_menu', 'tbu_customize_menu_items' );

add_filter('av_cookie_duration', 'tbu_av_cookie_duration_filter');

/**
 * Filter to replace age-verify plugin cookie duration
 *
 * @return int to be used to set cookie duration
 **/
function tbu_av_cookie_duration_filter($cookie_dur) {

  $cookie_dur = get_option('_av_cookie_duration');
  return (int) $cookie_dur;
}

/* BLOG 3up
-------------------------------------------------- */
function t8_hb_blog_3up_shortcode($params = array(), $content = null) {

  extract(shortcode_atts(array(
    'read_more' => '',
   // 'visible_items' => '4',
   // 'total_items' => '12',
    'category' => '',
    'excerpt_length' => hb_options('hb_blog_excerpt_length'),
    'orderby' => 'date',
    'order' => 'DESC',
   // 'carousel_speed' => '5000',
   // 'auto_rotate' => '',
   // 'animation' => '',
   // 'animation_delay' => '',
    'class' => ''
  ), $params));

  if ( $class != '' ){
    $class = ' ' . $class;
  }
  
  if ( !$excerpt_length ) $excerpt_length = hb_options('hb_blog_excerpt_length');

  $output = "";

  if ( $category ) {
    $category = str_replace(" ", "", $category);
    $category = explode(",", $category);

    $queried_items = new WP_Query( array( 
        'post_type' => 'post',
        'orderby' => $orderby,
        'order' => $order,
        'status' => 'publish',
        'posts_per_page' => 3,
        'tax_query' => array(
            array(
              'taxonomy' => 'category',
              'field' => 'slug',
              'terms' => $category
            )
          )     
    ));
  } else {
    $queried_items = new WP_Query( array( 
        'post_type' => 'post',
        'orderby' => $orderby,
        'order' => $order,
        'posts_per_page' => 3,
        'status' => 'publish',
      ));
  }
  $unique_id = rand(1,10000);

  if ( $queried_items->have_posts() ) :

  $output .= '<div class="shortcode-wrapper clearfix shortcode-blog-3up' . $class . '">';

  // Blog Items

  while ( $queried_items->have_posts() ) : $queried_items->the_post();

    $output .= '<div class="blog-shortcode-1">';
    
    if ( hb_options('hb_blog_enable_date') )
      $output .= '<div class="blog-list-item-date">' . get_the_time('d') . '<span>' . get_the_time('M') . '</span></div>';

    $output .= '<div class="blog-list-content';
    if ( !hb_options('hb_blog_enable_date') )
      $output .= ' nlm';
    $output .= '">';
    $output .= '<h6 class="special"><a href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a></h6>';

    if ( hb_options('hb_blog_enable_comments') && comments_open() ) {
      $comm_num = get_comments_number();
      if ( $comm_num != 1 )
        $output .= '<small>' . $comm_num . __(' Comments' , 'hbthemes') . '</small>';
      else 
        $output .= '<small>' . __('1 Comment' , 'hbthemes') . '</small>';
    }

    $output .= '<div class="blog-list-item-excerpt">';
    $output .= '<p>' . wp_trim_words( strip_shortcodes( get_the_content() ) , $excerpt_length , NULL) . '</p>';
    if ( $read_more == "yes" )
      $output .= '<a href="' . get_permalink() . '" class="simple-read-more">Read More</a>';
    $output .= '</div>';
    
    $output .= '</div>';
    $output .= '</div>';

  endwhile;

  $output .= '</div>';

  endif;
  wp_reset_query();
  
  return $output;  
}
add_shortcode('t8_blog_3up', 't8_hb_blog_3up_shortcode');
