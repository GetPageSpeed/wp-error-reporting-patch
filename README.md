# Wordpress Error Reporting Patch

This plugin automatically patches `wp-load.php` and disables known Wordpress core calls to `error_reporting()`.

This is a security measure for PHP versions >= 7.0, which have [changed their internal design](https://bugs.php.net/bug.php?id=71340) to allow (for hackers benefit), to change error reporting level and effectively override whatever level was set by system admin.

For production websites, disallowing the `error_reporting` function *altogether* is the best security measure. Because otherwise it allows hackers to [stay undetected easily while exploiting your server](https://www.getpagespeed.com/server-setup/security/php-security-disable-error_reporting-now). 

You should obviously disable `error_reporting` function in your `php.ini`, not just use this plugin, which is complementary.
This complementary patch will make sure that Wordpress will not try to call `error_reporting()`, thus eliminating unnecessary warning messages from your logs:

> error_reporting() has been disabled for security reasons in wp-load.php on line 24

> error_reporting() has been disabled for security reasons in load.php on line 333

So the plugin:

* keeps your logs cleaner
* makes your Wordpress run a few less lines of unnecessary code
