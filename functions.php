<?php

/* DEFINE
================================================== */
define ( 'TBUCHILD_CSS' , get_stylesheet_directory_uri() . '/css' );
define ( 'TBUCHILD_ADMIN' , get_stylesheet_directory_uri() . '/admin' );
define ( 'TBUCHILD_INCLUDES' , get_stylesheet_directory_uri() . '/includes' );

function hb_tbu_styles_setup () {

	// Enqueue child theme styles
	wp_register_style( 'taboo_style_overrides', TBUCHILD_CSS . '/style.css' );

	wp_enqueue_style( 'taboo_style_overrides' );
	wp_enqueue_style( 'google-fonts' );

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