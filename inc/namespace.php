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
