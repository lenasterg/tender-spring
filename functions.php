<?php
/**
 * tenderSpring functions and definitions
 *
 * @package tenderSpring
 * @since tenderSpring 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since tenderSpring 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 * @since 2.0.0
 */
add_theme_support( 'title-tag' );
	
if ( ! function_exists( 'tenderSpring_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since tenderSpring 1.0
 */
function tenderSpring_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom Theme Options
	 */
	require( get_template_directory() . '/inc/theme-options/theme-options.php' );

	/**
	 * This theme styles the visual editor with editor-style.css to match the theme style.
	 */
	add_editor_style();

	

	/* Jetpack Infinite Scroll */
	add_theme_support( 'infinite-scroll', array(
		'container'  => 'content',
		'footer'     => 'main',
		'footer_widgets' => 'tenderSpring_infinite_scroll_has_footer_widgets',
	) );

	function tenderSpring_infinite_scroll_has_footer_widgets() {
		if ( function_exists( 'jetpack_is_mobile' ) &&  jetpack_is_mobile( '', true ) && is_active_sidebar( 'sidebar-1' ) )
			return true;

		return false;
	}

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );
	
	/**
	 * Add post thumbnails
	 */
	add_theme_support( 'post-thumbnails' ); 
	set_post_thumbnail_size( 150, 150, true ); // default Post Thumbnail dimensions (cropped)

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'tender-spring' ),
	) );
	
	/**
	 * Language
	 */
	load_theme_textdomain('tender-spring', get_template_directory() . '/languages');
}
endif; // tenderSpring_setup

add_action( 'after_setup_theme', 'tenderSpring_setup' );

/* Filter to add author credit to Infinite Scroll footer */
function tenderSpring_footer_credits( $credit ) {
	$credit = sprintf( __( '%3$s | Theme: %1$s by %2$s.', 'tender-spring' ), 'Tender Spring', '<a href="http://regretless.com/" rel="designer">Ying Zhang</a>', '<a href="https://wordpress.org/" title="' . esc_attr( __( 'A Semantic Personal Publishing Platform', 'tender-spring' ) ) . '" rel="generator">Proudly powered by WordPress</a>' );
	return $credit;
}
add_filter( 'infinite_scroll_credit', 'tenderSpring_footer_credits' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since tenderSpring 1.0
 */
function tenderSpring_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar', 'tender-spring' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );
}
add_action( 'widgets_init', 'tenderSpring_widgets_init' );

/**
 * Update excerpt more text
 *
 * @since tenderSpring 1.0
 */
function tenderSpring_new_excerpt_more($more) {
    global $post;
	$excerpt_more = sprintf( __( ' <a href="%1$s">Continue reading &#8594;</a>', 'tender-spring' ), get_permalink($post->ID) );

	return $excerpt_more;
}
add_filter('excerpt_more', 'tenderSpring_new_excerpt_more');

/**
 * Enqueue scripts and styles
 */
function tenderSpring_scripts() {

	wp_enqueue_style( 'style', get_stylesheet_uri() );

	wp_enqueue_script( 'jquery' );
	
	wp_enqueue_script( 'tinynav.min', get_template_directory_uri() . '/js/tinynav.min.js', array( 'jquery' ), '20130304', true );

	wp_enqueue_script( 'onload', get_template_directory_uri() . '/js/onload.js', array( 'jquery' ), '20130304', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_style( 'googleFonts', '//fonts.googleapis.com/css?family=Janda Elegant Handwriting|Port Lligat Sans|Roboto' );

}
add_action( 'wp_enqueue_scripts', 'tenderSpring_scripts' );


/**
 * Custom CSS support
 */
function tenderSpring_custom_css() {
   $options = get_option( 'tenderSpring_theme_options' );
	if ( (is_array( $options ) ) && ( array_key_exists( 'custom_css', $options ) ) ) {
		$tenderSpring_customcss = $options['custom_css'];
		if ( $tenderSpring_customcss ) {
			echo "<style type='text/css'>";
			echo $tenderSpring_customcss;
			echo '</style>';
		}
	}
}
add_action('wp_head', 'tenderSpring_custom_css');


/**
 * Custom page title
 */
function tenderSpring_filter_wp_title( $title, $separator ) {
	// Don't affect wp_title() calls in feeds.
	if ( is_feed() ) {
		return $title;
	}
	// The $paged global variable contains the page number of a listing of posts.
	// The $page global variable contains the page number of a single post that is paged.
	// We'll display whichever one applies, if we're not looking at the first page.
	global $paged, $page;

	if ( is_search() ) {
		// If we're a search, let's start over:
		$title = sprintf( 'Search results for %s', '"' . get_search_query() . '"' );
		// Add a page number if we're on page 2 or more:
		if ( $paged >= 2 )
			$title .= " $separator " . sprintf( 'Page %s', $paged );
		// Add the site name to the end:
		$title .= " $separator " . get_bloginfo( 'name', 'display' );
		// We're done. Let's send the new title back to wp_title():
		return $title;
	}

	// Otherwise, let's start by adding the site name to the end:
	$title .= get_bloginfo( 'name', 'display' );

	// If we have a site description and we're on the home/front page, add the description:
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $separator " . $site_description;

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $separator " . sprintf( 'Page %s', max( $paged, $page ) );

	// Return the new title to wp_title():
	return $title;
}
add_filter( 'wp_title', 'tenderSpring_filter_wp_title', 10, 2 );

/**
 * Custom post thumbnail (featured image)
 */
function tenderSpring_post_image_html( $html, $post_id, $post_image_id ) {

	$html = '<div class="tenderSpring-post-thumbnail" style="background: url(' . wp_get_attachment_url( get_post_thumbnail_id($post_id) ) . ') no-repeat center center;background-size: 200px"><div class="tenderSpring-post-thumbnail-inner">' . $html . '</div></div>';

	return $html;
}
add_filter( 'post_thumbnail_html', 'tenderSpring_post_image_html', 10, 3);
