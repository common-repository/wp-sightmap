<?php

/**
* The admin-specific functionality of the plugin.
*
* @link       https://wearestudio.com
* @since      1.0.0
*
* @package    Wp_Sightmap
* @subpackage Wp_Sightmap/admin
*/

/**
* The admin-specific functionality of the plugin.
*
* Defines the plugin name, version, and two examples hooks for how to
* enqueue the admin-specific stylesheet and JavaScript.
*
* @package    Wp_Sightmap
* @subpackage Wp_Sightmap/admin
* @author     Studio by Engrain <hello@wearestudio.com>
*/
class Wp_Sightmap_Admin
{

	/**
	* The ID of this plugin.
	*
	* @since    1.0.0
	* @access   private
	* @var      string    $plugin_name    The ID of this plugin.
	*/
	private $plugin_name;

	/**
	* The version of this plugin.
	*
	* @since    1.0.0
	* @access   private
	* @var      string    $version    The current version of this plugin.
	*/
	private $version;

	/**
	* Initialize the class and set its properties.
	*
	* @since    1.0.0
	* @param      string    $plugin_name       The name of this plugin.
	* @param      string    $version    The version of this plugin.
	*/
	public function __construct($plugin_name, $version)
	{
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	* Register the stylesheets for the admin area.
	*
	* @since    1.0.0
	*/
	public function wpsm_enqueue_styles()
	{
		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wp-sightmap-admin.css', array(), $this->version, 'all');
	}

	/**
	* Register the JavaScript for the admin area.
	*
	* @since    1.0.0
	*/
	public function wpsm_enqueue_scripts()
	{
		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wp-sightmap-admin.js', array( 'jquery' ), $this->version, false);
	}

	/**
	* Register admin page contents.
	*
	* @since    1.0.0
	*/
	public function wpsm_admin_page()
	{
		include_once 'partials/wp-sightmap-admin-display.php';
	}

	/**
	* Register admin page menu item.
	*
	* @since    1.0.0
	*/
	public function wpsm_add_menu_items()
	{
		$icon = 'dashicons-admin-generic';
		add_menu_page('WP SightMap', 'WP SightMap', 'manage_options', 'sightmap', array( $this, 'wpsm_admin_page' ), $icon, 81);
	}

	/**
	* Register admin form capture.
	*
	* @since    1.0.0
	*/
	public function wpsm_save()
	{
		// First, validate the nonce and verify the user as permission to save.
		if ( ! ( $this->wpsm_has_valid_nonce() && current_user_can( 'manage_options' ) ) ) {
			return;
		}

		// If the above are valid, sanitize and save the option.
		if ( null !== wp_unslash( $_POST['wp-sightmap-url'] ) ) {

			$value = sanitize_text_field( $_POST['wp-sightmap-url'] );
			update_option( 'wp-sightmap-url', $value );

		}

		$this->wpsm_redirect();

	}

	/**
	* Get saved admin option.
	*
	* @since    1.0.0
	*/
	public function wpsm_get_sightmap_url( ) {
		return get_option( 'wp-sightmap-url', '' );
	}

	/**
	* Determines if the nonce variable associated with the options page is set
	* and is valid.
	*
	* @access private
	*
	* @return boolean False if the field isn't set or the nonce value is invalid;
	*                 otherwise, true.
	*/
	private function wpsm_has_valid_nonce() {

		// If the field isn't even in the $_POST, then it's invalid.
		if ( ! isset( $_POST['sightmap-settings'] ) ) { // Input var okay.
			return false;
		}

		$field  = wp_unslash( $_POST['sightmap-settings'] );
		$action = 'sightmap-settings-save';

		return wp_verify_nonce( $field, $action );

	}

	/**
	* Redirect to the page from which we came (which should always be the
	* admin page. If the referred isn't set, then we redirect the user to
	* the login page.
	*
	* @access private
	*/
	private function wpsm_redirect() {

		// To make the Coding Standards happy, we have to initialize this.
		if ( ! isset( $_POST['_wp_http_referer'] ) ) { // Input var okay.
			$_POST['_wp_http_referer'] = wp_login_url();
		}

		// Sanitize the value of the $_POST collection for the Coding Standards.
		$url = sanitize_text_field(
			wp_unslash( $_POST['_wp_http_referer'] ) // Input var okay.
		);

		// Finally, redirect back to the admin page.
		wp_safe_redirect( urldecode( $url ) );
		exit;

	}
}
