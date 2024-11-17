<?php
/**
 * Custom REST API.
 *
 * @package iwpdev/test-theme
 */

namespace TestTheme;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;

/**
 * CustomRESTApi class.
 */
class CustomRESTApi {

	/**
	 * Route namespace.
	 */
	const CUSTOM_API_NAMESPACE = 'jwt_token_auth/v1';

	/**
	 * Needed if the AUTH_KEY key is not set in the settings
	 */
	const CUSTOM_API_AUT_KEY_SALT = 'Some_test_key';

	/**
	 * CustomRESTApi construct.
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 * Init Actions and Filters.
	 *
	 * @return void
	 */
	private function init(): void {
		add_action( 'rest_api_init', [ $this, 'register_new_rest_routes' ] );
	}

	/**
	 * Register route.
	 *
	 * @return void
	 */
	public function register_new_rest_routes(): void {
		register_rest_route(
			self::CUSTOM_API_NAMESPACE,
			'/auth',
			[
				'methods'             => WP_REST_Server::CREATABLE,
				'callback'            => [ $this, 'auth_callback' ],
				'permission_callback' => '__return_true',
				'args'                => [
					'email'    => [
						'type'              => 'string',
						'required'          => true,
						'format'            => 'email',
						'validate_callback' => function ( $param ) {
							return filter_var( $param, FILTER_VALIDATE_EMAIL );
						},
					],
					'password' => [
						'type'              => 'string',
						'required'          => true,
						'validate_callback' => function ( $param ) {
							return filter_var( $param, FILTER_SANITIZE_FULL_SPECIAL_CHARS );
						},
					],
				],
			]
		);

		register_rest_route(
			self::CUSTOM_API_NAMESPACE,
			'/get-posts',
			[
				'methods'             => WP_REST_Server::CREATABLE,
				'callback'            => [ $this, 'get_post_callback' ],
				'permission_callback' => '__return_true',

			]
		);
	}

	/**
	 * Auth callback.
	 *
	 * @param WP_REST_Request $request Params.
	 *
	 * @return WP_REST_Response
	 */
	public function auth_callback( WP_REST_Request $request ): WP_REST_Response {

		$params = $request->get_json_params();

		if ( ! email_exists( $params['email'] ) ) {
			return new WP_REST_Response(
				[
					'error' => __( 'User no exist', 'domain' ),
				],
				403
			);
		}

		$key = defined( 'AUTH_KEY' ) ? AUTH_KEY : self::CUSTOM_API_AUT_KEY_SALT;

		$jwt = JWT::encode(
			[
				'email'    => $params['email'],
				'password' => $params['password'],
			],
			$key,
			'HS256'
		);

		// ...Additional processing code or storage in the database.

		return new WP_REST_Response(
			[
				'error' => null,
				'token' => $jwt,
			],
			200
		);
	}

	/**
	 * Get some data.
	 *
	 * @param WP_REST_Request $request Request.
	 *
	 * @return WP_REST_Response
	 */
	public function get_post_callback( WP_REST_Request $request ): WP_REST_Response {
		$header_token = $request->get_header( 'authorization' );
		$token        = str_replace( 'Bearer ', '', $header_token );
		$key          = defined( 'AUTH_KEY' ) ? AUTH_KEY : self::CUSTOM_API_AUT_KEY_SALT;

		$decode_token = JWT::decode( $token, new Key( $key, 'HS256' ) );

		$user = wp_signon(
			[
				'user_login'    => $decode_token->email,
				'user_password' => $decode_token->password,
			],
			false
		);

		if ( is_wp_error( $user ) ) {
			return new WP_REST_Response(
				[
					'error' => __( 'Incorrect access token', 'domain' ),
				],
				403
			);
		}

		// ... The code that your API returns.

		return new WP_REST_Response(
			[
				'error'    => null,
				'response' => [ 'data' => 'Some data' ],
			],
			200
		);
	}
}
