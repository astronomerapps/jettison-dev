<?php

namespace Jettison;

use DateTime;
use DateTimeZone;

defined( 'ABSPATH' ) or die;

class Logger {
  /**
   * Integer index to load the INFO string level from LOG_LEVELS
   *
   * @since 0.0.1
   * @var int INFO
   */
  public const INFO = 0;

  /**
   * Integer index to load the DEBUG string level from LOG_LEVELS
   *
   * @since 0.0.1
   * @var int DEBUG
   */
  public const DEBUG = 1;

  /**
   * Integer index to load the WARNING string level from LOG_LEVELS
   *
   * @since 0.0.1
   * @var int WARNING
   */
  public const WARNING = 2;

  /**
   * Integer index to load the ERROR string level from LOG_LEVELS
   *
   * @since 0.0.1
   * @var int ERROR
   */
  public const ERROR = 3;

  /**
   * The array of string that will represent the level that is outputted to the log
   *
   * @since 0.0.1
   * @var array LOG_LEVELS
   */
  private const LOG_LEVELS = [
    "INFO",
    "DEBUG",
    "WARNING",
    "ERROR",
  ];

  /**
   * Outputs to logger
   *
   * @param  string $message - The message to output
   * @param  int $level - The level of the Error (0-3)
   * @param  array $data - Optional array of data to send
   *
   * @since 0.0.1
   * @return void
   */
  public static function say( string $message, int $level = self::INFO, array $data = [] ): void {
    $message = '[ ' . self::LOG_LEVELS[ $level ] . self::formatMessage( $message, $data );
    error_log( $message );
  }

  /**
   * Returns a string that is formatted in the following ways dependant on if there is data or not
   * YYYY-MM-DD@HH-MM-SS ] $message
   * YYYY-MM-DD@HH-MM-SS ] $message
   * $data
   *
   * @param  string $message
   * @param  array $data
   *
   * @access private
   * @since 0.0.1
   * @return string
   */
  private static function formatMessage( string $message, array $data ): string {
    $now = new DateTime();
    $now->setTimezone( new DateTimeZone( 'UTC' ));
    $formattedMessage = $now->format( ' Y-m-d@H:i:s ] ' );

    if ( sizeof( $data ) === 0 ) {
      return "$formattedMessage $message";
    }

    return "$formattedMessage $message\n" . print_r( $data, true );
  }
}