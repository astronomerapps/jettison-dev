<?php

namespace Jettison\Helpers;

defined( 'ABSPATH' ) or die;

interface Files {
  public static function get( string $directory_path, bool $recurse = true): array;
  public static function write( string $path_to_file, $data, string $mode = "a+" ): void;
}