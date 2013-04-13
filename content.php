<?php
/**
 * @package tenderSpring
 * @since tenderSpring 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
	<div class="entry-wrapper">
	<div class="entry-wrapper-inner">

		<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
		<div class="featured-post">
			<?php _e( 'Featured Post', 'tenderSpring' ); ?>
		</div>
		<?php endif; ?>

	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tenderSpring' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail(); ?>
			<?php edit_post_link( __( 'Edit', 'tenderSpring' ), '<span class="edit-link featured">', '</span>' ); ?>
		<?php else : ?>
			<?php edit_post_link( __( 'Edit', 'tenderSpring' ), '<span class="edit-link">', '</span>' ); ?>
		<?php endif; ?>
		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php tenderSpring_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&raquo;</span>', 'tenderSpring' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'tenderSpring' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->
	<?php endif; ?>

	<footer class="entry-meta">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'tenderSpring' ) );
				if ( $categories_list && tenderSpring_categorized_blog() ) :
			?>
			<span class="cat-links">
				<?php printf( __( 'Posted in %1$s', 'tenderSpring' ), $categories_list ); ?>
			</span>
			<?php endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'tenderSpring' ) );
				if ( $tags_list ) :
			?>
			<span class="sep"> | </span>
			<span class="tag-links">
				<?php printf( __( 'Tagged %1$s', 'tenderSpring' ), $tags_list ); ?>
			</span>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type() ?>

		<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
		<span class="sep"> | </span>
		<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'tenderSpring' ), __( '1 Thought', 'tenderSpring' ), __( '% Thoughts', 'tenderSpring' ) ); ?></span>
		<?php endif; ?>

	</footer><!-- .entry-meta -->
	</div><!-- .entry-wrapper-inner -->
	</div><!-- .entry-wrapper -->
</article><!-- #post-<?php the_ID(); ?> -->
