<?php
namespace PWCC\RapidCronQueries\Database;

use const PWCC\RapidCronQueries\DB_VERSION;
use const PWCC\RapidCronQueries\PREFIX;

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
	$current_version = get_site_option( PREFIX . 'db_version' );

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
	$db_prefix       = get_db_prefix();

	/*
	 * WARNING: Do not format nicely with empty lines between sections!
	 *
	 * dbDelta() does not cope well with two consecutive line breaks and will
	 * throw notices and create an invalid DB Query if they exist.
	 */
	$events_scheme = "CREATE TABLE {$db_prefix}events (
		event_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		site_id bigint(20) unsigned NOT NULL,
		event_hook varchar(255) NOT NULL,
		event_key char(32) NOT NULL,
		event_args longtext NOT NULL,
		event_timestamp datetime NOT NULL,
		event_schedule varchar(255) DEFAULT NULL,
		event_interval int unsigned DEFAULT NULL,
		event_status ENUM( 'waiting', 'running', 'complete' ) NOT NULL,
		PRIMARY KEY  (event_id),
		KEY hook_key_schedule (event_hook,event_key,event_schedule),
		KEY status (event_status)
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
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( get_schema() );

	update_site_option( PREFIX . 'db_version', DB_VERSION );
}
