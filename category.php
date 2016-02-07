<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPressquery_posts
 * @subpackage Cecile
 * @since Cecile 1.0
 */

get_header(); ?>
	<div class="two_third">
	
	<?php 
	
	if (isset($_GET['blog']))
	{
		$nomCategorie = "En direct du Blog";  ?>
		<h3 class="police"><?php echo $nomCategorie; ?></h3>
	<?php 
		} else {
		$nomCategorie = single_cat_title("", false); ?>
		<h3 class="police"><?php echo $nomCategorie; ?></h3>
		<?php if ( function_exists('yoast_breadcrumb') ) {
		yoast_breadcrumb('<p id="breadcrumbs">','</p>');
		} 
	}?>
	
	
	<ol>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<li>
			<figure class="category">
				<?php if ( has_post_thumbnail()) { ?>
				<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail( array(150,100), array('class' => 'borderRotate') ); ?></a>
				<?php } ?>
										
				<figcaption>
					<h4><i class="icon-star"></i> <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
					<?php the_excerpt(); ?>	
					
					<p class="post-info">
						<span class="nomCategorie"><i class="icon-angle-right"></i>
						<?php 
						$category = get_the_category($post->ID);
						foreach ( $category as $cat) {
							
							if ( $cat->term_id <> 73 && $cat->term_id <> 74 && $cat->term_id <> 75 ) {
								echo ' <a href="' . get_category_link( $cat->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $cat->name ) . '" ' . '>' . $cat->name.'</a> ';
							}  
						}
						?>
						</span>
						<span class="sep"> | </span>
						<span class="release-date"><i class="icon-calendar"></i>  posté le <?php echo get_the_date(); ?></span>
						<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
						<span class="sep"> | </span>
						<span class="comments-link"><i class="icon-comment"></i>  
					<?php 
					
					switch ($category[0]->cat_ID) {
						case 10:// dej
						case 13:// formation
						case 14:// atelier conférence
							$txtpopUpLink = "témoignage";
							$txtpopUpLinks = "témoignages";
							break;
						default:
							$txtpopUpLink = "commentaire";
							$txtpopUpLinks = "commentaires";
						}
					?>
					
					
					<?php comments_popup_link( __( 'Laissez un '.$txtpopUpLink,'' ), __( '1 '.$txtpopUpLink, '' ), __( '% '.$txtpopUpLinks, '' ) ); ?></span>
						<?php endif; ?>
					</p><!-- End .post-info -->
				</figcaption>
				<div class="clear"></div>
				<hr />
			</figure>
			
		</li>
		
	<?php endwhile; endif; ?>
	</ol>
	
	<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
	
	</div><!-- /two_third-->
			
			<!-- colonne -->
	<aside id="sidebar" class="one_third_last">
			<!-- Colonne article -->
				<?php 
	if(function_exists('dynamic_sidebar')):dynamic_sidebar('Colonne-pour-les-articles-blog'); else : ?>
				<section>
					<p>Il n'y a pas de Widget pour le moment.</p>
				</section>
				<?php endif; ?>
		</aside>

			
			<div class="clear"></div>
			
<?php get_footer(); ?>