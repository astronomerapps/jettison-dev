<?php

class Jettison_Loader {
  /**
   * An array of WordPress Actions that will be register on run
   * See https://developer.wordpress.org/plugins/hooks/actions/ for list of Actions
   *
   * @since 0.0.1
   * @access protected
   * @var array $action An array of strings that represent WordPress actions
   */
  protected $actions;

  /**
   * An array of WordPress Filters that will be register on run
   * See https://developer.wordpress.org/plugins/hooks/filter/ for list of Filters
   *
   * @since 0.0.1
   * @access protected
   * @var array $filter An array of strings that represent WordPress filters
   */
  protected $filters;

  public function __construct() {
    $this->actions = [];
    $this->filters = [];
  }

  /**
   * Registers all of the current actions and filters into WordPress
   *
   * @since 0.0.1
   */
  public function run() {
    foreach ($this->actions as $key => $action) {
      add_action( ...$action );
    }

    foreach ($this->filters as $key => $filter) {
      add_filter( ...$filter );
    }
  }

  /**
   * Prepares a action to be added into the run
   * See https://developer.wordpress.org/reference/functions/add_action/ for more info
   *
   * @since 0.0.1
   */
  public function add_action( $action_name, $class, $callback, $priority = 10, $accepted_args = 1 ) {
    array_push( $this->actions, [
      $action_name,
      [ $class, $callback ],
      $priority,
      $accepted_args
    ]);
  }

  /**
   * Prepares a filter to be added into the run
   * See https://developer.wordpress.org/reference/functions/add_filter/ for more info
   *
   * @since 0.0.1
   */
  public function add_filter( $filter_name, $class, $callback, $priority = 10, $accepted_args = 1 ) {
    array_push( $this->filters, [
      $filter_name,
      [ $class, $callback ],
      $priority,
      $accepted_args
    ]);
  }
}