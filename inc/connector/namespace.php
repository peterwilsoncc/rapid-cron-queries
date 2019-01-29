<?php
namespace PWCC\RapidCronQueries\Connector;

/**
 * Boostrap Connector functionality
 *
 * Runs as WordPress bootstraps.
 */
function fast_bootstrap() {
	// Setters.
	add_filter( 'pre_schedule_event', __NAMESPACE__ . '\\pre_schedule_event', 10, 2 );
	add_filter( 'pre_reschedule_event', __NAMESPACE__ . '\\pre_reschedule_event', 10, 2 );

	// Deleters.
	add_filter( 'pre_unschedule_event', __NAMESPACE__ . '\\pre_unschedule_event', 10, 4 );
	add_filter( 'pre_clear_scheduled_hook', __NAMESPACE__ . '\\pre_clear_scheduled_hook', 10, 3 );
	add_filter( 'pre_unschedule_hook', __NAMESPACE__ . '\\pre_unschedule_hook', 10, 2 );

	// Getters.
	add_filter( 'pre_get_scheduled_event', __NAMESPACE__ . '\\pre_get_scheduled_event', 10, 4 );
	add_filter( 'pre_get_ready_cron_jobs', __NAMESPACE__ . '\\pre_get_ready_cron_jobs' );
}

/**
 * Schedules an event.
 *
 * Schedules a hook which will be triggered by WordPress at the specified time.
 *
 * Note that scheduling a single event to occur within 10 minutes of an existing event
 * with the same action hook will be ignored unless you pass unique `$args` values
 * for each scheduled event.
 *
 * @param null|bool $pre   Value to return instead. Default null to continue adding the event.
 * @param \stdClass $event {
 *     An object containing an event's data.
 *
 *     @type string       $hook      Action hook to execute when the event is run.
 *     @type int          $timestamp Unix timestamp (UTC) for when to next run the event.
 *     @type string|false $schedule  How often the event should subsequently recur.
 *     @type array        $args      Array containing each separate argument to pass to the hook's callback function.
 *     @type int          $interval  The interval time in seconds for the schedule. Only present for recurring events.
 * }
 *
 * @return bool Success of storing event.
 */
function pre_schedule_event( $pre, $event ) {
	// Pre hijacked.
	if ( $pre !== null ) {
		return $pre;
	}

	return $pre;
}

/**
 * Reschedule an event.
 *
 * @param null|bool $pre   Value to return instead. Default null to continue adding the event.
 * @param \stdClass $event {
 *     An object containing an event's data.
 *
 *     @type string       $hook      Action hook to execute when the event is run.
 *     @type int          $timestamp Unix timestamp (UTC) for when to next run the event.
 *     @type string|false $schedule  How often the event should subsequently recur.
 *     @type array        $args      Array containing each separate argument to pass to the hook's callback function.
 *     @type int          $interval  The interval time in seconds for the schedule. Only present for recurring events.
 * }
 *
 * @return bool Success of rescheduling event.
 */
function pre_reschedule_event( $pre, $event ) {
	// Pre hijacked.
	if ( $pre !== null ) {
		return $pre;
	}

	return $pre;
}

/**
 * Unschedule a previously scheduled event.
 *
 * The $timestamp and $hook parameters are required so that the event can be
 * identified.
 *
 * @param null|bool $pre       Value to return instead. Default null to continue unscheduling the event.
 * @param int       $timestamp Timestamp for when to run the event.
 * @param string    $hook      Action hook, the execution of which will be unscheduled.
 * @param array     $args      Arguments to pass to the hook's callback function.
 *
 * @return bool Success of unscheduling event.
 */
function pre_unschedule_event( $pre, $timestamp, $hook, $args ) {
	// Pre hijacked.
	if ( $pre !== null ) {
		return $pre;
	}

	return $pre;
}

/**
 * Unschedules all events attached to the hook with the specified arguments.
 *
 * Warning: This function may return Boolean FALSE, but may also return a non-Boolean
 * value which evaluates to FALSE. For information about casting to booleans see the
 * {@link https://php.net/manual/en/language.types.boolean.php PHP documentation}. Use
 * the `===` operator for testing the return value of this function.
 *
 * @param null|array $pre  Value to return instead. Default null to continue unscheduling the event.
 * @param string     $hook Action hook, the execution of which will be unscheduled.
 * @param array      $args Arguments to pass to the hook's callback function.
 *
 * @return bool|int On success an integer indicating number of events unscheduled (0 indicates no
 *                  events were registered with the hook and arguments combination), false if
 *                  unscheduling one or more events fail.
 */
function pre_clear_scheduled_hook( $pre, $hook, $args ) {
	// Pre hijacked.
	if ( $pre !== null ) {
		return $pre;
	}

	return $pre;
}

/**
 * Unschedules all events attached to the hook.
 *
 * Can be useful for plugins when deactivating to clean up the cron queue.
 *
 * Warning: This function may return Boolean FALSE, but may also return a non-Boolean
 * value which evaluates to FALSE. For information about casting to booleans see the
 * {@link https://php.net/manual/en/language.types.boolean.php PHP documentation}. Use
 * the `===` operator for testing the return value of this function.
 *
 * @param null|array $pre  Value to return instead. Default null to continue unscheduling the hook.
 * @param string     $hook Action hook, the execution of which will be unscheduled.
 *
 * @return bool|int On success an integer indicating number of events unscheduled (0 indicates no
 *                  events were registered on the hook), false if unscheduling fails.
 */
function pre_unschedule_hook( $pre, $hook ) {
	// Pre hijacked.
	if ( $pre !== null ) {
		return $pre;
	}

	return $pre;
}

/**
 * Retrieve a scheduled event.
 *
 * Retrieve the full event object for a given event.
 *
 * @param null|bool $pre       Value to return instead. Default null to continue retrieving the event.
 * @param string    $hook      Action hook of the event.
 * @param array     $args      Optional. Array containing each separate argument to pass to the hook's callback function.
 *                             Although not passed to a callback, these arguments are used to uniquely identify the
 *                             event, so they should be the same as those used when originally scheduling the event.
 * @param int|null  $timestamp Optional. Unix timestamp (UTC) of the event. If not specified, the next scheduled event is returned.
 *
 * @return bool|object The event object. False if the event does not exist.
 */
function pre_get_scheduled_event( $pre, $hook, $args, $timestamp ) {
	// Pre hijacked.
	if ( $pre !== null ) {
		return $pre;
	}

	return $pre;
}

/**
 * Retrieve cron jobs ready to be run.
 *
 * @param null|array $pre Array of ready cron tasks to return instead. Default null
 *                        to continue using results from _get_cron_array().
 *
 * @return array Cron jobs ready to be run.
 */
function pre_get_ready_cron_jobs( $pre ) {
	// Pre hijacked.
	if ( $pre !== null ) {
		return $pre;
	}

	return $pre;
}
