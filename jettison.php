<?php
/**
 * Plugin Name: Jettison
 * Plugin URI: https://sync.astronomer.app
 * Description: WordPress Development Made Easy
 * Version: 0.0.1
 * Author: Astronomer Apps
 * Author URI: https://astronomerapps.com
 * License: GPL-2.0+
 * Text Domain: jettison
 * Domain Path: /languages
 *
 * ------------------------------------------------------------------------
 * Copyright 2019-2019 Astronomer Apps LLC.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 */

namespace Jettison;

defined( 'ABSPATH' ) or die;

// Setup Globals
include_once \plugin_dir_path(__FILE__) . 'includes/Globals.php';
// Load AutoLoader
include_once Globals\ROOT_PATH . 'includes/AutoLoader.php';
AutoLoader::register();
// Register WordPress LifeCycle hooks
Bootstrap\LifeCycles::init();