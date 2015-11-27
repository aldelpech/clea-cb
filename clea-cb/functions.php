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


// Do theme setup on the 'after_setup_theme' hook.
add_action( 'after_setup_theme', 'clea_cecile_b_theme_setup', 5 ); 

// filter the related posts plugin so that only same category are displayed
add_action( 'admin_init', 'clea_cecile_b_filter_related_posts' );


function clea_cecile_b_theme_setup() {

	/* Register and load scripts. */
	add_action( 'wp_enqueue_scripts', 'clea_cecile_b_enqueue_scripts' );

	/* Register and load styles. */
	add_action( 'wp_enqueue_scripts', 'clea_cecile_b_enqueue_styles', 4 ); 

	/* remove header font settings from customizer */
	add_action( 'customize_register', 'clea_cecile_b_remove_custom', 1000 );

	/* Add support for a custom header image (logo). */
	add_theme_support(
		'custom-header',
		array(
			'width'       => 1500,
			'height'      => 400,
			'flex-height' => true,
			'flex-width'  => false,
			'header-text' => false
		)
	); 

	// add theme support for WordPress featured image and post thumbnails
	add_theme_support( 'featured-header' );
	add_theme_support( 'post-thumbnails' ); 	
	
	
} 

function clea_cecile_b_enqueue_styles() {

	// feuille de style pour l'impression
	wp_enqueue_style( 'print', get_stylesheet_directory_uri() . '/css/print.css', array(), false, 'print' );


	if ( is_page_template( 'page/cb-front-page-ribbon.php' ) ) {
		
		wp_enqueue_style( 'test-ruban', get_stylesheet_directory_uri() . '/css/test1.css' );
	
	}
	
	if ( is_page_template( 'page/ac-front-page-template.php' ) ) {
		
		wp_enqueue_style( 'flexslider', get_template_directory_uri() . '/css/flexslider.css' , array( '25px' ) );
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

function clea_cecile_b_filter_related_posts() {
		/* to link only same categories with the related post for Wordpress plugin
	* see https://www.relatedpostsforwp.com/documentation/only-link-posts-in-same-category/
	*/
	
	if ( is_plugin_active( 'related-posts-for-wp/related-posts-for-wp.php' ) ) {
		add_filter( 'rp4wp_get_related_posts_sql', 'rp4wp_force_same_category', 11, 3 );
	} 
}


function rp4wp_force_same_category( $sql, $post_id, $post_type ) {
	global $wpdb;

	if ( 'post' !== $post_type ) {
		return $sql;
	}

	$sql_replace = "
	INNER JOIN " . $wpdb->term_relationships . " ON (P.ID = " . $wpdb->term_relationships . ".object_id)
	INNER JOIN " . $wpdb->term_taxonomy . " ON (" . $wpdb->term_relationships . ".term_taxonomy_id = " . $wpdb->term_taxonomy . ".term_taxonomy_id)
	WHERE 1=1
	AND " . $wpdb->term_taxonomy . ".taxonomy = 'category'
	AND " . $wpdb->term_taxonomy . ".term_id IN ( SELECT TT.term_id FROM " . $wpdb->term_taxonomy . " TT INNER JOIN " . $wpdb->term_relationships . " TR ON TR.term_taxonomy_id = TT.term_taxonomy_id WHERE TR.object_id = " . $post_id . " )
	";

	return str_ireplace( 'WHERE 1=1', $sql_replace, $sql );
}


?>