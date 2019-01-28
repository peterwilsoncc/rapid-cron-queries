<?php
namespace PWCC\RapidCronQueries;

const TABLE_PREFIX = 'rapid_cron_';
const DB_VERSION = 1;

/**
 * Kick it off.
 */
function fast_bootstrap() {
	Database\fast_bootstrap();
}

/**
 * Events requiring WP to have loaded.
 */
function bootstrap() {
}

