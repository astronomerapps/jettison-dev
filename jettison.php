<?php
/**
 * Plugin Name: Jettison
 * Plugin URI: https://sync.astronomer.app
 * Description: WordPress Development Made Easy
 * Version: 0.0.1
 * Author: Astronomer Apps
 * Author URI: https://astronomer.app
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

 // If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Current Plugin Version
 * Uses SemVer - https://semver.org
 *
 * Note: This is automatically updated on a release
 * @since 0.0.1
 * @var string JETTISON_VERISON
 */
define( 'JETTISON_VERSION', '0.0.1' );

/**
 * The name of the plugin used as a text-domain required by various WordPress functions
 *
 * @since 0.0.1
 * @var string JETTISON_NAME
 */
define( 'JETTISON_NAME', 'jettison' );

/**
 * Used through plugin for resolving paths
 *
 * @since 0.0.1
 * @var string The root of the jettison plugin directory
 */
define( 'JETTISON_ROOT', plugin_dir_path( __FILE__ ));

/**
 * The relative path used for loading assets
 *
 * @since 0.0.1
 * @var string The asset root for the jettison plugin
 */
define( 'JETTISON_ASSET_ROOT', '/wp-content/plugins/' . JETTISON_NAME . '/assets/');


/**
 * Pull in package.json for universal version numbers
 *
 * @since 0.0.1
 */
$package = json_decode(file_get_contents(JETTISON_ROOT. 'package.json'), true);

/**
 * The current version defined in package.json
 *
 * @since 0.0.1
 * @access public
 * @var String $version The current version number
 */
define( 'JETTISON_VERSION', $package['version'] );

/**
 * The current api version defined in package.json
 *
 * @since 0.0.1
 * @access public
 * @var String $api_version The current api version used for the REST Routes Prefix
 */
define( 'JETTISON_API_VERSION', $package['apiVersion'] );

/**
 * The code that will run when a user activates the plugin
 * See /includes/bootstrap/class-jettison-activator.php for more info
 *
 * @since 0.0.1
 */
function activate_jettison() {
  require_once JETTISON_ROOT . 'includes/bootstrap/class-jettison-activator.php';
  Jettison_Activator::activate();
}

/**
 * The code that will run when a user deactivates the plugin
 * See /includes/bootstrap/class-jettison-activator.php for more info
 *
 * @since 0.0.1
 */
function deactivate_jettison() {
  require_once JETTISON_ROOT . 'includes/bootstrap/class-jettison-deactivator.php';
  Jettison_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_jettison' );
register_deactivation_hook( __FILE__, 'deactivate_jettison' );

/**
 * The core that will activate all admin and public hooks and define i18n
 * See /includes/class-jettison.php for more info
 *
 * @since 0.0.1
 */
require JETTISON_ROOT . 'includes/class-jettison.php';
$jettison = new Jettison();
$jettison->run();