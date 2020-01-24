<?php
/**
 * A collection of static methods for manipulating and retrieving files
 *
 * @since 0.0.1
 * @access public
 */
namespace Jettison\Helpers;
class Files {
  /**
   * Retrieves a list of files from the passed in path.
   * By default this will recursively go through all files
   *
   * @since 0.0.1
   * @access static
   * @return array - An array of paths to files
   */
  public static function get( $directory_path, $recurse=true ) {
    return array_diff( scandir( $directory_path ), array( '..', '.') );
  }

  public static function write( $path_to_file, $data, $mode = "a+" ) {
    $file = fopen( $path_to_file, $mode );
    fwrite( $file, $data );
    fclose( $file );
  }
}