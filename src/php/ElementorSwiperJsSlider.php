<?php
/**
 * Elementor swiper class.
 *
 * @package iwpdev/test-theme
 */

namespace TestTheme;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

/**
 * ElementorSwiperJsSlider class file.
 */
class ElementorSwiperJsSlider extends Widget_Base {
	/**
	 * Get Name Widget.
	 *
	 * @inheritDoc
	 */
	public function get_name() {
		return __( 'Swiper slider', 'twentytwentytwo' );
	}

	/**
	 * Get Title.
	 *
	 * @return string|void
	 */
	public function get_title() {
		return __( 'Swiper slider', 'twentytwentytwo' );
	}

	/**
	 * Get Icon Widget.
	 *
	 * @return string
	 */
	public function get_icon(): string {
		return 'eicon-hotspot';
	}

	/**
	 * Category Widget.
	 *
	 * @return string[]
	 */
	public function get_categories(): array {
		return [ 'basic' ];
	}

	/**
	 * Register controls.
	 */
	protected function register_controls(): void {
		$repeater = new Repeater();

		$this->start_controls_section(
			'content_app_slider',
			[
				'label' => __( 'Slider', 'twentytwentytwo' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);


		$repeater->add_control(
			'image',
			[
				'label'   => esc_html__( 'Add Images', 'twentytwentytwo' ),
				'type'    => Controls_Manager::GALLERY,
				'default' => [],
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'       => __( 'Title', 'twentytwentytwo' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => __( 'Set a title', 'twentytwentytwo' ),
			]
		);

		$repeater->add_control(
			'sub_title',
			[
				'label'       => __( 'Sub Title', 'twentytwentytwo' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => __( 'Set a sub title', 'twentytwentytwo' ),
			]
		);

		$this->add_control(
			'app_slider',
			[
				'label'   => __( 'Navigation element', 'twentytwentytwo' ),
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $repeater->get_controls(),
				'default' => [],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Output html render.
	 */
	protected function render(): void {

		$sliders = (object) $this->get_settings_for_display();
		?>
		<!-- Slider main container -->
		<div class="swiper <?php echo esc_attr( $css_class ?? '' ); ?>">
			<!-- Additional required wrapper -->
			<div class="swiper-wrapper">
				<!-- Slides -->
				<?php
				foreach ( $sliders->app_slider as $slide ) {
					$image = wp_get_attachment_image_url( $slide['image'][0]['id'], 'full' );
					?>
					<div class="swiper-slide" >
						<img
								src="<?php echo esc_url( $image ?? '' ); ?>"
								alt="<?php echo esc_attr( $slide['image'][0]['id'] ?? '' ); ?>">
                        <div class="swiper-text">
                            <h2><?php echo wp_kses_post( $slide['title'] ); ?></h2>
                            <h3>
                                <?php echo wp_kses_post( $slide['sub_title'] ); ?></h3>
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

}
