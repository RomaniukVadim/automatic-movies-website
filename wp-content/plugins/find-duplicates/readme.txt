=== Find Duplicates ===
Contributors: markusseyer
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=4S7SVMALSSZ2Y
Tags: duplicates,posts,similarity
Requires at least: 3.0
Tested up to: 3.6.1
Stable tag: 1.4.6

The plugin finds duplicate or similar posts based on their post_content or post_title similarity. You can define the percentage of similarity and other parameters.

== Description ==

A plugin that finds duplicate and similar posts based on their post_content or post_title similarity. You can define the percentage of similarity, post type and post status. The plugin is a great utility to find duplicates that differ in only a few characters.

* Search for duplicate posts
* Search for similar posts
* Define post types
* Define post statuses
* Define value of similarity
* limit by date
* Support for custom post types
* Two-click-delete posts in result list
* Multi-language interface


== Installation ==

1. Upload the folder `find-duplicates` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Use the new menu item appearing under 'tools'

== Frequently Asked Questions ==

= A way to run it in Cron? =

The calculation of content similarity is an time-consuming task.
Therefore we get problems with the execution time while doing ist with cron-jobs.
While comparing articles through the interface we can use ajax to avoid this.

== Screenshots ==

1. Find duplicates
2. Find duplicates settings page

== Changelog ==

= 0.5 =
* Bug fixes
* avoid duplicate result

= 1.0 =
* Bug fixes
* Added: One-click-delete newer posts in result list
* Added: Multi-language interface
* Added: Paypal-Button
* Added: Loggin-area for developers
* Added: Possibility to continue chanceled searches
* Fixed: Errors while handling thousands of posts

= 1.1 =
* Bug fixes

= 1.2 =
* Added: "Find duplicates" on post editing page
* Added: Set "Pending" on duplicates while publishing posts
* Added: Limit search by post_date
* Added: Limit comparison on post_title
* Added: Ignore html-tags
* Changed: some design details
* Changed: some code improvement

= 1.2.1 =
* Bug fixes for php safe-mode

= 1.3 =
* Bug fixes
* Using the built-in jquery-ui from wordpress
* New Button "Delete older posts"

= 1.4 =
* Speed improvements
* Individually select posts to delete
* Define comparisons per server-request
* Define words to be ignored

= 1.4.1 =
* Some Bugfixes

= 1.4.5 =
* Added: Limit automatic/manual search to the last X days
* Added: Choose default target for duplicates

= 1.4.6 =
* Bug fixes