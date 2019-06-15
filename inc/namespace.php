<?php
namespace PWCC\RapidCronQueries;

const PREFIX     = 'rapid_cron_';
const DB_VERSION = 1;
const MYSQL_DATE_FORMAT = 'Y-m-d H:i:s';
const CACHE_GROUP = 'rapid-cron';

/**
 * Kick it off.
 */
function bootstrap() {
	wp_cache_add_global_groups( CACHE_GROUP );
}

/**
 * Tidy up the defined prefix to ensure it's valid.
 *
 * @param bool $die Die if the prefix is invalid. Default true.
 * @return string PRFIX constant modified to be SQL table name safe.
 */
function get_table_prefix( $die = true ) {
	$prefix = preg_replace( '|[^a-z0-9_]|i', '', PREFIX );
	if ( $prefix && substr( $prefix, -1 ) === '_' ) {
		return $prefix;
	} elseif ( $prefix ) {
		return "{$prefix}_";
	}

	// Invalid prefix.
	if ( $die ) {
		wp_die(
			__( 'Rapid Cron prefix is invalid, a valid MYSQL table name can not be generated.', 'rapid_cron' ),
			__( 'An error has occurred.', 'rapid-cron' )
		);
	}

	return new \WP_Error(
		'rapid_cron_invalid_prefix',
		__( 'Rapid Cron prefix is invalid, a valid MYSQL table name can not be generated.', 'rapid_cron' )
	);
}
