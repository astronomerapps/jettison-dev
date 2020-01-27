<?php
/**
 * Code that is run during the activation of the plugin
 *
 * @since 0.0.1
 * @package Jettison
 * @subpackage Jettison/includes/bootstrap
 */
class Jettison_Activator {
  public static function activate() {
    Jettison_Notices::show( 'please_login' );
  }
}