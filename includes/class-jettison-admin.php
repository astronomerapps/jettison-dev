<?php

class Jettison_Admin {
  /**
	 * Register the stylesheets for the admin area.
	 *
	 * @since 0.0.1
	 */
	public function enqueue_styles() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( JETTISON_NAME, JETTISON_ASSET_ROOT . 'dist/jettison-admin-styles.css', array(), JETTISON_VERSION, 'all' );
  }

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since 0.0.1
	 */
	public function enqueue_scripts() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( JETTISON_NAME, JETTISON_ASSET_ROOT . 'dist/jettison-admin-scripts.js', array(), JETTISON_VERSION, false );
	}

	public function menu() {
		global $jettison;
		$jettison->logger->debug( 'Testing' );
		add_menu_page('Dashboard', 'Jettison', 'manage_options', JETTISON_NAME, array( 'Jettison_Views', 'show' ), JETTISON_ASSET_ROOT . 'images/menu-icon.png', 2 );
		add_submenu_page( JETTISON_NAME, 'Settings', 'Settings', 'manage_options', JETTISON_NAME . '-settings', array( 'Jettison_Views', 'show' ) );
	}
}