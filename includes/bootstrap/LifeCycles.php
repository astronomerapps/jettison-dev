<?php

namespace Jettison\Bootstrap;

use Jettison\Logger;

defined('ABSPATH') or die;

class LifeCycles implements LifeCyclesInterface {
  /**
   * Registers all of the LifeCycle hooks with WordPress
   *
   * @since 0.0.1
   * @return void
   */
  public static function init(): void {
    \register_shutdown_function( ['Jettison\Bootstrap\LifeCycles', 'shutdown'] );
    \register_uninstall_hook( __FILE__, 'uninstalled' );
    \register_deactivation_hook( __FILE__, 'deactivated' );
    \register_activation_hook( __FILE__, 'activated' );
    \add_action( 'plugins_loaded', ['Jettison\Bootstrap\LifeCycles', 'loaded'], 10, 0 );
  }

  /**
   * Runs on every page load
   * See: https://codex.wordpress.org/Plugin_API/Action_Reference/plugins_loaded
   *
   * @since 0.0.1
   * @return void
   */
  public static function loaded(): void {
    Logger::say( "Jettison Loaded" );
    Setup::all();
  }

  /**
   * Runs right before PHP execution is about to end
   * See: https://codex.wordpress.org/Plugin_API/Action_Reference/shutdown
   *
   * @return void
   */
  public static function shutdown(): void {
    Logger::say("Jettison Shutting Down");
  }

  /**
   * uninstalled
   * See: https://developer.wordpress.org/reference/functions/register_uninstall_hook/
   *
   * @since 0.0.1
   * @return void
   */
  public static function uninstalled(): void {
    Logger::say("Jettison Uninstalled");
  }

  /**
   * activated
   * See: https://developer.wordpress.org/reference/functions/register_activation_hook/
   *
   * @since 0.0.1
   * @return void
   */
  public static function activated(): void {
    Logger::say("Jettison Activated");
  }

  /**
   * deactivated
   * See: https://developer.wordpress.org/reference/functions/register_deactivation_hook/
   *
   * @since 0.0.1
   * @return void
   */
  public static function deactivated(): void {
    Logger::say("Jettison Deactivated");
  }
}
