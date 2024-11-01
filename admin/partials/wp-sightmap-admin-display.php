<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wearestudio.com
 * @since      1.0.0
 *
 * @package    Wp_Sightmap
 * @subpackage Wp_Sightmap/admin/partials
 */
?>

<div class="wrap">


    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

    <div class="postbox-container">
      <form method="post" action="<?php echo esc_html( admin_url( 'admin-post.php' ) ); ?>">

            <table class="form-table">
          <tbody><tr class="user-email-wrap">
          	<th><label for="wp-sightmap-url">SightMap URL <span class="description">(required)</span></label></th>
          	<td><input name="wp-sightmap-url" id="wp-sightmap-url" value="<?php echo esc_attr( get_option('wp-sightmap-url') ); ?>" class="regular-text ltr" type="url" required>
          		</td>
          </tr>


          </tbody></table>

          <?php
              wp_nonce_field( 'sightmap-settings-save', 'sightmap-settings' );
              submit_button('Save Settings');
          ?>
      </form>
    </div>

</div><!-- .wrap -->
