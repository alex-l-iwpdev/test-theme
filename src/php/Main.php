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
	}
}
