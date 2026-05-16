<?php
/**
 * Plugin Name: Dynamic Publisher Suite
 * Description: Modular Gutenberg block platform for modern publishers with dynamic rendering and scalable architecture.
 * Version: 1.0.0
 * Requires at least: 6.5
 * Requires PHP: 8.0
 * Author: Dynamic Publisher Team
 * Text Domain: dynamic-publisher-suite
 * Domain Path: /languages
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
	exit;
}

define('DPS_VERSION', '1.0.0');
define('DPS_FILE', __FILE__);
define('DPS_DIR', plugin_dir_path(__FILE__));
define('DPS_URL', plugin_dir_url(__FILE__));
define('DPS_BASENAME', plugin_basename(__FILE__));

require_once DPS_DIR . 'includes/Core/Autoloader.php';

DynamicPublisherSuite\Core\Autoloader::init();

add_action('plugins_loaded', static function () {
	$plugin = new DynamicPublisherSuite\Core\Plugin();
	$plugin->boot();
});
