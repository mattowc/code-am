<?php
/**
 * Integrates contact form 7 and Mail Chimp.
 *
 * I've seen and used multiple plugins that achieve some functionality.  The
 * problem is that you may want list segmentation, and different solutions
 * didn't offer this.  To use, when adding a form with contact form 7, ensure
 * the email field is aptly labeled:  
 * email-$listKey
 * Replace $listKey with the unique list id.  
 *
 * @author Jonathon McDonald <jon@onewebcentric.com>
 */
class JM_Contact
{
	private $arr;

	/**
	 * Hook into contact form 7
	 */
	function __construct()
	{
		add_action( 'wpcf7_mail_sent', array( $this, 'contactChimpIntegration' ), 1 );
	}

	/**
	 * Parse the contact form 7 data.  
	 *
	 * If we find a field as defined in the specification above, we add it to the given 
	 * list.   
	 */
	function contactChimpIntegration( $cfdata )
	{
		$forms = $cfdata->posted_data;
		$key   = 0;

		// Get all the keys of the posted data (form names in contact form 7)
		$arr = array_keys( $forms );

		foreach( $arr as $form )
		{
			// email-$listKey
			if( preg_match( "/^email-.*$/", $form ) )
			{
				$email_key = $form;
				$key = substr($form, 6);

				// Subscribe the user
				$api = new MCAPI( get_option( 'mailchimp_api' ) ); 
				$api->listSubscribe( $key, $forms[$email_key] );
			}
		}
	}
}

new JM_Contact;