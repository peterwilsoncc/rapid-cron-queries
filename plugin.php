<?php
/**
 * Plugin Name: WP-Cron with Cavlacade
 * Plugin URI: https://peterwilson.cc/projects/wp-cron-cavalcade/
 * Description: Use Cavalcade to improve WP-Cron's storage without the need for the runner.
 * Author: peterwilsoncc, Human Made
 * Author URI: https://peterwilson.cc/
 * Version: 2.0.0
 * License: GPLv2 or later
 */

namespace PWCC\WP_Cron_Cavalcade;

const PLUGIN_DIR = __DIR__;

require_once __DIR__ . '/inc/namespace.php';

// Ensure this plugin boostraps prior to Cavalcade so the files are required if needs be.
add_action( 'plugins_loaded', __NAMESPACE__ . '\\bootstrap', 9 );

// Register cache groups as early as possible, as some plugins may use cron functions before plugins_loaded
if (
	function_exists( 'wp_cache_add_global_groups' ) &&
	function_exists( '\\HM\\Cavalcade\\Plugin\\register_cache_groups' )
) {
	\HM\Cavalcade\Plugin\register_cache_groups();
}
