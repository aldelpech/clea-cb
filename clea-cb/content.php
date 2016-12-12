

	<?php if ( is_singular( get_post_type() ) ) { ?>

		<?php if ( 'wpm-testimonial' == get_post_type() ) { // If viewing a testimonials single post. ?>
	
			<article <?php hybrid_post_attributes(); ?>>
				<header class="entry-header">
					<?php echo apply_atomic_shortcode( 'entry_title', the_title( '<h1 class="entry-title">', '</h1>', false ) ); ?>
					<?php echo apply_atomic_shortcode( 'entry_byline', '<div class="entry-byline">' . __( 'Published by [entry-author] on [entry-published] [entry-comments-link before=" | "] [entry-edit-link before=" | "]', 'clea-base' ) . '</div>' ); ?>
				</header><!-- .entry-header -->

				<div class="entry-content">
					<?php 
					if( has_post_thumbnail() ) {
						the_post_thumbnail('medium', array( 'class' => 'alignright' )); 
					} ?>
					<?php the_content(); ?>
					<span class="entry-terms clea-temoin">
						<?php echo get_post_meta( get_the_ID(), 'first_name', true )?> <?php echo get_post_meta( get_the_ID(), 'last_name', true )?> <span class="clea-fonctions"><a href="<?php echo get_post_meta( get_the_ID(), 'company_website', true )?>"><?php echo get_post_meta( get_the_ID(), 'company_name', true )?></a>. </span> 
						
						
					</span>
					
				</div><!-- .entry-content -->

				<footer class="entry-footer">
					<?php echo apply_atomic_shortcode( 'entry_meta', '<div class="entry-meta">' . __( '[entry-terms taxonomy="wpm-testimonial-category" before="Posted in "] [entry-terms before="Tagged "]', 'clea-base' ) . '</div>' ); ?>
				</footer><!-- .entry-footer -->		

				<div class="post-nav">
					<div class="alignleft prev-next-post-nav"><?php previous_post_link( '&laquo; %link' ) ?></div>
					<div class="alignright prev-next-post-nav"><?php next_post_link( '%link &raquo;' ) ?></div>
				</div>
				
			</article><!-- .hentry -->
			
		<?php } else {// not a testimonials single post. ?>

		<article <?php hybrid_post_attributes(); ?>>
			<header class="entry-header">
				<?php echo apply_atomic_shortcode( 'entry_title', the_title( '<h1 class="entry-title">', '</h1>', false ) ); ?>
				<?php echo apply_atomic_shortcode( 'entry_byline', '<div class="entry-byline">' . __( 'Published by [entry-author] on [entry-published] [entry-comments-link before=" | "] [entry-edit-link before=" | "]', 'clea-base' ) . '</div>' ); ?>
			</header><!-- .entry-header -->

			<div class="entry-content">
				<?php the_content(); ?>
				<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'clea-base' ), 'after' => '</p>' ) ); ?>
			</div><!-- .entry-content -->

			<footer class="entry-footer">
				<?php echo apply_atomic_shortcode( 'entry_meta', '<div class="entry-meta">' . __( '[entry-terms taxonomy="category" before="Posted in "] [entry-terms before="Tagged "]', 'clea-base' ) . '</div>' ); ?>
			</footer><!-- .entry-footer -->		
			
		</article><!-- .hentry -->
		<?php } // else not testimonial ?>
	<?php } else { ?>
	<article id="post-<?php the_ID(); ?>" class="bloc-article <?php hybrid_entry_class(); ?>">

		<span class="categories"><?php the_category(' '); ?></span>
		<?php if ( current_theme_supports( 'get-the-image' ) ) get_the_image( array( 'meta_key' => 'Thumbnail', 'size' => 'large' ) ); ?>

		<header class="entry-header">
			<?php echo apply_atomic_shortcode( 'entry_title', '[entry-title tag="h3"]' ); ?>
		</header><!-- .entry-header -->
		<span class="entry-summary"><?php the_excerpt(); ?> </span>


		</p>
	</article><!-- .hentry -->
	<?php } ?>

