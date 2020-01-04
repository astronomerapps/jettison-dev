<?php
/**
 * Code that is run during the activation of the plugin
 *
 * @since 0.0.1
 * @package Jettison
 * @subpackage Jettison/includes/bootstrap
 */
class Jettison_Activator {
  /**
   * Adds the menu items to the WordPress Admin
   *
   * @since 0.0.1
   */
  private static function setup_admin_menus() {
    add_menu_page('Jettison', 'Jettison', '', JETTISON_NAME . '-settings', null, JETTISON_ROOT . 'asssets/images/icon.svg');
  }

  public static function activate() {
    self::setup_admin_menus();
  }
}