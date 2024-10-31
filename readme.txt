=== MyPress ===
Contributors: danilopolani
Donate link: http://www.danilopolani.com
Tags: mybb
Requires at least: 3.0.1
Tested up to: 4.5.1
Stable tag: 1.01
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Connect WordPress with MyBB. Everytime a user registers in your MyBB Forum, he will also be registered in WordPress.

== Description ==

This plugin will allow you to connect your `WordPress blog` with your `MyBB forum`.

When someone registers in MyBB, his information like the *username* will be stored in WordPress, so when he logins in the blog, he will be automatically logged in in the forum.

The system is tested with *MyBB v1.8.\**

Download the MyBB-side: https://www.dropbox.com/s/k2llnw3pz1keaz8/MyPress-MyBB.zip?dl=0

== Installation ==

1. `BEFORE YOU BEGIN`: Install MyPress on MyBB (https://www.dropbox.com/s/k2llnw3pz1keaz8/MyPress-MyBB.zip?dl=0).
1. Upload the plugin files to the `/wp-content/plugins/mypress` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress.
1. Use the `Settings->MyPress` screen to configure the plugin.
1. Delete all cookies.


== Frequently Asked Questions ==

= Where is stored the connection between MyBB and WordPress? =

The connection is made by the column `idwp` in MyBB users table.
