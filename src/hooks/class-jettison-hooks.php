<?php

namespace Jettison;
use Jettison\Clients\Http;

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
  private static function retrieve_sheets_from_google() {
    $client = new Http("https://script.googleusercontent.com/");
    $sheets = $client->get("/macros/echo", [
      "user_content_key" => "duKAmsdXvDhKKKLKo5k8qA1IPgOXi-dVlFuWhGZhuO56hY60PoR8rltswszBcWCDcZiYrfV7ICbC1EtRDBW8Gaq9sbeOEf9sm5_BxDlH2jW0nuo2oDemN9CCS2h10ox_1xSncGQajx_ryfhECjZEnG95-EVqWDg4yWcXHc4Dt-xXa5Lo1ruJHTD11qZVfFr7nzTbXhNxNkeZ_kcKr-1V1Q",
      "lib" => "M7skMFxSq5aks0x8hZ0h7_XXtad7F4Vk4"
    ]);
    return $sheets;
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
    $hooks = self::retrieve_sheets_from_google();
    error_log(print_r($hooks, true));
  }
}