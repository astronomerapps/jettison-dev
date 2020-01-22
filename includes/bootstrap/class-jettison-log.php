<?php

class Jettison_Log {
  private static $directory_name = 'logs';
  private static $log_name_prefix = 'log_';
  private $output_directory;
  private $output_file_name;
  private $output_file;

  private function enable_file_logging() {
    $this->output_directory = JETTISON_ROOT . '/' . self::$directory_name;
    if ( ! file_exists( $this->output_directory ) ) {
      mkdir( $this->output_directory );
    }
    $date = new DateTime();
    $this->output_file_name = self::$log_name_prefix . $date->format( 'Y-m-d' );
    $this->output_file = $this->output_directory . '/' . $this->output_file_name . '.csv';

    // Setup .csv Headers
    if ( ! file_exists( $this->output_file ) ) {
      self::setup_csv_header( $this->output_file );
    }
  }

  private function enable_remote_logging() {
    // @todo
  }

  private static function setup_csv_header( $file ) {
    Jettison_Files::write( $file, "type,timestamp,message,data\n" );
  }

  private static function create_message( $message, $type, $data = [] ) {
    $timestamp = new DateTime();
    return $type . ',' . $timestamp->format( 'Y-m-d 00:00:00' ) . ',' . $message . ',' . json_encode( $data ) . "\n";
  }

  private function log( $message, $type, $data = [] ) {
    Jettison_Files::write( $this->output_file, self::create_message( $message, $type, $data ) );
  }

  public function __construct( $write_to_file = true ) {
    if ( $write_to_file ) {
      $this->enable_file_logging();
    } else {
      $this->enable_remote_logging();
    }
  }

  public function debug( $message, $data=[] ) {
    $this->log( $message, 'DEBUG', $data );
  }

}