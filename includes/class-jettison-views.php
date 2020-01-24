<?php

class Jettison_Views {
  /**
   * Shows the appropriate view based on the page query parameter set by WordPress
   *
   * @since 0.0.1
   */
  public static function show() {
    if ( isset( $_GET['page'] ) && file_exists( JETTISON_ROOT . 'views/view-' . $_GET['page'] . '.php' ) ) {
      require JETTISON_ROOT . 'views/view-' . $_GET['page'] . '.php';
    } else {
      require JETTISON_ROOT . 'views/view-jettison-404.php';
    }
  }
}