=== Rapid Cron Queries ===
Contributors: peterwilsoncc
Tags: Cron, Performance
Requires at least: 5.1
Tested up to: 5.1
Requires PHP: 5.6
Stable tag: 1.0
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt

Replaces the WordPress cron option with a custom table to improve performance of sites with a large number of cron jobs.

== Description ==
WordPress Core stores all cron events as an array in a single option. As the number of events increases, this method of storage can become somewhat unwieldy and unperformant.

This plugin replaces the single option with a custom table for the storage of cron jobs.

This plugin makes use of the [Cron API features added in WordPress 5.1](https://make.wordpress.org/core/2019/01/23/cron-api-changes-in-wordpress-5-1/).
