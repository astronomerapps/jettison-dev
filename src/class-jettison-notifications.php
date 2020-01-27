<?php

class Jettison_Notifications {
  /**
   * The route we will attached to the REST API call that we will
   * use to communicate directly with the frontend
   *
   * @since 0.0.1
   * @access protected
   * @var string $route
   * @author jordanskomer
   */
  protected static $route = 'notifications';

  protected $notifications = [];

  private function get(WP_REST_Request $request) {
    return new Jettison_Response($notifications)->json();
  }

  private function send($message) {
    array_push( $notifications, $message );
  }

  public function register() {
    register_rest_route( 'jettison/' . JETTISON_API_VERSION, self::$route, array(
      'methods' => 'GET',
      'callback' => array( $this, 'get' )
    ) );
  }

}