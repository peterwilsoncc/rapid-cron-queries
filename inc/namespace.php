<?php
namespace PWCC\WP_Cron_Cavalcade;

/**
 * Initialize the plugin.
 *
 * Runs on the `plugins_loaded` hook at priority 9.
 *
 * As the
 */
function bootstrap() {
	if ( ! function_exists( '\\HM\\Cavalcade\\Plugin\\bootstrap' ) ) {
		if ( ! file_exists( PLUGIN_DIR . '/cavalcade/plugin.php' ) ) {
			// Bail: Cavalcade is undefined and the files do not exist.
			return;
		}
		require_once PLUGIN_DIR . '/cavalcade/plugin.php';
	}

	// Ensure Cavalcade is installed before attempting to boostrap.
		if (
			! \HM\Cavalcade\Plugin\is_installed() &&
			! \HM\Cavalcade\Plugin\create_tables()
		) {
		add_action( 'wp_install', __NAMESPACE__ . '\\bootstrap', 9 );
		return;
	}

	/*
	 * The Cavalcade plugin uses a different rescheduling algorithm to WordPress
	 * Core. This overrides the Cavalcade changes to use the WordPress default.
	 *
	 * This runs early to ensure Cavalcade defers to the override.
	 */
	add_filter( 'pre_reschedule_event', __NAMESPACE__ . '\\pre_reschedule_event', 9, 2 );
}

/**
 * Reschedules a recurring event.
 *
 * This replaces the Cavalcade modification to rescheduling algorithm to use the WordPress
 * default algorithm.
 *
 * Runs on the filter `pre_reschedule_event` at priority 9.
 *
 * @param null|bool $pre   Value to return instead. Default null to continue adding the event.
 * @param stdClass  $event {
 *     An object containing an event's data.
 *
 *     @type string       $hook      Action hook to execute when the event is run.
 *     @type int          $timestamp Unix timestamp (UTC) for when to next run the event.
 *     @type string|false $schedule  How often the event should subsequently recur.
 *     @type array        $args      Array containing each separate argument to pass to the hook's callback function.
 *     @type int          $interval  The interval time in seconds for the schedule. Only present for recurring events.
 * }
 * @return bool True if event successfully rescheduled. False for failure.
 */
function pre_reschedule_event( $pre, $event ) {
	// Allow other filters to do their thing.
	if ( $pre !== null ) {
		return $pre;
	}

	// First check if the job exists already.
	$jobs = \HM\Cavalcade\Plugin\Job::get_jobs_by_query( [
		'hook' => $event->hook,
		'timestamp' => $event->timestamp,
		'args' => $event->args,
	] );

	if ( is_wp_error( $jobs ) || empty( $jobs ) ) {
		// The job does not exist.
		return false;
	}

	$job = $jobs[0];

	// Now we assume something is wrong (single job?) and fail to reschedule
	if ( 0 === $event->interval && 0 === $job->interval ) {
		return false;
	}

	// Determine when to next run the event per WordPress Core.
	$timestamp = $event->timestamp;
	$now = time();
	if ( $timestamp >= $now ) {
		$timestamp = $now + $event->interval;
	} else {
		$timestamp = $now + ( $event->interval - ( ( $now - $timestamp ) % $event->interval ) );
	}

	$job->nextrun = $timestamp;
	$job->interval = $event->interval;
	$job->schedule = $event->schedule;
	$job->save();

	// Rescheduled.
	return true;
}
