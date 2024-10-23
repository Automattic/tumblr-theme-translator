<?php

namespace CupcakeLabs\T3;

defined( 'ABSPATH' ) || exit;

class ThemeBrowser {
	const THEME_GARDEN_ENDPOINT = 'https://roccotrip.dca.tumblr.net/v2/theme_garden';
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
		add_action('admin_enqueue_scripts', [$this, 'enqueueAssets']);
	}

	public function enqueueAssets(): void {
		wp_enqueue_style( 'tumblr-theme-browser', TUMBLR3_URL . 'assets/css/build/admin.css', array(), '1.0' );
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
		$response = wp_remote_get(self::THEME_GARDEN_ENDPOINT);
		$body = json_decode( wp_remote_retrieve_body( $response ), true );
		$themes = $body['response']['themes'] ?? [];
		?>
		<div class="themes">
			<?php $this->renderThemeList($themes); ?>
		</div>
		<?php
	}

	public function renderThemeList($themes): void {
		if (empty($themes)) {
			return;
		}

		foreach ($themes as $theme) : ?>
			<article>
				<div class='tabs'>
					<div class='tab'><span><?php echo $theme['title'] ?></span></div>
				</div>
				<div class='body'>
					<img class="thumbnail" src="<?php echo $theme['thumbnail'] ?>" />
					<ul class="buttons">
						<li><a href="#">Preview</a></li>
						<li><a href="#">Activate</a></li>
					</ul>
				</div>
			</article>
		<?php endforeach;
	}
}