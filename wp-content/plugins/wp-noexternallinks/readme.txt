=== WP No External Links ===
Author: Jehy
Tags: seo, link, links, publisher, post, posts, comments
Requires at least: 2.6
Tested up to: 4.5.3
Stable tag: 3.5.17
Mask all external links - make them internal or hide. On your own posts, comments pages, authors page - no more PR\CY dropping!

== Description ==
> New feature - [extend plugin with your own functions](http://jehy.ru/articles/2014/12/08/custom-parser-for-wp-noexternallinks/)! For example, you can [encrypt links](http://jehy.ru/articles/2014/12/09/encrypting-links-for-wp-noexternallinks/).

This plugin has many cool features - outgoing clicks stats, fulllink masking, custom redirects,masking links to digital short code and base64 encoding and so on.It is designed for specialists who sell different kind of advertisment on their web site (for example, with [sape](http://www.sape.ru/r.f6054dfcc2.php) system) and care about the number of outgoing links that can be found by search engines. Now you can make all external links internal! In your own posts, comments pages, authors page... Plugin does not change anything or write to base - just processes output.

Now you don't need to worry about your page rank or index, dropping because of spam bots. You write any kind of http link - and it becomes internal or hidden! Of cause, all the links will still be usable :).

Warning: this plugin may conflict with your caching plugins, including Hyper Cache. Usually adding redirect page to caching plugin exclusions works fine, but I can't garantee that everything will go smoothly. By the way, after deactivation this plugins leaves no traces in your database or hard drive - so if you have you have problems after deactivation - please, search them in another source, for example, caching plugins. Flushing cache should help.

You can take part in plugin development on [github](https://github.com/jehy/wp-noexternallinks).

###New Features:    

####Version 3.5.1 implemented:   
+ Extending plugin with custom functions   

####Version 3.3.2 implemented:   
+ Debug mode   

####Version 3.3 implemented:   
+ Masking links with base64 (quick and no need for mysql table)   

####Version 3.2 implemented:   
+ Completely removing links from your posts (someone requested this option)   
+ Masking links to text. Option for perverts.   

####Version 3.1 implemented:  
+ Masking links with digital short codes    

####Version 3.0 implemented:    
+ Outgoing clicks stats    
+ Javascript redirect with custom text and timeout    
+ .po file translation (sorry, now only english and russian versions are available)    
+ FULL link masking    
+ No masking for registered users    

####Version 2.0 implemented:
+ You can configure plugin to mask ALL LINKS on your blog - including widget, theme footer, etc.    
+ Now you can also disable link rewriting, and use **"rel=nofollow"** and **&lt;noindex&gt;** tag instead of it - everything as you wish!   
+ From version 2.0 you can **make all links open in new window!**   
+ After many requests, I finally made an option to **disable masking** for concrete URLs and posts.  
+ Plugin works now without any magic with .htacess - you just install it and it works, and determines itself, if you need to rewrite permalinks, or use default link structure.  
Have fun!

####Example

To make the long story short, your links like "http://gmail.com" will be masked into  
"http://YourBlog.com/goto/http://gmail.com" - or  
"http://YourBlog.com?goto=http://gmail.com"

Now you can even tansform simple link "&lt;a href="http://google.com"&gt;google&lt;/a&gt;" to   
"&lt;noindex&gt;&lt;a rel="nofollow" target="_blank" href="http://google.com"&gt;google&lt;/a&gt;&lt;/noindex&gt;"

####Just one popular question :)
>  **- Is it an evil hack and black SEO?!**   
 - Before you say such awful things, read at least [Google's topics on SEO](http://www.google.com/support/webmasters/bin/topic.py?topic=8522)   

####Donate or help?
If you want to ensure the future development and support of this plugin, you can make donation [on this page](http://jehy.ru/articles/donate/) or just write about this plugin in your blog.

####Note
&lt;noindex&gt; tag is used mostly by russian search system "Yandex" (yandex.ru), and non-russian users don't usually need it.

[You can view changelog here](https://wordpress.org/plugins/wp-noexternallinks/changelog/).

####Localization

* English
* Russian
* Spanish
* Your language also can be here - just send me language file :)


####Please!
If you don't rate my plugin as 5/5 - please write why - and I will add or change options and fix bugs. It's very unpleasant to see silient low rates.

== Changelog ==

0.01 - First release.  
0.02 - Multilanguagal release.  
0.03 - Bugfix.  
0.04 - Activation \ Deactivation improved, optimization, localization settings now stored as options.  
0.05 - Bugfix for wrong html parsing.  
0.06 - Bugfix for email links.  
0.07 - Better work for sites wihout mod_rewrite.  
0.071 - Russian translation corrected.  
   
   
2.0 - Many significant changes, including urls and post exclusion from masking, another rewrite structure, and new options.   
2.01 - Little bugfix, for fixing errors when empty exlusions.  
2.02 - Updated to execute later then other link filters, preventing possible problems with other plugins.   
2.03 - Fixed broken exclusions list.   
2.04 - Changed default settings, removed "disable links masking".    
2.05 - Fixed internationalization, added Belarusian language.    
    
    
2.10 - Plugin was rewrited for faster performance, fixed adding targer="_blank" for internal links.    
2.11 - Removed "public" keyword in class functions definitions. Probably will be more compatible with PHP4.    
2.12 - Fully compatible with PHP4.    
2.13 - Fixed language inclusion problem which apperared in some cases.    
2.14 - Absolute  file paths used now instead of relative.    
2.15 - Fixed for some servers with setup which replaces "//" with"/".    
2.16 - Javascript links aren't broken by plugin now, thanks to [Andu](http://anduriell.es).    
2.17 - Several bugfixes for low possible case scenarios...    
2.171 - Added automatic exclusion of internal links (#smth) from masking.    
2.172 - fixed javascript error when redirects ended with ";"    
    
    
3.0.0 - Code improvements, added .po translation,clicks stats and option to mask Everything.  
3.0.1 - Fixed option update issue.   
3.0.2 - Removed test message "failed to update options" when nothing changed in options. Also, fixed issue when, if link masking was disabled for post, it was also disabled for comments.   
3.0.3 - Removed some extra info, added some error handlers, repaired broken system for flushing click stats.    
3.0.4 - Fixed when some options in checkboxes couldn't be changed.    
3.1.0 - Added masking links with digital short codes.    
3.1.1 - Improved compatibility with some shitty servers.    
3.2 - Two new options, little backslashes fix, error reporting fix.    
3.3 - Additional protect from masking links in RSS, fix for admin panel in wordpress 3.4.2, Perfomance fixes.   
3.3.1 - Hotfix for some blogs which crashed on checking if page is RSS feed, improvements for option "Mask ALL links in document" - now it doesn'n mask RSS and posts with option "don't mask links".    
3.3.2 - Imporovements for option "Mask ALL links in document", debug mode.    
3.3.3b - Exclusions list fix, possible fix for not found 'is_user_logged_in' function.    
3.3.4 - Now you can customize link view if you chose "remove links" or "turn links into text". Use CSS classes "waslinkname" and "waslinkurl" for it.
3.3.5 - Little update so that plugin won't cause harmless warning.    
3.3.6 - More output for debug mode.    
3.3.7 - Crytical update for 3.3.6.    
3.3.8 - Correct redirection links with GET parameters, sometimes damaged by wordpress output.    
3.3.9 - Updated for correct work with enabled statistics and Hyper Cache plugin.    
3.3.9.1 - Added some more debug.    
3.3.9.2 - Now debug mode does not mess up web site. Also added some text to options page.    

3.4 - Replaced direct SQL queries with WPDB interface.   
3.4.1, 3.4.2 - Fixed displaying error where there are no stats for today.   
3.4.3 - Added detection and prevention of possible spoofing attacks. See new option in plugin settings. It is enabled by default.   
3.4.4 - Added exclusion for polugin from WP Super Cache.   
3.4.5 - Added option to disable links masking when link is made by admin and has **rel="follow"** attribute   
3.5 - Redesigned user friendly admin area!   
3.5.1 - Added option for developers - now you can extend plugin with custom parsing functions! Just rename "custom-parser.sample.php" to "custom-parser.php" and extend the class (see sample file for details). Your modifications will stay even after plugin upgrade!  
3.5.2 - Some refactoring.  
3.5.3 - Do not disable error reporting on server any more.  
3.5.4 - Fixed "rel=follow" feature.  Added icon for admin menu.  
3.5.5 - Divided code to smaller functions for easier overwrite with custom modes.  
3.5.6 - Fixed bug with writing click stats to database.  
3.5.7,3.5.8 - Custom parser file moved to uploads directory to avoid deletion.  
3.5.9 - Updated filter to support multiline links code.  
3.5.9.1 - Fixed bug when statistic was not written.  
3.5.9.2 - Parser logic optimization and fixes.  
3.5.9.3 - Added noindex comment option for yandex search engine.  
3.5.9.4 - Added masking options for RSS feed.  
3.5.9.5 - Added support for relative links, beginning with slash (/).  
3.5.9.6 - Fix for RSS masking.  
3.5.9.7 - Add support for custom location of wp-content dir.  
3.5.9.8 - Fixed custom parser load.  
3.5.9.9 - Added custom filter with name "wp_noexternallinks". Please use it for custom fields and so on.  
3.5.9.10 - Disabled full masking when running cron job to avoid collisions.  
3.5.10 - Fixed issues with cron job  
3.5.11 - minor improvements  
3.5.12, 3.5.13 - bugged versions  
3.5.14 - fallback to 3.5.11  
3.5.15 - fix masking issues with mixed http/https
3.5.16 - minor security fix
3.5.17 - fix for better compatibility with php7

== Installation ==

1. Upload the complete folder `wp-noexternallinks` to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
2. [Optional] Configure plugin via admin options-&gt;Wp-NoExternalLinks link
4. Write posts with any kind of links, watch comments with links - and enjoy =^___^=

== Frequently Asked Questions ==
####How can I exclude my page with links from masking?   
Now you just put URLS you need to the exclusion list, or disable masking for concrete post - and everything's OK!!!

####I removed your plugin but all links are masked!!!   
This plugin can't do it after uninstall. It doesn't change base or code of wordpress. Please,
* Remove another links plugin.
* Update your cache.
* Deactivate your caching plugin.

####How can I mask links in custom field?
You will have to add just a line in theme code where you output custom field data.    
To add same preprocessing for data as for comment text, use    
    $metadata=apply\_filters('comment\_text',$metadata);    
For example, if you use some kind of metadata, it should look like this:    
    $metadata = get\_post\_meta($id, 'MetaTagName', true);// get data from wordpress database    
    $metadata=apply\_filters('comment\_text',$metadata);// add this line of code for preprocessing field value    
    echo $metadata;//output preprocessed field value    

That's if you want to mask links in custom field like in comments text. Use "the\_content" instead of "comment\_text" if  you want to use the same masking policy as for post text.