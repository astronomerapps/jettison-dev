<?php

namespace Jettison;

defined( 'ABSPATH' ) or die;

class ViewLoader {
  /**
   * render
   * Attempts to load a file from the views/ folder that matches the current page attribute that is defined in Jettison\Bootstrap\Setup::admin
   * If the view doesn't exist it will render the NotFound.php view
   * The view slug is defined in the page query param as jettison-{view}
   *
   * @since 0.0.1
   * @access public
   * @return void
   */
  public static function render(): void {
    if ( ! isset( $_GET['page'] ) ) {
      return;
    }

    $file_path = Globals\ROOT_PATH . 'views/' . self::get_potential_view() . '.php';

    if ( file_exists( $file_path ) ) {
      require $file_path;
    } else {
      require Globals\ROOT_PATH . 'views/NotFound.php';
    }
  }

  /**
   * get_potential_view
   * Removes jettison- from the beginning of the page name
   * Uppercases every element in array and combines them to make the views become camel case
   *
   * Ex: Admin slug = jettison-my-settings, Returns MySettings
   *
   * @access private
   * @since 0.0.1
   * @return string
   */
  private static function get_potential_view(): string {
    $breakdown = explode( '-', $_GET['page'] );

    // If we are on the root page load the dashboard view
    if ( sizeof( $breakdown ) === 1 and $breakdown[0] === 'jettison' ) {
      return 'Dashboard';
    }

    array_shift( $breakdown );
    return implode( '', array_map( 'ucfirst', $breakdown ) );
  }
}