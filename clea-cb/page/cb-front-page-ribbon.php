<?php
/**
 * Template Name: Test "Ribbon" 
 */

$do_not_duplicate = array();

get_header(); // Loads the header.php template. ?>

<?php get_sidebar( 'primary' ); // Loads the sidebar-primary.php template. ?>

	<section class="cb-post-list">

<?php 

		//Protect against arbitrary paged values
		// http://codex.wordpress.org/Function_Reference/paginate_links
		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

		$loop = new WP_Query(
			array(
				'post_type' 		=> 'post',
				'posts_per_page' 	=> 8,
				'paged'				=> $paged,
				'ignore_sticky_posts' => true, /* will not show featured posts first */
				'orderby' => 'date', /* 'modified' last modified 'date' would order by published date */
				'order' => 'DESC',         /* 'ASC' */
				'tax_query' => array(
					array(
						'taxonomy' => 'post_format',
						'field' 	=> 'slug',
						'terms' 	=> array(
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
						'operator' 	=> 'NOT IN'
					)
				),
				'category__not_in'	=> '72', /* exclude category "AIDE" */
				'post__not_in' => $do_not_duplicate
			)
		); ?>

		
		<h2>Les derniers articles du blog</h2>
		
		<?php get_template_part( 'loop-meta' ); // Loads the loop-meta.php template. ?>	

<div class="list-gallery">		
		
		<?php if ( $loop->have_posts() ) { ?>

			<?php while ( $loop->have_posts() ) : $loop->the_post(); $do_not_duplicate[] = get_the_ID(); ?>

				<?php get_template_part( 'content-ribbon', ( post_type_supports( get_post_type(), 'post-formats' ) ? get_post_format() : get_post_type() ) ); ?>


			<?php endwhile; ?>

		<?php } ?>

		<a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>">Tous les articles du Blog</a>

	
<?php wp_reset_query(); ?>
</div>
	</section><!-- #section -->	
	
	
<?php get_footer(); // Loads the footer.php template. ?>