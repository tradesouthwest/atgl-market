<?php
/**
 * Template Name: Commentary Single
 * Description: Used as a page template to show page contents, followed by a loop through a CPT archive 
 * https://gist.github.com/paaljoachim/4e9ca3489dbdd6ba3f4d
 */
//* Force full width content layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
//* Add custom body class to the head
add_filter( 'body_class', 'atgl_market_body_class' );
function atgl_market_body_class( $classes ) {
	$classes[] = 'atgl-market-tmplt';
	return $classes;
}
//* Remove the entry meta in the entry header
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_post_info', 2 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 10 );

//* Remove the entry image
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 10 );

//* Add the featured image after post title
add_action( 'genesis_entry_content', 'minimum_market_thumbnail_grid', 8 );
function minimum_market_thumbnail_grid() {
if ( $image = genesis_get_image( 'format=url&size=portfolio' ) ) {
		printf( '<div class="portfolio-image"><a href="%s" rel="bookmark"><img src="%s" alt="%s" /></a></div>', get_permalink(), $image, the_title_attribute( 'echo=0' ) );

	}
}
//* Remove the author box on single posts
remove_action( 'genesis_after_entry', 'genesis_do_author_box_single', 10 );
add_action( 'genesis_after_entry', 'atgl_market_do_author_box_single', 20 );
function atgl_market_do_author_box_single(){

	printf( '<div class="atgl-market-author">
			<p>Posted by: %s </p>
		</div>',
		  esc_html( get_the_author() )
		  );
	
}

//* Remove the entry meta in the entry footer
//remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 25 );

remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
add_action( 'genesis_entry_footer', 'atgl_market_footer_category', 31 );

function atgl_market_footer_category(){
	
	$taxonomy = 'atgl_market_category';
	$terms    = get_terms($taxonomy); // Get all terms of a taxonomy
	?>
		<div class="atgl-footer-meta">
			<ul style="display:inline-block;">
			<li style="float:left">Category: </li>
		<?php 
	if ( $terms && !is_wp_error( $terms ) ) :
    
		foreach ( $terms as $term ) { 
        ?>
			<li style="float:left"><a href="<?php echo get_term_link($term->slug, $taxonomy); ?>"><?php echo $term->name; ?></a></li>
        <?php 
		} 
			
    endif; 
			echo '</ul>
			</div>';

}

//remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );

//* Remove the comments template

//* Run the Genesis loop
genesis();
