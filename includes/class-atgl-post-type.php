<?php
/**
 * Atgl Market
 *
 * @package   Atgl_Market
 * @license   GPL-2.0+
 */

/**
 * Registration of CPT and related taxonomies.
 *
 * @since 0.1.0
 */
class Atgl_Post_Type {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since 0.1.0
	 *
	 * @var string VERSION Plugin version.
	 */
	const VERSION = '1.0.2';

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since 0.1.0
	 *
	 * @var string
	 */
	const PLUGIN_SLUG = 'agtl-market';

	protected $registration_handler;

	/**
	 * Initialize the plugin by setting localization and new site activation hooks.
	 *
	 * @since 0.1.0
	 */
	public function __construct( $registration_handler ) {

		$this->registration_handler = $registration_handler;

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );;

	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since 0.1.0
	 */
	public function activate() {
		$this->registration_handler->register();
		flush_rewrite_rules();
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since 0.1.0
	 */
	public function deactivate() {
		flush_rewrite_rules();
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since 0.1.0
	 */
	public function load_plugin_textdomain() {
		$domain = self::PLUGIN_SLUG;

		load_plugin_textdomain( $domain, FALSE, basename(dirname(__FILE__)).'/languages' );
	}

}
