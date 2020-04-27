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
function atgl_market_disable_srcset( $sources ) {
    return false;
}
add_filter( 'wp_calculate_image_srcset', 'atgl_market_disable_srcset' );

// Force full width content
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
add_action( 'genesis_entry_content', 'atgl_market_page_archive_content' );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

function atgl_market_page_archive_content() {
	
    $post_type    = 'atgl_market';
    $tax          = 'atgl_market_category';
    $current_term = get_term_by( 'slug', get_query_var( 'term_id' ), get_query_var( 'taxonomy' ) );
    $tax_terms    = get_terms($tax);
    
    if ($tax_terms) {
	    
    	foreach ($tax_terms as $tax_term) {  	
        
	        $args = array(
                                'post_type'             => $post_type,
                                'post_status'           => 'publish',
                                'posts_per_page'        => 25,
                                'child_of'   => $current_term->term_id,
								'taxonomy'   => $current_term->taxonomy,
								'hide_empty' => 0,
									'hierarchical' => false,
									'depth'        => 1,
							    );
	    
	        $atgl_query = null;
	        $atgl_query = new WP_Query($args);
			 if( $atgl_query->have_posts() ) { ?>
				

				<?php 
				 while ($atgl_query->have_posts()) : $atgl_query->the_post(); ?>
				
				<div class="market-archive-entry">
					
			<h4><a href="<?php the_permalink() ?>" rel="bookmark" 
				   title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>

				<?php the_excerpt(); ?>

				<div class="market-archives-footer">
					<hr><br>
				</div>
			<?php endwhile;
			
        	}
        wp_reset_query();
      }
	}

}

genesis(); 
