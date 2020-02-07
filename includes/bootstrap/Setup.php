<?php

namespace Jettison\Bootstrap;

use Jettison\Globals;

defined( 'ABSPATH' ) or die;

class Setup implements SetupInterface {
  /**
   * Exeqcutes all setup needed to instantiate the plugin with WordPress
   *
   * @since 0.0.1
   * @return void
   */
  public static function all(): void {
    self::admin();
    self::public();
    self::browserSync();
  }

  /**
   * Setups the plugin for the WordPress Admin.
   * - Enqueues scripts & styles
   * - Sets up WordPress sidebar menu
   *
   * @since 0.0.1
   * @return void
   */
  public static function admin(): void {
    \add_action( 'admin_enqueue_scripts', ['Jettison\Bootstrap\Setup', 'enqueue_admin_assets'], 10, 0 );
    \add_action( 'admin_menu', ['Jettison\Bootstrap\Setup', 'admin_menu'], 10, 0 );
  }

  public static function public(): void {

  }

  /**
   * enqueue_admin_assets
   * Called via the admin_enqueue_scripts action in WordPress
   * Will load all assets necessary for the WordPress Admin
   *
   * @access public
   * @since 0.0.1
   * @return void
   */
  public static function enqueue_admin_assets(): void {
    self::enqueue_assets( ['jettison-admin-scripts.js', 'jettison-admin-styles.css'] );
  }

  /**
   * enqueue_public_assets
   * Called via the
   *
   * @return void
   */
  public static function enqueue_public_assets(): void {

  }

  /**
   * admin_menu
   * Is called from the admin_menu WordPress action and instantiates the Plugin admin entry in the
   * WordPress admin
   *
   * @access public
   * @since 0.0.1
   * @return void
   */
  public static function admin_menu(): void {
    \add_menu_page( ucfirst(Globals\PLUGIN_NAME), ucfirst(Globals\PLUGIN_NAME), 'manage_options', Globals\PLUGIN_NAME, false, Globals\ASSET_ROOT_PATH . 'images/menu-icon.png', 2 );
    \add_submenu_page( Globals\PLUGIN_NAME, __( 'Dashboard' ), __( 'Dashboard' ), 'manage_options', Globals\PLUGIN_NAME, ['Jettison\ViewLoader', 'render'] );
    \add_submenu_page( Globals\PLUGIN_NAME, __( 'Profile' ), __( 'Profile' ), 'manage_options', Globals\PLUGIN_NAME . '-profile', ['Jettison\ViewLoader', 'render'] );
    \add_submenu_page( Globals\PLUGIN_NAME, __( 'Settings' ), __( 'Settings' ), 'manage_options', Globals\PLUGIN_NAME . '-settings', ['Jettison\ViewLoader', 'render'] );
  }

  /**
   * enqueue_assets
   * Enqueues assets via the WordPress hooks. The version is set to the last modified time to allow
   * for cache busting of the built assets. It will also load i18n for any js file
   *
   * @param  array $files - Array of file path strings
   *
   * @access private
   * @since 0.0.1
   * @return void
   */
  private static function enqueue_assets( array $files ): void {
    for ( $i = 0; $i < sizeof( $files ) - 1; $i++ ) {
      $handle = explode( '.', $files[$i] );
      $extension = $handle[sizeof( $handle ) - 1];
      $handle = $handle[0];

      if ( $extension === 'js' ) {
        \wp_enqueue_script(
          $handle,
          Globals\ASSET_ROOT_PATH . 'dist/' . $files[$i],
          // Ensure wp-i18n has loaded first
          ['wp-i18n'],
          // We need to use the server url vs relative path for filemtime to work properly
          filemtime( Globals\ROOT_PATH . 'assets/dist/' . $files[$i] ),
          // Place script in footer since we don't want it to slow page load
          true
        );
        // Register i18n JS handler
        \Jettison\I18n::initJS( $handle );
      } else if ( $extension === 'css' ) {
        \wp_enqueue_style(
          $handle,
          Globals\ASSET_ROOT_PATH . 'dist/' . $files[$i],
          [],
          // We need to use the server url vs relative path for filemtime to work properly
          filemtime(Globals\ROOT_PATH . 'assets/dist/' . $files[$i] )
        );
      }
    }
  }

  /**
   * Setups browsersync if JETTISON_DEV_MOVE is defined globally
   * Note: We set this in Docker (docker-compose.yml) for local development only this should never be used elsewhere
   *
   * @access private
   * @since 0.0.1
   * @return void
   */
  private static function browserSync(): void {
    if ( defined( 'JETTISON_DEV_MODE' ) && \JETTISON_DEV_MODE ) {
      \add_action( 'wp_footer', function() { echo Globals\BROWSERSYNC_CODE; }, 10, 0 );
      \add_action( 'admin_footer', function() { echo Globals\BROWSERSYNC_CODE; }, 10, 0 );
    }
  }
}