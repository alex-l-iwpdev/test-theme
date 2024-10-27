<?php
/**
 * Wp Bakery Swiper slider.
 *
 * @package iwpdev/test-theme
 */

namespace TestTheme;

/**
 * WPBakerySwiperJsSlider class file.
 */
class WPBakerySwiperJsSlider {

	/**
	 * Icon folder url.
	 *
	 * @var string
	 */
	private string $icon_url = '';

	/**
	 * Swiper slider construct.
	 */
	public function __construct() {
		add_shortcode( 'wpb_swiper_slider', [ $this, 'output' ] );

		// Map shortcode to Visual Composer.
		if ( function_exists( 'vc_lean_map' ) ) {
			vc_lean_map( 'wpb_swiper_slider', [ $this, 'map' ] );
		}

		$this->icon_url = get_template_directory_uri() . '/img/icons/';
	}

	/**
	 * Map field.
	 *
	 * @return array
	 */
	public function map(): array {
		return [
			'name'                    => esc_html__( 'WPBakery Swiper Slider', 'twentytwentytwo' ),
			'description'             => esc_html__( 'WPBakery Swiper Slider', 'twentytwentytwo' ),
			'base'                    => 'wpb_swiper_slider',
			'category'                => __( 'IWPDEV', 'twentytwentytwo' ),
			'show_settings_on_create' => false,
			'icon'                    => $this->icon_url . 'photo-film-solid.svg',
			'params'                  => [
				[
					'type'       => 'param_group',
					'value'      => '',
					'heading'    => __( 'Логотипи', 'alevel' ),
					'param_name' => 'logos',
					'params'     => [
						[
							'type'       => 'attach_image',
							'value'      => '',
							'heading'    => __( 'Логотип', 'alevel' ),
							'param_name' => 'slide_image',
						],
						[
							'type'       => 'textfield',
							'value'      => '',
							'heading'    => __( 'Посилання на компанію', 'alevel' ),
							'param_name' => 'company_link',
						],
					],
				],
				[
					'type'       => 'css_editor',
					'heading'    => esc_html__( 'Кастомний css', 'alevel' ),
					'param_name' => 'css',
					'group'      => esc_html__( 'Варіанти дизайну', 'alevel' ),
				],
			],
		];
	}

	/**
	 * Output Short Code template
	 *
	 * @param mixed       $atts    Attributes.
	 * @param string|null $content Content.
	 *
	 * @return string
	 */
	public function output( $atts, string $content = null ): string {
		ob_start();
		include Main::ALV_DIR_PATH . '/WpBakery/template/LogoSlider/template.php';

		return ob_get_clean();
	}
}
