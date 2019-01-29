<?php
namespace PWCC\RapidCronQueries;

const PREFIX     = 'rapid_cron_';
const DB_VERSION = 1;

/**
 * Kick it off.
 */
function fast_bootstrap() {
	// Bootstrap database first, otherwise nothing else works.
	Database\fast_bootstrap();

	Connector\fast_bootstrap();
}

/**
 * Events requiring WP to have loaded.
 */
function bootstrap() {
}

