<?php

/**
* The public-facing functionality of the plugin.
*
* @link       https://wearestudio.com
* @since      1.0.0
*
* @package    Wp_Sightmap
* @subpackage Wp_Sightmap/public
*/

/**
* The public-facing functionality of the plugin.
*
* Defines the plugin name, version, and two examples hooks for how to
* enqueue the public-facing stylesheet and JavaScript.
*
* @package    Wp_Sightmap
* @subpackage Wp_Sightmap/public
* @author     Studio by Engrain <hello@wearestudio.com>
*/
class Wp_Sightmap_Public {

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
	* @param      string    $plugin_name       The name of the plugin.
	* @param      string    $version    The version of this plugin.
	*/
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	* Register the stylesheets for the public-facing side of the site.
	*
	* @since    1.0.0
	*/
	public function wpsm_enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-sightmap.min.css', array(), $this->version, 'all' );
	}

	/**
	* Register the JavaScript for the public-facing side of the site.
	*
	* @since    1.0.0
	*/
	public function wpsm_enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-sightmap.min.js', null, $this->version, true );
	}

		/**
		* Method to render the SightMap frame.
		*
		* @since    1.0.0
		*/
	public function wpsm_display_sightmap($modal = '', $addClass = '') {

		ob_start();
		?>
		<div class="sightmap-wp<?php echo $modal ?>">
			<div class="sightmap-wp-overlay<?php echo $addClass ?>">

				<svg class="sightmap-wp-close" aria-hidden="true" viewBox="0 0 512 512"><path fill="white" d="M464 32H48C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h416c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48zm0 394c0 3.3-2.7 6-6 6H54c-3.3 0-6-2.7-6-6V86c0-3.3 2.7-6 6-6h404c3.3 0 6 2.7 6 6v340zM356.5 194.6L295.1 256l61.4 61.4c4.6 4.6 4.6 12.1 0 16.8l-22.3 22.3c-4.6 4.6-12.1 4.6-16.8 0L256 295.1l-61.4 61.4c-4.6 4.6-12.1 4.6-16.8 0l-22.3-22.3c-4.6-4.6-4.6-12.1 0-16.8l61.4-61.4-61.4-61.4c-4.6-4.6-4.6-12.1 0-16.8l22.3-22.3c4.6-4.6 12.1-4.6 16.8 0l61.4 61.4 61.4-61.4c4.6-4.6 12.1-4.6 16.8 0l22.3 22.3c4.7 4.6 4.7 12.1 0 16.8z"></path></svg>

				<iframe id="sightmap-wp-embed" class="sightmap-wp-embed" src="<?php echo esc_attr( get_option('wp-sightmap-url') ); ?>" frameborder="0"></iframe>
			</div>
		</div>
		<?php
		$data = ob_get_clean();

		return $data;
	}

	/**
	* Register the the sightmap shortcode.
	*
	* @since    1.0.0
	*/
	public function wpsm_register_shortcode()
	{
		add_shortcode( 'sightmap', array( $this, 'wpsm_display_sightmap' ));
	}

	public function wpsm_insert_sightmap() {
		// don't inject the sightmap modal code into the page if it already has a sightmap from a shortcode
		global $post;

		if ( is_a( $post, 'WP_Post' ) && ! has_shortcode( $post->post_content, 'sightmap') )
		{
			echo $this->wpsm_display_sightmap(' sightmap-modal', ' sightmap-wp-overlay-slidedown');
		}
	}

}
