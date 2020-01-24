<?php

namespace Jettison;

class Hooks {

  public static function hook_output() {
    global $jettison;
    $jettison->logger->info( current_filter(), func_get_args() );

    // If we return null it will short circuit the user on this hook
    // We have to return the current user Id
    // https://developer.wordpress.org/reference/hooks/determine_current_user/
    if ( current_filter() == 'determine_current_user' ) {
      return func_get_arg(0);
    }
  }

  private function setup_csv_hooks( $loader, $path ) {
    $row = 1;
    if (($handle = fopen($path, "r")) !== FALSE) {
      while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if ($row > 1) {
          $loader->add_action($data[0], $this, 'hook_output', 10, 10);
        }
        $row++;
      }
      fclose($handle);
    }
  }

  public function setup( $loader, $debug = false )
  {
    $root = JETTISON_ROOT . 'includes/hooks/test';
    $files = Helpers\Files::get( $root );
    for ($i=2; $i < count($files); $i++) {
      $this->setup_csv_hooks( $loader, $root . '/' . $files[$i] );
    }
  }
}