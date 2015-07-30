<?php
/**
 * Template Name: maquette accueil CB
 */

get_header(); // Loads the header.php template. ?>

	<!-- Begin featured area. --->
	<div class="feature">

		<center><h3>Maquette à créer</h3></center>
		<p>ce que tu veux ici ou ailleurs</p>
	</div>
	<!-- End featured area. -->

	
	<div id="content" class="hfeed">

		<!-- Begin excerpts area. -->
		<?php $loop = new WP_Query(
			array(
				'post_type' => 'post',
				'posts_per_page' => 4,
				'tax_query' => array(
					array(
						'taxonomy' => 'post_format',
						'field' => 'slug',
						'terms' => array(
							'post-format-aside',
							'post-format-audio',
							'post-format-chat',
							'post-format-gallery',
							'post-format-image', 
							'post-format-link', 
							'post-format-quote',
							'post-format-status',
							'post-format-video'
						),
						'operator' => 'NOT IN'
					)
				),
				'post__not_in' => $do_not_duplicate
			)
		); ?>

		<?php if ( $loop->have_posts() ) : ?>

			<div class="content-secondary">

				<?php while ( $loop->have_posts() ) : $loop->the_post(); $do_not_duplicate[] = get_the_ID();  ?>

					<article id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

							<?php if ( current_theme_supports( 'get-the-image' ) ) get_the_image( array( 'meta_key' => 'Thumbnail', 'size' => 'thumbnail' ) ); ?>

							<header class="entry-header">
								<?php echo apply_atomic_shortcode( 'entry_title', '[entry-title tag="h2"]' ); ?>
								<?php echo apply_atomic_shortcode( 'entry_byline', '<div class="entry-byline">' . __( 'Published on [entry-published] [entry-edit-link before=" | "]', 'unique' ) . '</div>' ); ?>
							</header><!-- .entry-header -->

							<div class="entry-summary">
								<?php the_excerpt(); ?>
							</div><!-- .entry-summary -->

					</article><!-- .hentry -->

				<?php endwhile; ?>

			</div><!-- .content-secondary -->

		<?php endif; ?>
		<!-- End excerpts area. --->



		<?php wp_reset_query(); ?>

	</div><!-- #content -->

<?php // get_sidebar( 'primary' ); // Loads the sidebar-primary.php template. ?>

<?php get_footer(); // Loads the footer.php template. ?>