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

# Change Read More link in automatic Excerpts
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'wpse_custom_wp_trim_excerpt');

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
	// add_theme_support( 'featured-header' );
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

/***************************************************************
* a shortcode to display 5 last sticky posts (mis en avant)
*
* source http://www.wpbeginner.com/wp-tutorials/how-to-display-the-latest-sticky-posts-in-wordpress/
***************************************************************/

function clea_latest_sticky( $atts ) { 

	$values = shortcode_atts(array(
		'excerpt' => 'no'
	),$atts);  

	/* Get all sticky posts */
	$sticky = get_option( 'sticky_posts' );

	/* Sort the stickies with the newest ones at the top */
	rsort( $sticky );

	/* Get the 5 newest stickies (change 5 for a different number) */
	$sticky = array_slice( $sticky, 0, 5 );

	/* Query sticky posts */
	$the_query = new WP_Query( array( 'post__in' => $sticky, 'ignore_sticky_posts' => 1 ) );
	// The Loop
	if ( $the_query->have_posts() ) {
		$return = '<ul>';
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			
			if($values['excerpt'] == 'yes'){
				$return .= '<li><a href="' .get_permalink(). '" title="'  . get_the_title() . '">' . get_the_title() . '</a><br />' . get_the_excerpt(). '</li>';
			} else {
				$return .= '<li><a href="' .get_permalink(). '" title="'  . get_the_title() . '">' . get_the_title() . '</a></li>';
			}	
			
		}
		$return .= '</ul>';
		
	} else {
		// no posts found
	}
	/* Restore original Post Data */
	wp_reset_postdata();

	return $return; 

} 
add_shortcode('latest_stickies', 'clea_latest_sticky');



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


function wpse_allowedtags() {
    // Add custom tags to this string
	// <a>,<img>,<video>,<script>,<style>,<audio> are not in
    return '<br>,<em>,<i>,<ul>,<ol>,<li>,<p>'; 
}

if ( ! function_exists( 'wpse_custom_wp_trim_excerpt' ) ) : 

    function wpse_custom_wp_trim_excerpt($wpse_excerpt) {
		$raw_excerpt = $wpse_excerpt;
		
		// text for the "read more" link
		if ( ! is_page( 8207 ) ) {
			$rm_text = __( ' lire l\'article', 'stargazer' ) ;
		} else {
			$rm_text = __( ' Lire le témoignage complet', 'stargazer' ) ;
		}
			
		$excerpt_end = ' <a class="read-more" href="'. esc_url( get_permalink() ) . '">' . $rm_text . '</a>';
		
        if ( '' == $wpse_excerpt ) {  

            $wpse_excerpt = get_the_content('');
            $wpse_excerpt = strip_shortcodes( $wpse_excerpt );
            $wpse_excerpt = apply_filters('the_content', $wpse_excerpt);
            $wpse_excerpt = str_replace(']]>', ']]&gt;', $wpse_excerpt);
            $wpse_excerpt = strip_tags($wpse_excerpt, wpse_allowedtags()); /*IF you need to allow just certain tags. Delete if all tags are allowed */

            //Set the excerpt word count and only break after sentence is complete.
                $excerpt_word_count = 75;
                $excerpt_length = apply_filters('excerpt_length', $excerpt_word_count); 
                $tokens = array();
                $excerptOutput = '';
                $count = 0;

                // Divide the string into tokens; HTML tags, or words, followed by any whitespace
                preg_match_all('/(<[^>]+>|[^<>\s]+)\s*/u', $wpse_excerpt, $tokens);

                foreach ($tokens[0] as $token) { 

                    if ($count >= $excerpt_length && preg_match('/[\,\;\?\.\!]\s*$/uS', $token)) { 
                    // Limit reached, continue until , ; ? . or ! occur at the end
                        $excerptOutput .= trim($token);
                        break;
                    }

                    // Add words to complete sentence
                    $count++;

                    // Append what's left of the token
                    $excerptOutput .= $token;
                }

            $wpse_excerpt = trim(force_balance_tags($excerptOutput));
		   
				// $wpse_excerpt .= $excerpt_end ;
				$excerpt_more = apply_filters( 'excerpt_more', ' ' . $excerpt_end ); 

                $pos = strrpos($wpse_excerpt, '</');
                if ($pos !== false) {
					// Inside last HTML tag
					$wpse_excerpt = substr_replace($wpse_excerpt, $excerpt_end, $pos, 0); // Add read more next to last word 
				} else {
					// After the content
					$wpse_excerpt .= $excerpt_more; //Add read more in new paragraph 
				}
                
            return $wpse_excerpt;   

        } 
		
		// add read more link to the manual extract
		$wpse_excerpt .= $excerpt_end ;
		// return the manual extract
		// DELETE the 'AAAA !' . before $wpse_excerpt : it's used to show the manual extracts for debugging. 
        return apply_filters('wpse_custom_wp_trim_excerpt', $wpse_excerpt, $raw_excerpt);
    }
  
endif; 



?>