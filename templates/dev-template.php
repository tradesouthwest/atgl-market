<?php 

//* Force full width content layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

remove_action('genesis_loop', 'genesis_do_loop');
do_action( 'commentary_archive_loop' );

genesis();


/**
 * Use Archive Loop
 *
 */
function commentary_use_archive_loop() {

	if( ! is_singular() ) {
		add_action( 'genesis_loop', 'commentary_archive_loop' );
		remove_action( 'genesis_loop', 'genesis_do_loop' );
	}
}
add_action( 'genesis_setup', 'commentary_use_archive_loop', 20 );

function commentary_use_single_loop() {
	if( is_singular() ) {
		add_action( 'genesis_loop', 'commentary_single_loop' );
		remove_action( 'genesis_loop', 'genesis_do_loop' );
	}
}
add_action( 'genesis_setup', 'commentary_use_single_loop', 20 );

function commentary_single_loop(){
	$args = array(
            'post_type' => 'commentary' // your custom post type
		);

    // Accepts WP_Query args 
    // (http://codex.wordpress.org/Class_Reference/WP_Query)
    genesis_custom_loop( $args );
}

/**
 * Archive Loop
 * Uses template partials
 */
function commentary_archive_loop() {

	if ( have_posts() ) {

		do_action( 'genesis_before_while' );

		while ( have_posts() ) {

			the_post();
			do_action( 'genesis_before_entry' );

			// Template part
			$partial = apply_filters( 'ea_loop_partial', 'archive' );
			$context = apply_filters( 'ea_loop_partial_context', is_search() ? 'search' : get_post_type() );
			get_template_part( 'partials/' . $partial, $context );

			do_action( 'genesis_after_entry' );

		}

		do_action( 'genesis_after_endwhile' );

	} else {

		do_action( 'genesis_loop_else' );

	}
}
/**
 * Single "Loop"
 * Uses template partials
 */
function commentary_single_loop() {

	if ( have_posts() ) {

		do_action( 'genesis_before_while' );

		while ( have_posts() ) {

			the_post();
			do_action( 'genesis_before_entry' );
			
// Template part
			echo '<div class="page hentry entry">';
		echo '<div id="commentary-article">';
 			echo '<div class="one-fourth first">';
 				echo '<div class="commentary-thumbnail">
						<div class="featured-img">'. get_the_post_thumbnail( $id, array(150,150) )
	 					.'</div>
	 				  </div>';
 			echo '</div>';
 				echo '<div class="three-fourths" style="border-bottom:1px solid #DDD;">';
 					echo '<h3>' . get_the_title() . '</h3>';
 					echo '<div clas="inner-content">' . get_the_content() 
					   . '</div>';
 				echo '</div>';
 		echo '</div><!-- end .commentary-article -->';
		}

		do_action( 'genesis_after_endwhile' );
echo '</div><!-- end .entry-content -->';
 	echo '</div><!-- end .page .hentry .entry -->';
	
	} else {

		do_action( 'genesis_loop_else' );

	} 
}			
			