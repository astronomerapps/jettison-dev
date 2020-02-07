<?php

namespace Jettison\Globals;

defined( 'ABSPATH' ) or die;

/**
 * The name of the plugin used as a text-domain required by various WordPress functions
 *
 * @since 0.0.1
 * @var string JETTISON_NAME
 */
const PLUGIN_NAME = 'jettison';

/**
 * Used through plugin for resolving paths
 * Note: We use define as we need to run this at run time to determine plugin directory
 * Since users could have their plugins in a unique folder
 *
 * @since 0.0.1
 * @var string The root of the jettison plugin directory
 */
define( 'Jettison\Globals\ROOT_PATH', \plugin_dir_path(__DIR__) );

/**
 * The relative path used for loading assets
 *
 * @since 0.0.1
 * @var string The asset root for the jettison plugin
 */
const ASSET_ROOT_PATH = '/wp-content/plugins/' . PLUGIN_NAME . '/assets/';

/**
 * Current Plugin Version
 * Uses SemVer - https://semver.org
 *
 * Note: This is automatically updated on a release
 * @since 0.0.1
 */
const VERSION = "0.0.1";

/**
 * The current api version defined in package.json
 *
 * @since 0.0.1
 * @access public
 * @var string The current api version used for the REST Routes Prefix
 */
const API_VERSION = "v1";

/**
 * The code that should be injected in the body of a page to instantiate browsersync
 *
 * @since 0.0.1
 * @access public
 * @var string
 */
const BROWSERSYNC_CODE = '<!-- Jettison BrowserSync: Begin -->
  <script id="__bs_script__">//<![CDATA[
    document.write("<script async src=\'http://HOST:3000/browser-sync/browser-sync-client.js?v=2.26.7\'><\/script>".replace("HOST", location.hostname));
  //]]</script>
<!-- Jettison BrowserSync: End -->';
