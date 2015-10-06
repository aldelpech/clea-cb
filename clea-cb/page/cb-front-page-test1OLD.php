<?php
/**
 * Template Name: n°1 essai accueil CB
 */

$do_not_duplicate = array();

get_header(); // Loads the header.php template. ?>

<?php get_sidebar( 'primary' ); // Loads the sidebar-primary.php template. ?>

	<!-- Begin featured area. --->
	<section class="feature">

		<p>Prévoir ici un texte permettant la prise de conscience de problèmes et les enjeux et renforcer cet aspect soit dans les cornerstones, soit dans des sous-pages, soit dans des articles de niveau 3</p>
	</section>
	<!-- End featured area. -->

	<section class="flexbox-list">
		<h3>Version masonry layout with flexbox</h3>	
		<div id="masonry" class="row">
			<!-- voir http://demosthenes.info/blog/844/Easy-Masonry-Layout-With-Flexbox -->
				<!-- Begin excerpts area. -->
		<?php 
		// set the "paged" parameter (use 'page' if the query is on a static front page)
		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

		$loop = new WP_Query(
			array(
				'post_type' => 'post',
				'posts_per_page' => 8,
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
	
	
	<section class="list-articles">
	<h3>Version masonry (jquery) : Les derniers articles du blog</h3>	
	<p> Attention : les effets de style ne s'appliquent pas dans l'inspecteur. Il faut modifier le css puis recharger la page</p>
	<p> peu responsive pour l'instant</p>
	<div id="pp-container" class="row">
	<!-- voir http://codepen.io/desandro/pen/BAJKn -->
	<div class="gutter-sizer"></div>
		<!-- Begin excerpts area. -->
		<?php 
		// set the "paged" parameter (use 'page' if the query is on a static front page)
		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
		
		$loop = new WP_Query(
			array(
				'post_type' => 'post',
				'posts_per_page' => 10,
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

			<div class="content-secondary">

				<?php while ( $loop->have_posts() ) : $loop->the_post(); $do_not_duplicate[] = get_the_ID();  ?>

				<div class="pp-item col-lg-6 col-md-6 col-sm-6 col-xs-12">
				
					<article id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

							<?php if ( current_theme_supports( 'get-the-image' ) ) get_the_image( array( 'meta_key' => 'Thumbnail', 'size' => 'medium' ) ); ?>

							<div class="categorie">
							<span class="categories"><?php the_category(', '); ?></span>
							</div>
							<header class="entry-header">
								<?php echo apply_atomic_shortcode( 'entry_title', '[entry-title tag="h3"]' ); ?>
								<?php // echo apply_atomic_shortcode( 'entry_byline', '<div class="entry-byline">' . __( 'Publié le [entry-published] [entry-edit-link before=" | "]', 'unique' ) . '</div>' ); ?>
							</header><!-- .entry-header -->

							<div class="entry-summary">
								<?php the_excerpt(); ?>
							</div><!-- .entry-summary -->

								<p class="entry-meta">
								<span class="categories">  </span>
								<?php echo apply_atomic_shortcode( 'entry_byline', '<span class="entry-byline">' . __( '[entry-published] [entry-edit-link before=" | "]', 'unique' ) . '</span>' ); ?>
								<!--
								<span class="categories"><?php // _e('Posted in', 'example'); ?> <?php // the_category(', '); ?></span>
								<?php // the_tags('<span class="tags"> <span class="sep">|</span> ' . __('Tagged', 'example') . ' ', ', ', '</span>'); ?> 
								
								<span class="sep">|</span> <?php // comments_popup_link(__('Leave a response', 'example'), __('1 Response', 'example'), __('% Responses', 'example'), 'comments-link', __('Comments closed', 'example')); ?>  
								-->
							</p>							
					</article><!-- .hentry -->
					<div class="clearfix"></div>
				</div>	
				
				<?php endwhile; ?>

	
				
			</div><!-- .content-secondary -->

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


	
<!-- script pour faire fonctionner masonry -->
<!-- http://www.wpdevsolutions.com/implement-masonry-in-wordpress/ -->	
	<script type="text/javascript">
			
		jQuery(window).load(function() {
			
			// MASONRY Without jquery
			var container = document.querySelector('#pp-container');
			var msnry = new Masonry( container, {
				itemSelector: '.pp-item',
				columnWidth: '.pp-item',
				gutter: '.gutter-sizer',
			});  
		  
		});
		  
	</script>
	




<?php get_footer(); // Loads the footer.php template. ?>