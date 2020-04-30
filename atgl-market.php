<?php
/**
 * ATGL Market
 *
 * @package   ATGL_Post_Market
 * @license   GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: ATGL Market Posts
 * Plugin URI:  http://github.com/tradesouthwest/atgl-posts
 * Description: Enables a post type for Market and one for Education and related taxonomies.
 * Version:     1.0.2
 * Author:      Larry Judd
 * Author URI:  https://tradesouthwest.com
 * Text Domain: atgl-market
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Required files for registering the post type and taxonomies.
require plugin_dir_path( __FILE__ ) . 'includes/class-atgl-post-type.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-atgl-post-type-registration.php';

// Instantiate registration class, so we can add it as a dependency to main plugin class.
$post_type_registration = new Atgl_Post_Type_Registration;

// Instantiate main plugin file, so activation callback does not need to be static.
$post_type = new Atgl_Post_Type( $post_type_registration );

// Register callback that is fired when the plugin is activated.
register_activation_hook( __FILE__, array( $post_type, 'activate' ) );

// Initialize registrations for post-activation requests.
$post_type_registration->init();

/**
 * Adds styling to the dashboard for the post type and adds docs posts
 * to the "At a Glance" metabox.
 */
if ( is_admin() ) {
 
	require plugin_dir_path( __FILE__ ) . 'includes/class-atgl-post-type-admin.php';

	$post_type_admin = new Atgl_Post_Type_Admin( $post_type_registration );
	$post_type_admin->init();

}
// enqueue styles
function atgl_posts_public_style() 
{
	wp_enqueue_style( 'atgl-market', 
	plugin_dir_url(__FILE__) . '/css/atgl-style.css', array(), '1.0.1', false );
}
add_action( 'wp_enqueue_scripts', 'atgl_posts_public_style' );
 
/**
 * Attaches the specified template to the page identified by the specified name.
 *
 * @params    $page_name        The name of the page to attach the template.
 * @params    $template_path    The template's filename (assumes .php' is specified)
 *
 * @returns   false if the page does not exist; otherwise, the ID of the page.
 * @could-use add_filter('single_template' or 'template_include')
 */
function atgl_posts_attach_single_template_to_page( $template ) {
	// Post ID
		$post_id = get_the_ID();
	 
		// For all other CPT
		if ( get_post_type( $post_id ) != 'atgl_market' ) {
			return $template;
		}
	 
		// Else use custom template
		if ( is_single() ) {
			return atgl_posts_single_template_hierarchy( 'single-market' );
		}
	} 
	add_filter( 'single_template', 'atgl_posts_attach_single_template_to_page' );
	
	/**
	 * Get the custom Single template if is set
	 *
	 * @since 1.0
	 */
	 
	function atgl_posts_single_template_hierarchy( $template ) {
	 
		// Get the template slug
		$template_slug = rtrim( $template, '.php' );
		$template = $template_slug . '.php';
	 
		// Check if a custom template exists in the theme folder, if not, load the plugin template file
		if ( $theme_file = locate_template( array( 'plugin_template/' . $template ) ) ) {
			$file = $theme_file;
		}
		else {
			$file = plugin_dir_path( __FILE__ ) . 'templates/' . $template;
		}
	 
		return apply_filters( 'atgl_posts_single_template_' . $template, $file );
	} 
	
	// Taxonomies
	function atgl_posts_attach_archive_template_to_page( $template ) {
	// Post ID
		//$post_id = get_the_ID();
	 
		// For all other CPT
		if ( !is_tax('atgl_market_category') ) {
			return $template;
		}
	 
		// Else use custom template
		if ( is_tax() ) {
			return atgl_posts_archive_template_hierarchy( 'archive-market' );
		}
	} 
	add_filter( 'template_include', 'atgl_posts_attach_archive_template_to_page' );
    function atgl_posts_archive_template_hierarchy( $template ) {
	 
		// Get the template slug
		$template_slug = rtrim( $template, '.php' );
		$template = $template_slug . '.php';
	 
		// Check if a custom template exists in the theme folder, if not, load the plugin template file
		if ( $theme_file = locate_template( array( 'plugin_template/' . $template ) ) ) {
			$file = $theme_file;
		}
		else {
			$file = plugin_dir_path( __FILE__ ) . 'templates/' . $template;
		}
	 
		return apply_filters( 'atgl_posts_archive_template_' . $template, $file );
	} 

		
require_once plugin_dir_path( __FILE__ ) . 'class-atgl-posts-formats.php';
if( class_exists( 'Atgl_Post_Formats' ) ) : 
$formats = array('image', 'aside');
asort($formats);
$post_formats = new Atgl_Post_Formats( $formats, array( 'atgl_market' ) ); 
endif; 
?>
