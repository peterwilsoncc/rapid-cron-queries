<?php
/**
 * Rapid Cron Queries
 *
 * @package     RapidCronQueries
 * @author      Peter Wilson
 * @copyright   2019 Peter Wilson
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Rapid Cron Queries
 * Plugin URI:  https://peterwilson.cc/projects/rapid-cron-queries
 * Description: Store cron events in a custom database table.
 * Version:     1.0.0
 * Author:      Peter Wilson
 * Author URI:  https://peterwilson.cc/
 * Text Domain: rapid-cron-queries
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

namespace PWCC\RapidCronQueries;

include_once __DIR__ . '/inc/namespace.php';
include_once __DIR__ . '/inc/connector/namespace.php';
include_once __DIR__ . '/inc/database/namespace.php';

fast_bootstrap();
add_action( 'plugin_loaded', __NAMESPACE__ . '\\bootstrap' );
