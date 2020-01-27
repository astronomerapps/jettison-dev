<?php

namespace Jettison\Clients;
use Jettison\Helpers\Strings;

/**
 * A simple HTTP client for executing requests via cURL
 *
 * @package Jettison
 * @subpackage Clients
 * @since 0.0.1
 * @uses Jettison\Helpers\Strings
 * @link https://github.com/AstronomerApps/jettison/tree/master/includes/clients/class-jettison-http.php Source
 */
class Http {
  public const POST = "POST";
  public const GET = "GET";
  public const DELETE = "DELETE";

  public $base_url;
  public $headers;

  public function __construct( $base_url, $headers = [] ) {
    $this->base_url = $base_url;
    $this->headers = $headers;
  }
  /**
   * Performs a GET request to the passed in endpoint via cURL.
   * If query params are passed it encodes them and appends them to the endpoint.
   * If additional headers are passed it will append them to the headers defined on construct
   *
   * @since 0.0.1
   * @uses Jettison\Helpers\Strings::format_url
   * @uses Jettison\Helpers\Strings::format_http_query
   * @uses Jettison\Clients\Http::execute
   * @param string $endpoint - The relative path to the endpoint
   * @param array $query_params - An array of key, values to be passed as a query alongside the endpoint
   * @param array $additional_headers - An array of key(Header name), values(Header value), to be passed with this specific request
   */
  public function get( $endpoint, $query_params = [], $additional_headers = [] ) {
    error_log('Execute');
    error_log($this->base_url . Strings::format_url($endpoint) . Strings::format_http_query($query_params));
    return $this->execute(
      self::GET,
      ($this->base_url . Strings::format_url( $endpoint ) . Strings::format_http_query( $query_params )),
      [],
      $additional_headers
    );
  }

  /**
   * execute
   *
   * @param  string $http_method
   * @param  string $url
   * @param  mixed $payload
   * @param  array $additional_headers
   *
   * @return r
   */
  private function execute( $http_method, $url, $payload = [], $additional_headers = [] ) {
    $ch = @curl_init();
    @curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, $http_method );
    @curl_setopt( $ch, CURLOPT_URL, $url );
    @curl_setopt( $ch, CURLOPT_HTTPHEADER, array_merge(
      $this->headers,
      $additional_headers
    ) );
    @curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    if ( $http_method == self::POST ) {
      curl_setopt( $ch, CURLOPT_POST, true );
      curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $payload ) );
    }
    $response = @curl_exec( $ch ); //Log the response from HubSpot as needed.
    $status_code = @curl_getinfo( $ch, CURLINFO_HTTP_CODE ); //Log the response status code
    @curl_close( $ch );

    return json_decode($response);
  }
}