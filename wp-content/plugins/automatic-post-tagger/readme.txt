=== Automatic Post Tagger ===
Contributors: Devtard
Donate link: http://devtard.com/donate
Tags: auto tags, keywords, post, posts, seo, tag, tags, tagger, tagging, taxonomy, taxonomies, woocommerce
Requires at least: 3.0
Tested up to: 4.4
Stable tag: 1.8.2
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Adds relevant taxonomy terms to posts using a keyword list provided by the user.

== Description ==
This plugin automatically searches posts when they are published/imported/saved and adds new taxonomy terms (**tags** by default) if term names or related keywords from a user-created keyword list are found.

= Features =
* Compatible with several post import plugins ([FAQ #4](https://wordpress.org/plugins/automatic-post-tagger/faq/))
* Supports **custom taxonomies** and **post types**; for example, APT is able to categorize posts ([FAQ #6](https://wordpress.org/plugins/automatic-post-tagger/faq/)), add tags/categories to WooCommerce products ([FAQ #7](https://wordpress.org/plugins/automatic-post-tagger/faq/))
* Supports **UTF-8** characters, non-Latin and logographic alphabets ([FAQ #5](https://wordpress.org/plugins/automatic-post-tagger/faq/)), including Arabic, Chinese, Cyrillic etc.
* Bulk tagging tool (with a **scheduler**) for processing multiple posts
* Import/Export tools (CSV & JSON format support)
* Configuration groups with custom rules for selected keyword sets; wildcard (regex) support for related keywords

See [Screenshots](https://wordpress.org/plugins/automatic-post-tagger/screenshots/) and [FAQ](https://wordpress.org/plugins/automatic-post-tagger/faq/) for more information.

== Installation ==
1. Install and activate the plugin.
2. Configure the plugin (Settings > Automatic Post Tagger).
3. Create or import keyword sets. *Term names* represent taxonomy terms (**tags** by default) which will be added to posts when they or the keyword set's *Related keywords* are found. Keyword sets can be categorized into custom *Configuration groups* with custom settings for selected keyword sets.
4. Publish/import/save posts. You can also use the Bulk tagging tool to process all of your already existing posts.

== Screenshots ==
1. Administration interface
2. Bulk tagging in action
3. Widget for creating new keyword sets displayed next to the post editor

== Frequently Asked Questions ==
= #1: How to make the plugin add taxonomy terms to drafts as well? =
By default only newly published and imported posts are automatically tagged. If you want to see the plugin in action when writing new posts or editing drafts, enable the option "Run APT when posts are: *Saved*" and add the post status "draft" to the option "Allowed post statuses".

= #2: PHP's "max_input_vars" limit has been exceeded and I can't edit or delete keyword sets/configuration groups. =
You may encounter this problem if the plugin stores a lot of keyword set/configuration group items in the database and your PHP configuration prevents input fields from being submitted if there's too many of them. You can fix this by doing one of the following:

1. Change the "Item editor mode" to "CSV".
2. If you can modify your PHP configuration, change the variable "max_input_vars" in your php.ini file to a higher value (1000 is usually the default value).

= #3: I'm getting the "Maximum execution time of XY seconds exceeded" error when tagging posts. =
This might happen if your posts are large or you have a lot of keyword sets in the database. Here's what you can do:

1. Remove some of your word separators (or enable the option "Replace non-alphanumeric characters with spaces" to ignore them completely).
2. Enable the option "Analyze only XY characters starting at position XY".
3. Lower the number of posts tagged per cycle when using the Bulk tagging tool.
4. If you can modify your PHP configuration, change the variable "max_execution_time" in your php.ini file to a higher value (30 is usually the default value).

= #4: Which post import tools are compatible with APT? =
So far APT has been successfully tested with the following:

* [IFTTT.com](https://ifttt.com/)
* [FeedWordPress](https://wordpress.org/plugins/feedwordpress/)
* [RSS Post Importer](https://wordpress.org/plugins/rss-post-importer/)
* [WordPress Importer](https://wordpress.org/plugins/wordpress-importer/)
* [WP All Import](https://wordpress.org/plugins/wp-all-import/) (code modification required - [more information](https://wordpress.org/support/topic/apt-doesnt-work-with-wp-all-import))
* [WPeMatico](https://wordpress.org/plugins/wpematico/) (code modification required - [more information](http://devtard.com/?p=1001))

If your post import tool/plugin is not compatible with APT, you can still set up recurring bulk tagging events to regularly process new posts.

= #5: Can APT tag posts written in Chinese, Japanese, Korean and similar languages? =
Yes. You will have to enclose every single logogram used as a related keyword in wildcards or disable automatic input correction and replace all word separators with one string separator. See [this page](http://devtard.com/?p=837) for more information.

= #6: How to add categories to posts? =
Add the taxonomy "category" to configuration groups of your choice.

= #7: How to add tags and categories to WooCommerce products? =
Add the post type "product" to the option "Allowed post types", enable the option "Run APT when posts are: *Saved*" and add taxonomies "product_tag" and "product_cat" to configuration groups of your choice. 

== Changelog ==
= 1.8.2 (2015-11-18) =
Fixed:

* Bug responsible for deleting terms even if no new ones were found
* Issue with saving post types

= 1.8.1 (2015-06-07) =
Fixed:

* Bug responsible for adding blank elements into the related keywords array

= 1.8 (2015-06-07) =
New features:

* Multiple taxonomies support
* Configuration groups
* Automatic backups before updating
* New import/export tools for plugin settings and configuration groups; JSON format support
* Bulk tagging scheduler

Other changes:

* New "At a glance" widget
* The APT meta box is now displayed next to the post editor only if the post type of the currently edited post is listed among the allowed post types.
* Backward compatibility for older versions implemented
* APT now uses the function "wp_set_object_terms" to add terms to posts instead of "wp_set_post_terms"
* CSV structure is checked when importing items
* If database options are missing, default plugin data are automatically recreated; suboptions are now automatically added during the update if they're missing
* Submitted post types and taxonomies that aren't registered can't be saved
* Keyword sets sets can no longer be deleted by leaving the term names empty
* Update nags can be hidden now
* Grammatical numbers in messages corrected
* Backup filenames now contain version and a timestamp
* Several suboptions renamed
* Integer matching regex patterns updated
* New functions replaced repeated blocks of code
* Multiple bug fixes
* New terminology
* New PHPDoc comments
* Minor appearance changes

== Upgrade Notice ==
= 1.8.2 =
* Bug fixes

= 1.8.1 =
* Bug fix

= 1.8 =
* Multiple new features and bug fixes
