<?php

class Jettison {
  /**
   * Handles and mantains all of the WordPress hooks
   *
   * @since 0.0.1
   * @access protected
   * @var Jettison_Loader $loader Maintains and registers all WordPress hooks
   */
  protected $loader;

  /**
   * Instantiates everything required to run the plugin
   *
   * @since 0.0.1
   */
  public function __construct() {
    $this->load_dependencies();
    $this->set_locale();
    $this->define_admin_hooks();
    $this->define_public_hooks();
  }

  /**
   * Will load all of the dependencies required
   *
   * Required Dependencies
   * - Jettison_Loader - Responsible for hooking into WordPress
   * - Jettison_i18n - Handles internationalization
   * - Jettison_Auth - Handles authentication with Astronomer
   *
   * @since 0.0.1
   * @access private
   */
  private function load_dependencies() {
    require_once JETTISON_ROOT . 'includes/bootstrap/class-jettison-loader.php';
    require_once JETTISON_ROOT . 'includes/class-jettison-admin.php';
    require_once JETTISON_ROOT . 'includes/class-jettison-i18n.php';
    require_once JETTISON_ROOT . 'includes/class-jettison-notices.php';

    $this->loader = new Jettison_Loader();
  }

  /**
   * Defines all of the admin specific WordPress hooks
   *
   * @since 0.0.1
   * @access private
   */
  private function define_admin_hooks() {
    // Examples
    // Add Action
    // $this->loader->add_action( 'wordpress_action_name', $class_ref, 'function_name' )
    // Add Filter
    // $this->loader->add_filter( 'wordpress_filter_name', $class_ref, 'function_name' )

    $plugin_admin = new Jettison_Admin();

    $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
    $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
    $this->loader->add_action( 'admin_menu', $plugin_admin, 'menu' );
  }

  /**
   * Defines all of the public specific WordPress hooks
   *
   * @since 0.0.1
   * @access private
   */
  private function define_public_hooks() {
    // Examples
    // Add Action
    // $this->loader->add_action( 'wordpress_action_name', $class_ref, 'function_name' )
    // Add Filter
    // $this->loader->add_filter( 'wordpress_filter_name', $class_ref, 'function_name' )
  }

  /**
   * Sets up internationalization
   *
   * @since 0.0.1
   * @access private
   */
  private function set_locale() {
    $i18n = new Jettison_i18n();

    $this->loader->add_action( 'plugins_loaded', $i18n, 'load');
  }

  /**
   * Runs the loader and executes
   * See /includes/bootstrap/class-jettison-loader.php for more info
   *
   * @since 0.0.1
   */
  public function run() {
    $this->loader->run();
  }

  /**
   * Returns the reference to the loader class
   *
   * @since 0.0.1
   * @return Jettison_Loader The loader
   */
  public function get_loader() {
    return $this->loader;
  }
}