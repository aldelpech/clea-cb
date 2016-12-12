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
		
		<header id="header">

			<hgroup id="branding">
				
				<!-- a CLEA-BASE function will add the site logo -->
				<?php do_atomic( 'open_header' ); // crée un "hook" "repertoire_open_header ?>
				
				<?php hybrid_site_title(); ?>
				<?php hybrid_site_description(); ?>
			</hgroup><!-- #branding -->		

		
			<?php get_template_part( 'menu', 'primary' ); // Loads the menu-primary.php template. ?>		

		</header><!-- #header -->
		
		<?php get_template_part( 'menu', 'secondary' ); // Loads the menu-primary.php template. ?>

		<div class="full-page">
			<?php if ( get_header_image() ) echo '<img class="header-image" src="' . esc_url( get_header_image() ) . '" alt="" />'; ?>
			
			
		</div>
		
		<div id="main">

			<?php get_template_part( 'breadcrumbs' ); // Loads the breadcrumbs.php template. ?>		
		
