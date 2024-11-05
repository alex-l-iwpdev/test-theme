<?php
/**
 * Main theme class.
 *
 * @package iwpdev/test-theme
 */

namespace TestTheme;

use WPCF7_ContactForm;
use WPCF7_Submission;

/**
 * Main class file.
 */
class Main {
	/**
	 * Main construct.
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 * Init actions and filter.
	 *
	 * @return void
	 */
	public function init(): void {
		add_action( 'wpcf7_before_send_mail', [ $this, 'mail_send_to_tg' ] );
	}

	/**
	 * Mail send to TG.
	 *
	 * @param WPCF7_ContactForm $wpcf7 Contact form 7 form instance.
	 *
	 * @return void
	 */
	public function mail_send_to_tg( WPCF7_ContactForm $wpcf7 ) {
		// get the form instance.
		$submission = WPCF7_Submission::get_instance();

		// get data from the form.
		$posted_data = $submission->get_posted_data();

		// Class that sends data from the form to the telegram bot.
		$message_send = TelegramSender::send_to_tg_chanel( $posted_data );

		if ( isset( $message_send['error'] ) ) {
			$wpcf7->set_properties(
				[
					'messages' => [
						'validation_error' => 'An error occurred while submitting the form. Please check the entered data.',
					],
				]
			);

			// Set the error flag.
			add_filter(
				'wpcf7_validate',
				function ( $result ) {
					$result->invalidate( null, 'An error occurred while submitting the form.' );

					return $result;
				}
			);
		}
	}
}
