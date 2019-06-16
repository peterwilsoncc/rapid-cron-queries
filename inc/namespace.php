<?php
namespace PWCC\RapidCronQueries;

/**
 * Kick it off.
 */
function bootstrap() {
	if ( preg_replace( '|[^a-z0-9_]|i', '', DB_PREFIX ) !== DB_PREFIX ) {
		// Invalid Database Prefix, bail.
		return;
	}
	wp_cache_add_global_groups( CACHE_GROUP );

	if ( ! is_installed() && ! create_tables() ) {
		return;
	}
}

/**
 * Is the plugin installed?
 *
 * Used during the plugin's bootstrapping process to create the table.
 *
 * Source: Cavalcade by Human Made.
 *
 * @return boolean
 */
function is_installed() {
	global $wpdb;
	$db_prefix = DB_PREFIX;
	if ( wp_cache_get( 'installed', CACHE_GROUP ) ) {
		return true;
	}

	$installed = ( count( $wpdb->get_col( "SHOW TABLES LIKE '{$wpdb->base_prefix}{$db_prefix}%'" ) ) === 2 );

	if ( $installed ) {
		// Don't check again.
		wp_cache_set( 'installed', $installed, CACHE_GROUP );
	}

	return $installed;
}

/**
 * Install Database tables.
 *
 * @return bool True on success, False on failure.
 */
function create_tables() {
	global $wpdb;
	$db_prefix = DB_PREFIX;

	/*
	 * Check if WP Tables are installed.
	 *
	 * This checks there are at least two tables with the prefix
	 * wp_user. It's not perfect and may return a false positive
	 * if another plugin adds tables with the same prefix.
	 *
	 * Such a plugin is running outside of warrenty so can be ignored.
	 */
	$wp_installed = $wpdb->get_col( "SHOW TABLES LIKE '{$wpdb->base_prefix}user%'" );
	if ( ! is_array( $wp_installed ) || count( $wp_installed ) < 2 ) {
		// WP is not installed.
		return false;
	}

	$query = "CREATE TABLE IF NOT EXISTS `{$wpdb->base_prefix}{$db_prefix}_jobs` (
		`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		`site` bigint(20) unsigned NOT NULL,

		`hook` varchar(255) NOT NULL,
		`args` longtext NOT NULL,

		`start` datetime NOT NULL,
		`nextrun` datetime NOT NULL,
		`interval` int unsigned DEFAULT NULL,
		`status` ENUM( 'waiting', 'running', 'complete', 'failed' ),
		`schedule` varchar(255) DEFAULT NULL,

		PRIMARY KEY (`id`),
		KEY `site` (`site`),
		KEY `hook_args` (`hook`, `args`(500)),
		KEY `nextrun` (`nextrun`),
		KEY `status` (`status`)
	) ENGINE=InnoDB;\n";

	if ( false === $wpdb->query( $query ) ) {
		return false;
	}

	$query = "CREATE TABLE IF NOT EXISTS `{$wpdb->base_prefix}{$db_prefix}_logs` (
		`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		`job` bigint(20) NOT NULL,
		`status` varchar(255) NOT NULL DEFAULT '',
		`timestamp` datetime NOT NULL,
		`content` longtext NOT NULL,
		PRIMARY KEY (`id`),
		KEY `job` (`job`),
		KEY `status` (`status`)
	) ENGINE=InnoDB;\n";

	if ( false === $wpdb->query( $query ) ) {
		return false;
	}

	wp_cache_set( 'installed', true, CACHE_GROUP );
	update_site_option( "{$db_prefix}_db_version", DB_VERSION );
	/*
	 * Ensure site meta is populated when running the WP CLI script to
	 * install a network. Using the CLI, WP installs a single site with
	 * wp_install() and then upgrades it to a multiste install immediately.
	 *
	 * Note: This does not work for multisite manual installs.
	 */
	add_filter( 'populate_network_meta', function( $site_meta ) {
		$site_meta['{$db_prefix}_db_version'] = DB_VERSION;
		return $site_meta;
	} );
	return true;
}
