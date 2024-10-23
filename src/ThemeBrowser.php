<?php

namespace CupcakeLabs\T3;

defined( 'ABSPATH' ) || exit;

class ThemeBrowser {
	/**
	 * Initializes the class.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  void
	 */
	public function initialize(): void {
		add_action('admin_menu', [$this, 'registerSubmenu']);
	}

	public function registerSubmenu()
	{
		add_submenu_page(
			'themes.php',
			__('Tumblr Themes', 'tumblr-theme-translator'),
			__('Tumblr Themes', 'tumblr-theme-translator'),
			'manage_options',
			'tumblr-theme',
			[$this, 'renderPage']
		);
	}

	public function renderPage(): void {
		?>
		<h1>Tumblr Themes</h1>
		<?php
	}


}
