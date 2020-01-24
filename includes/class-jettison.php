<?php

class Jettison {
  /**
   * Handles and mantains all of the WordPress hooks
   *
   * @since 0.0.1
   * @access protected
   * @var Jettison_Loader $loader Maintains and registers all WordPress hooks
   */
  public $loader;

  public $logger;

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
   * Returns the browser sync snippet.
   *
   * @since 0.0.1
   * @access private
   * @return string Browser Sync development snippet
   */
  public static function load_browsersync() {
    echo '<!-- Jettison BrowserSync: Begin -->
      <script id="__bs_script__">
        //<![CDATA[
          document.write("<script async src=\'http://HOST:3000/browser-sync/browser-sync-client.js?v=2.26.7\'><\/script>".replace("HOST", location.hostname));
        //]]>
      </script>
    <!-- Jettison BrowserSync: End -->';
  }

  /**
   * Will load all of the dependencies required
   *
   * Required Dependencies
   * - Jettison_Loader - Responsible for hooking into WordPress
   * - Jettison_i18n - Handles internationalization
   * - Jettison_Auth - Handles authentication with Astronomer
   * - Jettison_Socket - The WebSocket connector with the Frontend
   *
   * @since 0.0.1
   * @access private
   */
  private function load_dependencies() {
    require_once JETTISON_ROOT . 'includes/bootstrap/class-jettison-loader.php';
    require_once JETTISON_ROOT . 'includes/bootstrap/class-jettison-log.php';
    require_once JETTISON_ROOT . 'includes/helpers/class-jettison-files.php';
    require_once JETTISON_ROOT . 'includes/class-jettison-views.php';
    require_once JETTISON_ROOT . 'includes/class-jettison-admin.php';
    require_once JETTISON_ROOT . 'includes/class-jettison-i18n.php';
    require_once JETTISON_ROOT . 'includes/class-jettison-notices.php';

    $this->loader = new Jettison_Loader();
    $this->logger = new Jettison\Log();

    if (defined('JETTISON_DEV_MODE') && JETTISON_DEV_MODE) {
      require_once JETTISON_ROOT . 'includes/hooks/class-jettison-hooks.php';
      $hook_testing = new Jettison\Hooks();
      $hook_testing->setup( $this->loader );
    }
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
    // $this->loader->add_action( 'rest_api_init', $plugin_socket, 'register' );

    // Add BrowserSync for Plugin Development Only
    if ( defined( 'JETTISON_DEV_MODE' ) && JETTISON_DEV_MODE ) {
      $this->loader->add_action( 'admin_footer', 'Jettison', 'load_browsersync' );
    }
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

    // Add BrowserSync for Plugin Development Only
    if ( defined( 'JETTISON_DEV_MODE' ) && JETTISON_DEV_MODE ) {
      $this->loader->add_action( 'wp_footer', 'Jettison', 'load_browsersync' );
    }
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