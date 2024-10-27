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

		$this->icon_url = get_stylesheet_directory_uri() . '/assets/img/icons/';
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
			'icon'                    => $this->icon_url . 'images-regular.svg',
			'params'                  => [
				[
					'type'       => 'param_group',
					'value'      => '',
					'heading'    => __( 'Slides', 'twentytwentytwo' ),
					'param_name' => 'slides',
					'params'     => [
						[
							'type'       => 'attach_image',
							'value'      => '',
							'heading'    => __( 'Slide', 'twentytwentytwo' ),
							'param_name' => 'slide_image',
						],
						[
							'type'       => 'textarea',
							'value'      => '',
							'heading'    => __( 'Title', 'twentytwentytwo' ),
							'param_name' => 'content_text_title',
						],
						[
							'type'       => 'textarea',
							'value'      => '',
							'heading'    => __( 'Sub Title', 'twentytwentytwo' ),
							'param_name' => 'content_text_sub_title',
						],
					],
				],
				[
					'type'       => 'css_editor',
					'heading'    => esc_html__( 'Custom css', 'twentytwentytwo' ),
					'param_name' => 'css',
					'group'      => esc_html__( 'Design options', 'twentytwentytwo' ),
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
		$css_class = vc_shortcode_custom_css_class( $atts['css'] ?? '', ' ' );
		$slides    = vc_param_group_parse_atts( $atts['slides'] );

		if ( ! empty( $slides ) ) {
			?>
			<!-- Slider main container -->
			<div class="swiper <?php echo esc_attr( $css_class ?? '' ); ?>">
				<!-- Additional required wrapper -->
				<div class="swiper-wrapper">
					<!-- Slides -->
					<?php
					foreach ( $slides as $slide ) {
						$image = wp_get_attachment_image_url( $slide['slide_image'], 'full' );
						?>
						<div class="swiper-slide">
							<img
									src="<?php echo esc_url( $image ?? '' ); ?>"
									alt="<?php echo esc_attr( $slide['slide_image'] ?? '' ); ?>">
				            <div class="swiper-text">
                                <h2><?php echo wp_kses_post( $slide['content_text_title'] ); ?></h2>
                                <h3><?php echo wp_kses_post( $slide['content_text_sub_title'] ); ?></h3>
				            </div>
						</div>
					<?php } ?>
				</div>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
				<div class="swiper-pagination"></div>
			</div>
			<?php
		}

		return ob_get_clean();
	}
}
