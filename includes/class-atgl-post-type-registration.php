<?php
/**
 * Atgl Post Type
 *
 * @package   Atgl_Post_Type
 * @license   GPL-2.0+
 */

/**
 * Register post types and taxonomies.
 *
 * @package Atgl_Post_Type
 */
class Atgl_Post_Type_Registration {

	public $post_type = 'atgl_market';

	public $taxonomies = 'atgl_market_category';
	public $tags       = 'atgl_market_tag';

	public function init() {
		// Add the team post type and taxonomies
		add_action( 'init', array( $this, 'register' ) );
	}

	/**
	 * Initiate registrations of post type and taxonomies.
	 *
	 * @uses _Post_Type_Registration::register_post_type()
	 * @uses _Post_Type_Registration::register_taxonomy_categories()
	 */
	public function register() {
		$this->register_post_type();
		$this->register_taxonomy_categories();
		$this->register_taxonomy_tags();
	}

	/**
	 * Register the custom post type.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	protected function register_post_type() {
		$labels = array(
			'name'               => __( 'Market', 'atgl-market' ),
			'singular_name'      => __( 'Market', 'atgl-market' ),
			'add_new'            => __( 'Add Market', 'atgl-market' ),
			'add_new_item'       => __( 'Add New Market', 'atgl-market' ),
			'edit_item'          => __( 'Edit Market', 'atgl-market' ),
			'new_item'           => __( 'New Market', 'atgl-market' ),
			'view_item'          => __( 'View Market', 'atgl-market' ),
			'search_items'       => __( 'Search Markets', 'atgl-market' ),
			'not_found'          => __( 'No Markets found', 'atgl-market' ),
			'not_found_in_trash' => __( 'No Markets in the trash', 'atgl-market' ),
		);

		$supports = array(
			'title',
			'editor',
			'thumbnail',
			'custom-fields',
			'revisions',
		);

		$args = array(
			'labels'          => $labels,
			'supports'        => $supports,
			'public'          => true,
			'capability_type' => 'post',
			'rewrite'         => array( 'slug' => 'atgl-market', ), // Permalinks format
			'menu_position'   => 6,
			'menu_icon'       => 'dashicons-book',
			'has_archive'	  => true
		);

		$args = apply_filters( 'atgl_market_post_type_args', $args );

		register_post_type( $this->post_type, $args );
	}

	/**
	 * Register a taxonomy for atgl_market Categories.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	protected function register_taxonomy_categories() {
		$labels = array(
			'name'                       => __( 'Market Categories', 'atgl-market' ),
			'singular_name'              => __( 'Market Category', 'atgl-market' ),
			'menu_name'                  => __( 'Market Categories', 'atgl-market' ),
			'edit_item'                  => __( 'Edit Market Category', 'atgl-market' ),
			'update_item'                => __( 'Update Market Category', 'atgl-market' ),
			'add_new_item'               => __( 'Add New Market Category', 'atgl-market' ),
			'new_item_name'              => __( 'New Market Category Name', 'atgl-market' ),
			'parent_item'                => __( 'Parent Market Category', 'atgl-market' ),
			'parent_item_colon'          => __( 'Parent Market Category:', 'atgl-market' ),
			'all_items'                  => __( 'All Market Categories', 'atgl-market' ),
			'search_items'               => __( 'Search Market Categories', 'atgl-market' ),
			'popular_items'              => __( 'Popular Market Categories', 'atgl-market' ),
			'separate_items_with_commas' => __( 'Separate Market categories with commas', 'atgl-market' ),
			'add_or_remove_items'        => __( 'Add or remove Market categories', 'atgl-market' ),
			'choose_from_most_used'      => __( 'Choose from the most used Market categories', 'atgl-market' ),
			'not_found'                  => __( 'No Market categories found.', 'atgl-market' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'hierarchical'      => true,
			'rewrite'           => array( 'slug' => 'atgl-market-category' ),
			'show_admin_column' => true,
			'query_var'         => true,
		);

		$args = apply_filters( 'atgl_market_post_type_category_args', $args );

		register_taxonomy( $this->taxonomies, $this->post_type, $args );
	}

	/**
	 * Register a taxonomy for atgl_market Tags.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	protected function register_taxonomy_tags() {

		$labels = array(
			'name'                       => __( 'Market Tags', 'atgl-market' ),
			'singular_name'              => __( 'Market Tag', 'atgl-market' ),
			'menu_name'                  => __( 'Market Tags', 'atgl-market' ),
			'edit_item'                  => __( 'Edit Market Tag', 'atgl-market' ),
			'update_item'                => __( 'Update Market Tag', 'atgl-market' ),
			'add_new_item'               => __( 'Add New Market Tag', 'atgl-market' ),
			'new_item_name'              => __( 'New Market Tag Name', 'atgl-market' ),
			'parent_item'                => __( 'Parent Market Tag', 'atgl-market' ),
			'parent_item_colon'          => __( 'Parent Market Tag:', 'atgl-market' ),
			'all_items'                  => __( 'All Market Tags', 'atgl-market' ),
			'search_items'               => __( 'Search Market Tags', 'atgl-market' ),
			'popular_items'              => __( 'Popular Market Tags', 'atgl-market' ),
			'separate_items_with_commas' => __( 'Separate Market tags with commas', 'atgl-market' ),
			'add_or_remove_items'        => __( 'Add or remove Market tags', 'atgl-market' ),
			'choose_from_most_used'      => __( 'Choose from the most used Market tags', 'atgl-market' ),
			'not_found'                  => __( 'No Market tags found.', 'atgl-market' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'hierarchical'      => false,
			'rewrite'           => array( 'slug' => 'atgl-market-tag' ),
			'show_admin_column' => true,
			'query_var'         => true,
		);

		$args = apply_filters( 'atgl_market_post_type_tag_args', $args );

		register_taxonomy( $this->tags, $this->post_type, $args );

	}
} 
