<?php

namespace Jettison\Bootstrap;

defined( 'ABSPATH' ) or die;

interface LifeCyclesInterface {
  public static function init(): void;
  public static function loaded(): void;
  public static function uninstalled(): void;
  public static function activated(): void;
  public static function deactivated(): void;
}