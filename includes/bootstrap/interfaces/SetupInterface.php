<?php

namespace Jettison\Bootstrap;

interface SetupInterface {
  public static function all(): void;
  public static function admin(): void;
  public static function public(): void;
  public static function enqueue_admin_assets(): void;
  public static function enqueue_public_assets(): void;
}