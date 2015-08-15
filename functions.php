<?php
/**
 * 
 * this file is designed to provide specific functions for the child theme
 *
 * @package    clea-base
 * @subpackage Functions
 * @version    0.1.0
 * @since      0.1.0
 * @author     Anne-Laure Delpech <ald.kerity@gmail.com>  
 * @copyright  Copyright (c) 2015 Anne-Laure Delpech
 * @link       
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */


/* Register and load scripts. */
add_action( 'wp_enqueue_scripts', 'clea_cecile_b_enqueue_scripts' );

/* Register and load styles. */
add_action( 'wp_enqueue_scripts', 'clea_cecile_b_enqueue_styles', 4 ); 

/* remove header font settings from customizer */
add_action( 'customize_register', 'clea_cecile_b_remove_custom', 1000 );
 
function clea_cecile_b_enqueue_styles() {

	// feuille de style pour l'impression
	wp_enqueue_style( 'print', get_stylesheet_directory_uri() . '/css/print.css', array(), false, 'print' );
	
	if ( is_page_template( 'page/ac-front-page-template.php' ) ) {
		wp_enqueue_style( 'flexslider', get_template_directory_uri() . '/css/flexslider.css' , array( '25px' ) );
	}
	
	if ( is_page_template( 'page/cb-front-page-test1.php' ) ) {
		wp_enqueue_style( 'test1-masonry', get_stylesheet_directory_uri() . '/css/test1.css' );
	}
	
}

function clea_cecile_b_enqueue_scripts() {

	/* Enqueue the 'flexslider' script. */
	if ( is_page_template( 'page/ac-front-page-template.php' ) ) {
		wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/js/flexslider/flexslider.min.js' , array( 'jquery' ), '20120713', true );
	}
	
	if ( is_page_template( 'page/cb-front-page-test1.php' ) ) {
		wp_enqueue_script( 'jquery-masonry' );
	}
}

/* source http://wordpress.stackexchange.com/questions/189484/removing-non-native-customizer-settings-from-a-child-theme
*/
function clea_cecile_b_remove_custom($wp_customize) {
  // $wp_customize->remove_setting('theme_font_body-lobster-two-400'); // does NOT WORK
  $wp_customize->remove_control('theme-fonts-header');  	// removes the whole title font control
  // $wp_customize->remove_section('fonts');					// remove whole font section - OK
}

?>