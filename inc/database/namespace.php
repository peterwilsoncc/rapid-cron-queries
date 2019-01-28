<?php
namespace PWCC\RapidCronQueries\Database;

use const PWCC\RapidCronQueries\PREFIX;
use const PWCC\RapidCronQueries\DB_VERSION;

/**
 * Boostrap Database functionality
 *
 * Runs as WordPress bootstraps.
 */
function fast_bootstrap() {
	if ( get_db_version() < DB_VERSION ) {
		upgrade();
	}
}

/**
 * Get the database version.
 *
 * @return int Database version.
 */
function get_db_version() {
	$current_version = get_network_option( 1, PREFIX . 'db_version' );

	if ( ! $current_version ) {
		$current_version = 0;
	}

	return (int) $current_version;
}

/**
 * Get the Database table prefix.
 *
 * @return string DB Table prefix.
 */
function get_db_prefix() {
	global $wpdb;
	return $wpdb->base_prefix . PREFIX;
}

/**
 * Get the database schema.
 *
 * @return string Database schema.
 */
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

/**
 * Upgrade the Rapid Cron Queries database.
 *
 * First run adds the table schema, subsequent runs modify
 * the table schema as required.
 */
function upgrade() {
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta( get_schema() );

	update_network_option( 1, PREFIX . 'db_version', DB_VERSION );
}
