<?php

namespace Chrysalis\T3;

defined( 'ABSPATH' ) || exit;

/**
 * This class is responsible for handling customizer settings.
 */
class Customizer {
	/**
	 * Initializes the class.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  void
	 */
	public function initialize(): void {
		// Late action so we can remove menus.
		add_action( 'customize_register', array( $this, 'customizer_sections' ), 999 );
		add_action( 'customize_register', array( $this, 'customizer_options' ) );
	}

	/**
	 * Customizer sections.
	 *
	 * @param [type] $wp_customize
	 * @return void
	 */
	public function customizer_sections( $wp_customize ) {
		// Remove the Menus section
		$wp_customize->remove_panel( 'nav_menus' );

		// Remove the Homepage Settings section
		$wp_customize->remove_section( 'static_front_page' );

		// Add Theme HTML section.
		$wp_customize->add_section(
			'tumblr3_html',
			array(
				'title'    => __( 'Tumblr Theme HTML', 'tumblr3' ),
				'priority' => 30,
			)
		);
	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $wp_customize
	 * @return void
	 */
	public function customizer_options( $wp_customize ) {
		/**
		 * @todo lack of sanitization is a security risk.
		 */
		$wp_customize->add_setting(
			'tumblr3_theme_html',
			array(
				'type'              => 'option',
				'capability'        => 'edit_theme_options',
				'default'           => '',
				'sanitize_callback' => '',
			)
		);

		$wp_customize->add_control(
			'tumblr3_theme_html',
			array(
				'label'    => __( 'HTML', 'tumblr3' ),
				'section'  => 'tumblr3_html',
				'type'     => 'textarea',
				'priority' => 10,
			)
		);
	}
}
