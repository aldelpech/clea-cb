<?php
/**
 * Template Name: clea-functions - choix couleurs
 * !!! this template must be copied in the template directory of a child theme !!!
 */

$do_not_duplicate = array();

get_header(); // Loads the header.php template. ?>

<?php get_sidebar( 'primary' ); // Loads the sidebar-primary.php template. ?>

	<!-- Begin featured area. --->
	<section class="liste-des-couleurs">
	<?php if( function_exists( 'clea_add_func_generate_shades' ) ) {
		echo clea_add_func_generate_shades() ; ?>
	<?php
	} else { ?>
		<p> la fonction 'clea_add_func_generate_shades' n'existe pas</p>
		<p>Il faut activer le plugin clea-add-functions </p>
	<?php } ?>
		
	</section>





<?php get_footer(); // Loads the footer.php template. ?>