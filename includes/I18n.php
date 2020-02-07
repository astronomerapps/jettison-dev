<?php

namespace Jettison;

use Jettison\Globals;

defined( 'ABSPATH' ) or die;

class I18n {
  public static function init(): void {
    \load_plugin_textdomain( Globals\PLUGIN_NAME );
  }

  public static function initJS( string $file_handle ): void {
    \wp_set_script_translations( $file_handle, Globals\PLUGIN_NAME );
  }
}