<?php
/**
 * @package tenderSpring
 * @since tenderSpring 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-wrapper">
	<div class="entry-wrapper-inner">
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php edit_post_link( __( 'Edit', 'tender-spring' ), '<span class="edit-link">', '</span>' ); ?>
		<div class="entry-meta">
			<?php tenderSpring_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php if ( has_post_thumbnail() ) : ?>
		<div class="tenderSpring-post-thumbnail" style="background: url('<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>') no-repeat center center;background-size: 200px"><div class="tenderSpring-post-thumbnail-inner"></div></div>
		<?php endif; ?>
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'tender-spring' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( __( ', ', 'tender-spring' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', ', ' );

			if ( ! tenderSpring_categorized_blog() ) {
				// This blog only has 1 category so we just need to worry about tags in the meta text
				if ( '' != $tag_list ) {
					$meta_text = __( 'This entry was tagged %2$s.', 'tender-spring' );
				}

			} else {
				// But this blog has loads of categories so we should probably display them here
				if ( '' != $tag_list ) {
					$meta_text = __( 'This entry was posted in %1$s and tagged %2$s.', 'tender-spring' );
				} else {
					$meta_text = __( 'This entry was posted in %1$s.', 'tender-spring' );
				}

			} // end check for categories on this blog

			printf(
				$meta_text,
				$category_list,
				$tag_list,
				get_permalink(),
				the_title_attribute( 'echo=0' )
			);
		?>
	</footer><!-- .entry-meta -->
	</div><!-- .entry-wrapper-inner -->
	</div><!-- .entry-wrapper -->
</article><!-- #post-<?php the_ID(); ?> -->
