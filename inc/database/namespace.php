<?php
namespace PWCC\RapidCronQueries\Database;

use const PWCC\RapidCronQueries\TABLE_PREFIX;
use const PWCC\RapidCronQueries\DB_VERSION;

/**
 * Boostrap Database functionality
 */
function bootstrap() {

}

function get_db_prefix() {
	global $wpdb;
	return $wpdb->base_prefix . TABLE_PREFIX;
}

function get_schema() {
	global $wpdb;

	$charset_collate = $wpdb->get_charset_collate();
	$db_prefix = get_db_prefix();

	$events_scheme = "CREATE TABLE `{$db_prefix}events` (
		`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		`site_id` bigint(20) unsigned NOT NULL,

		`hook` varchar(255) NOT NULL,
		`key` char(32) NOT NULL,
		`args` longtext NOT NULL,

		`timestamp` datetime NOT NULL,
		`schedule` varchar(255) DEFAULT NULL,
		`interval` int unsigned DEFAULT NULL,
		`status` ENUM( 'waiting', 'running', 'complete' ) NOT NULL,

		PRIMARY KEY (`id`),
		KEY `hook_key_schedule` (`hook`, `key`, `schedule`),
		KEY `status` (`status`)
	) $charset_collate;\n";

	return $events_scheme;
}
