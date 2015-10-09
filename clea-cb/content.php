

	<?php if ( is_singular( get_post_type() ) ) { ?>
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
	<?php } else { ?>
	<article id="post-<?php the_ID(); ?>" class="bloc-article <?php hybrid_entry_class(); ?>">

		<?php if ( current_theme_supports( 'get-the-image' ) ) get_the_image( array( 'meta_key' => 'Thumbnail', 'size' => 'large' ) ); ?>
		<span class="categories"><?php the_category(' '); ?></span>
		<header class="entry-header">
			<?php echo apply_atomic_shortcode( 'entry_title', '[entry-title tag="h3"]' ); ?>
		</header><!-- .entry-header -->
		<span class="entry-summary"><?php echo(get_the_excerpt()); ?></span>
		<i class="fa fa-eye"></i><a class="read-more" href="<?php get_permalink( get_the_ID() ); ?>">Lire L'article</a>

		</p>
	</article><!-- .hentry -->
	<?php } ?>

