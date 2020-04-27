<?php
/**
 * Market CPT Archives
 * Description: Used as a page template to show page contents, followed by a loop through a CPT archive 
 * https://gist.github.com/electricbrick/b172d2295e69741b6737
 */
// Throw a class on that bad boy
add_filter( 'body_class', 'atgl_add_market_tax_body_class' );
function atgl_add_market_tax_body_class( $classes ) {
	$classes[] = 'market-taxonomy';
	return $classes;
}

// Force full width content
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'atgl_market_taxonomy_archive_loop' );
function atgl_market_taxonomy_archive_loop() {

 //this loop returns all faculty separated by departments they belong to

 	$post_type = 'atgl_market';
    $tax = 'atgl_market_category';
    $current_term = get_term_by( 'slug', get_query_var( 'term_id	' ), get_query_var( 'taxonomy' ) );
    $tax_terms = get_terms($tax);
    $image_args = array(
		'size' => 'medium',
		'attr' => array(
			'class' => 'alignleft',
		),
	);
if ($tax_terms) {
	    
    	foreach ($tax_terms as $tax_term) {  	
        
	        $args = array(
                                'post_type'             => $post_type,
                                'post_status'           => 'publish',
                                'posts_per_page'        => 33,
                                'child_of' => $current_term->term_id,
								'taxonomy' => $current_term->taxonomy,
								'hide_empty' => 0,
									'hierarchical' => false,
									'depth'  => 1,
							    );
	    
	        $my_query = null;
	        $my_query = new WP_Query($args);
	        
	        if( $my_query->have_posts() ) {
				echo '<h3 class="dept-title">' . $tax_term->name . '</h3>';
				
				while ($my_query->have_posts()) : $my_query->the_post(); ?>
					
					<div class="faculty-entry">
					
					<?php 
					
					$image = genesis_get_image( $image_args );
					
					$position = get_field( '_faculty_position' );
					   
					if ( $image ) {
						echo '<a href="' . get_permalink() . '">' . $image .'</a>';
					} ?>
					
					<h4><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
					<?php echo '<p>' . $position . '</p>'; ?>
					<?php echo '</div>'; ?>
					<?php
					
				endwhile;
			
        }
        wp_reset_query();
      }
    }
    
    genesis_posts_nav(); 

}
//* Remove items from loop
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
 

 
//* Move Title below Image
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
add_action( 'genesis_entry_footer', 'genesis_entry_header_markup_open', 5 );
add_action( 'genesis_entry_footer', 'genesis_entry_header_markup_close', 15 );
add_action( 'genesis_entry_footer', 'genesis_do_post_title' );
 
//* Remove Archive Pagination
remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );

genesis(); 
