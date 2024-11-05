<?php
/**
 * Telegram sender class.
 *
 * @package iwpdev/test-theme
 */

namespace TestTheme;

use GuzzleHttp\Client;

/**
 * TelegramSender class file.
 */
class TelegramSender {

	/**
	 * Telegram token
	 */
	const TELEGRAM_TOKEN = '7687735227:AAF0HeUa-x6a3jE0nKgUIW7678jhyyosz1o';

	/**
	 * Telegram chat id.
	 */
	const TELEGRAM_CHAT_ID = '259089982';

	/**
	 * Telegram API base url.
	 */
	const TELEGRAM_API_BASE_URL = 'https://api.telegram.org';

	/**
	 * Send to tg chanel.
	 *
	 * @param array $data From data.
	 *
	 * @return array|true[]
	 */
	public static function send_to_tg_chanel( $data ) {

		// Create an http client with base url settings.
		$client = new Client(
			[
				'base_uri' => self::TELEGRAM_API_BASE_URL,
			]
		);

		// A function that will convert form data into Markdown text.
		$markdown_data = self::data_markdown_text_by_form_data( $data );

		// Sending data to Telegram bot.
		$response = $client->request(
			'GET',
			'/bot' . self::TELEGRAM_TOKEN . '/sendMessage',
			[
				'query' => [
					'chat_id'    => self::TELEGRAM_CHAT_ID,
					'text'       => $markdown_data,
					'parse_mode' => 'Markdown',
				],
			]
		);

		// Receive a response from the API.
		$body     = $response->getBody();
		$arr_body = json_decode( $body, false, 512, JSON_THROW_ON_ERROR );

		// If you get a good answer.
		if ( $arr_body->ok ) {
			return [ 'success' => true ];
		}

		// Received an error in response.
		return [ 'error' => $arr_body ];
	}

	/**
	 * Data markdown text by form data.
	 *
	 * @param array $data Form data array.
	 *
	 * @return string
	 */
	private static function data_markdown_text_by_form_data( array $data ): string {
		$markdown_text = '';

		if ( empty( $data ) ) {
			return '';
		}

		foreach ( $data as $key => $value ) {
			switch ( $key ) {
				// Input name.
				case 'your-name':
					$markdown_text .= '* Name:' . $value . '* ' . "\n";
					break;
				case 'your-email':
					$markdown_text .= '* Email:' . $value . '* ' . "\n";
					break;
				case 'your-subject':
					$markdown_text .= '* Email Subject:' . $value . '* ' . "\n";
					break;
				case 'your-message':
					$markdown_text .= '* Message:' . $value . '* ' . "\n";
					break;
			}
		}

		return $markdown_text;
	}
}
