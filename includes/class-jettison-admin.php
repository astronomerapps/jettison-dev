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
		add_menu_page('Jettison', 'Jettison', 'manage_options', JETTISON_NAME, array( $this, 'home'), JETTISON_ASSET_ROOT . 'images/menu-icon.png');
		add_options_page( 'Settings', 'Jettison', 'manage_options', JETTISON_NAME, array( $this, 'settings_page'));
	}

	public function home() {
		echo '<h5>Hey</h5>';
	}

	public function settings_page() {
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		echo 'We did it champ.';
	}
}