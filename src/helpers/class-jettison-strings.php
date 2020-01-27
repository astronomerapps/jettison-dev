<?php
namespace Jettison\Helpers;

abstract class Strings {
  /**
   * format_url
   * Removes the trailing slash from a url and adds a leading slash if it is not a quantified url
   *
   * @param  string $url
   * @access public
   * @static
   * @return string
   */
  public static function format_url($url)
  {

    error_log('format_url - ' . $url);
    if (( strlen($url) > 4 && substr($url, 0, 4) != "http") && substr($url, 0, 1) != "/") {
      error_log('Add slash');
      $url = "/" . $url;
    }
    error_log('end - ' . $url);
    return $url;
  }


  /**
   * format_http_query
   *
   * Formats the passed in query array by key value and will return a blank string if the array is empty
   *
   * @param  array $query - An array of query elements
   *
   * @return string
   */
  public static function format_http_query( $query ) {
    if ( sizeof($query) == 0 ) {
      return "";
    }

    $keys = array_keys($query);
    error_log(print_r($query, true));
    error_log(print_r($keys, true));
    $size = sizeof($query);
    $string = "?";
    for ($i=$size; $i >= 0; $i--) {
      $string += ($i == $size ? "" : "&") . $keys[$i] . "=" . $query[$i];
    }
    return $string;
  }
}