<?php
/**
 * Attaches an admin page, with basic options for mail chimp.
 *
 * This is hardcoded HTML.  If I extend or begin to add too many options
 * I will separate the logic out.  Essentially a user will be presented with 
 * two options (and a third option is planned):
 * - Mail Chimp API Key 
 * - List API Key
 * The developer then only needs to call get_option( 'mailchimp_api' )
 * get_option( ' mailchimp_list_key'), and new MCAPI( $apiKey ).  This plugin
 * is to make a developers life easier.  
 *
 * @author Jonathon McDonald <jon@onewebcentric.com>
 */
class JM_Options 
{
	/**
	 * Adds MailChimp options, attaches settings page to menu
	 *
	 * @todo Add proper Settings API
	 */
	function __construct()
	{
		add_option( 'mailchimp_api' );
		add_option( 'mailchimp_list_key' );
		add_action( 'admin_menu', array( &$this, 'constructAdminPage' ) );
	}

	/**
	 * Adds a Mail Chimp settings page
	 */
	function constructAdminPage()
	{
		add_options_page( 'Mail Chimp', 'Mail Chimp', 'manage_options', 'mail-chimp', array( &$this, 'adminPageHTML' ) );  
	}

	/**
	 * Generates the HTML page, and handles form processing
	 *
	 * @todo Separate business logic away from display
	 * @todo Incorporate better use of Settings API
	 * @todo Add hooks for settings saved
	 */
	function adminPageHTML()
	{
		// Construct the top of our admin page
		echo '<div class="wrap">';
		screen_icon();
		echo '<h2>Mail Chimp</h2>';

		// Handle if the form has been submitted
		if( isset( $_POST['submit_chimp'] ) && wp_verify_nonce( $_POST['mail_chimp_nonce'], 'update_chimp' ) )
		{
			update_option( 'mailchimp_api', $_POST['mailchimp_api_key'] );
			update_option( 'mailchimp_list_key', $_POST['mailchimp_api_id'] );
		}

		// Generate the form
		echo'<form method="post" action="">';
		echo'<table class="form-table">';

		// Row for the API Key
		echo'<tr valign="top"><th scope="row"><label for="mailchimp_api_key">Mail Chimp API Key</label></th>';
		echo'<td><input name="mailchimp_api_key" type="text" id="blogname" value="' . get_option('mailchimp_api') . '" class="regular-text"></td>';
		echo'</tr>';

		// Row for the List ID
		echo'<tr valign="top"><th scope="row"><label for="mailchimp_api_id">List ID</label></th>';
		echo'<td><input name="mailchimp_api_id" type="text" id="blogname" value="' . get_option('mailchimp_list_key') . '" class="regular-text"></td>';
		echo'</tr>';

		// End the table & add the submit button
		echo'</table>';
		echo'<p class="submit"><input type="submit" name="submit_chimp" id="submit" class="button-primary" value="Save Changes"></p>';

		// Nonce for security
		wp_nonce_field('update_chimp', 'mail_chimp_nonce');

		// End the form and the page
		echo'</form>';
		echo '</div>';
	}
}

new JM_Options;