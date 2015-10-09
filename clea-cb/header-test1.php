<!DOCTYPE html>

<html <?php language_attributes(); ?>>



<head>



	<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />

	<title><?php hybrid_document_title(); ?></title>

	<meta name="viewport" content="width=device-width,initial-scale=1" />

	<link rel="profile" href="http://gmpg.org/xfn/11" />

	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<!-- use favicon set in theme options -->
	<link rel="Shortcut Icon" href="<?php echo esc_attr( hybrid_get_setting( 'favicon_upload' ) ) ; ?>" type="image/x-icon" />

	<?php wp_head(); // wp_head ?>



</head>



<body <?php hybrid_body_attributes(); ?>>

	<div id="container">
		
		<?php get_template_part( 'menu', 'primary' ); // Loads the menu-primary.php template. ?>
		<header id="header">
			<?php
			$value = get_option( 'clea-base_theme_settings' );
			// var_dump( $value ); 
			?>

			<div class="ald-unique-logo">		
				<a href="<?php echo get_home_url() ; ?>" >
				<img class="logo-ac" src="<?php echo $value[ "logo_upload" ]; ?>" alt="logo" title="retour à l'accueil" width="<?php echo $value[ "logo_width" ]; ?>" height="<?php echo $value[ "logo_height" ]; ?>"/>
				</a>
			</div>
		
		</header><!-- #header -->
		
		<?php get_template_part( 'menu', 'secondary' ); // Loads the menu-primary.php template. ?>
	
		<div class="full-page">
			<?php if ( get_header_image() ) echo '<img class="header-image" src="' . esc_url( get_header_image() ) . '" alt="" />'; ?>
		</div>
		
		<div id="main">

			<?php get_template_part( 'breadcrumbs' ); // Loads the breadcrumbs.php template. ?>