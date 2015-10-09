<?php
/**
 * Template Name: n°1 essai accueil CB
 */

$do_not_duplicate = array();

get_header( 'test1' ); // Loads the header.php template. ?>

<?php get_sidebar( 'primary' ); // Loads the sidebar-primary.php template. ?>



	<section class="flexbox-list">
		<h3>Les derniers articles</h3>	
		<div id="masonry" class="row">
			<!-- voir http://demosthenes.info/blog/844/Easy-Masonry-Layout-With-Flexbox -->
				<!-- Begin excerpts area. -->
		<?php 
		// set the "paged" parameter (use 'page' if the query is on a static front page)
		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

		$loop = new WP_Query(
			array(
				'post_type' => 'post',
				'posts_per_page' => 5,
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
				'post__not_in' => $do_not_duplicate,
				'paged' 			=> $paged, 
				'category__not_in'	=> '72', /* exclude category "AIDE" */
				'post_status' => 'publish', /* show only published posts */
			)
		); ?>

		<?php if ( $loop->have_posts() ) : ?>

			<?php while ( $loop->have_posts() ) : $loop->the_post(); $do_not_duplicate[] = get_the_ID();  ?>

				<div id="got-gridbox">
					<figure>
						<div class="cb-image">
						<?php if ( current_theme_supports( 'get-the-image' ) ) get_the_image( array( 'meta_key' => 'Thumbnail', 'size' => 'large' ) ); ?>
						</div>
						<div class="categorie">
								<span class="categories"><?php the_category(', '); ?></span>
						</div>
						<figcaption>
							<header class="entry-header">
								<?php echo apply_atomic_shortcode( 'entry_title', '[entry-title tag="h3"]' ); ?>
							</header><!-- .entry-header -->
							<div class="entry-summary">
								<?php the_excerpt(); ?>
								<a class="read-more" href="<?php get_permalink( get_the_ID() ); ?>"> Lire la suite</a>
							</div><!-- .entry-summary -->
							<p class="entry-meta">
							<span class="categories">  </span>
							<?php echo apply_atomic_shortcode( 'entry_byline', '<span class="entry-byline">' . __( '[entry-published] [entry-edit-link before=" | "]', 'unique' ) . '</span>' ); ?>
						</figcaption>
					</figure>
					<!-- <div class="clearfix"></div> -->
				</div>	
						
			<?php endwhile; ?>

		<?php endif; ?>
		</div><!-- #pp-container -->

		<!-- http://wordpress.stackexchange.com/questions/174907/how-to-use-the-posts-navigation-for-wp-query-and-get-posts -->
		<?php 
		$GLOBALS['wp_query']->max_num_pages = $loop->max_num_pages;
		
		// echos the return of get_the_posts_pagination()
		the_posts_pagination( array(
			'mid_size' => 2,
			'prev_text' => __( 'Plus récents', 'clea-base' ),
			'next_text' => __( 'Plus anciens', 'clea-base' ),
			'screen_reader_text' => __( 'autres articles', 'clea-base' ),
		) ); ?>
		
		
		<?php wp_reset_query(); ?>

	</section>
	<br />
	<hr />
	<br />
	<section class="cb-post-list">

	<h2>Autre version</h2>
		<!-- Begin excerpts area. -->
		<?php 
		// set the "paged" parameter (use 'page' if the query is on a static front page)
		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
		
		$loop = new WP_Query(
			array(
				'post_type' => 'post',
				'posts_per_page' => 5,
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
				'category__not_in'	=> '72', /* exclude category "AIDE" */
				'post__not_in' => $do_not_duplicate,
				'paged' 			=> $paged,
				'post_status' => 'publish', /* show only published posts */
			)
		); ?>

		<?php if ( $loop->have_posts() ) : ?>


				<?php while ( $loop->have_posts() ) : $loop->the_post(); $do_not_duplicate[] = get_the_ID();  ?>
	
					<?php get_template_part( 'content', ( post_type_supports( get_post_type(), 'post-formats' ) ? get_post_format() : get_post_type() ) ); ?>

				<?php endwhile; ?>


		<?php endif; ?>
		<!-- End excerpts area. --->


		<!-- http://wordpress.stackexchange.com/questions/174907/how-to-use-the-posts-navigation-for-wp-query-and-get-posts -->
		<?php 
		$GLOBALS['wp_query']->max_num_pages = $loop->max_num_pages;
		
		// echos the return of get_the_posts_pagination()
		the_posts_pagination( array(
			'mid_size' => 2,
			'prev_text' => __( 'Plus récents', 'clea-base' ),
			'next_text' => __( 'Plus anciens', 'clea-base' ),
			'screen_reader_text' => __( 'autres articles', 'clea-base' ),
		) ); ?>
		
		
		<?php wp_reset_query(); ?>

	</section><!-- #section -->
	
	
	
<?php get_footer( 'test1' ); // Loads the footer.php template. ?>