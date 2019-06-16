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

if ( ! defined( 'PWCC_CRON_CAVALCADE_COMPAT' ) ) {
	define( 'PWCC_CRON_CAVALCADE_COMPAT', false );
}

const DB_VERSION = 3;
const CACHE_GROUP = 'rapid-cron';

require __DIR__ . '/inc/namespace.php';

bootstrap();
