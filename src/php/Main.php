<?php
/**
 * Main theme class.
 *
 * @package iwpdev/test-theme
 */

namespace TestTheme;

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
		new ElementorSwiperJsSlider();
		new WPBakerySwiperJsSlider();

		add_action( 'wp_enqueue_scripts', [ $this, 'add_style_and_scripts' ] );
	}

	/**
	 * Add style and script.
	 *
	 * @return void
	 */
	public function add_style_and_scripts(): void {
		wp_enqueue_style( 'test-theme-swiper', '//cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', '', '11.0.0' );
		wp_enqueue_style( 'test-theme-main', get_stylesheet_directory() . '/assets/css/main.css', [], '1.0.0' );

		wp_enqueue_script( 'test-theme-swiper', '//cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [ 'jquery' ], '11.0.0', true );
		wp_enqueue_script( 'test-theme-main', get_stylesheet_directory_uri() . '/assets/js/main.js', [ 'jquery' ], '1.0.0', true );

	}
}
