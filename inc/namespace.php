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
	if ( wp_cache_get( 'installed', CACHE_GROUP ) ) {
		return true;
	}

	$installed = ( count( $wpdb->get_col( "SHOW TABLES LIKE '{$wpdb->base_prefix}{DB_PREFIX}%'" ) ) === 2 );

	if ( $installed ) {
		// Don't check again.
		wp_cache_set( 'installed', $installed, CACHE_GROUP );
	}

	return $installed;
}
