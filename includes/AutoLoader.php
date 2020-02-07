<?php

namespace Jettison;

use Jettison\Globals;

class AutoLoader {
  /**
   * Registers the autoloader
   *
   * See: https://www.php.net/manual/en/function.spl-autoload-register.php
   *
   * @return void
   */
  public static function register() {
    spl_autoload_register( [ 'Jettison\Autoloader', 'run' ] );
  }

  /**
   * Unregisters the autoloader
   *
   * See: https://www.php.net/manual/en/function.spl-autoload-unregister.php
   *
   * @return void
   */
  public static function unregister() {
    spl_autoload_unregister( [ 'Jettison\Autoloader', 'run' ] );
  }

  /**
   * AutoLoader that will hook into PHPs __autoload function and load the appropriate
   * class or interface.
   *
   * See: https://www.php.net/manual/en/language.oop5.autoload.php
   *
   * @param  string $class_name
   *
   * @return void
   */
  public static function run( string $class_name ) {
    $lowercase_class_name = strtolower( $class_name );

    if ( strpos( $lowercase_class_name, Globals\PLUGIN_NAME ) !== False ) {
      $class = explode( '\\', $lowercase_class_name );
      $file_name = $class[sizeof( $class ) - 1];
      $relative_path = $class[1] === 'Views' ? 'views/' : 'includes/';

      // If we are not root Jettison namespace we need to add folders
      if ( sizeof( $class ) !== 2 ) {
        // We can ignore the first element and last element
        // As those are the root namespace and class name
        for ( $i = 1; $i < sizeof( $class ) - 1; $i++) {
          $relative_path = "$relative_path$class[$i]/";
        }
      }

      // If file is an interface load from the interface folder
      if ( strpos( $file_name, 'interface' ) !== False ) {
        $relative_path = $relative_path . 'interfaces/';
      }

      $file_path = Globals\ROOT_PATH . $relative_path . $file_name . '.php';

      if ( file_exists( $file_path ) ) {
        include_once $file_path;
      } else {
        error_log($file_path);
        throw new \Error( $class_name . ' was called but the file does not exist at ' . $file_path );
      }
    }
  }
}