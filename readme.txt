=== WP GCM ===
Contributors: pixelart-dev
Tags: gcm, c2d, android, google, cloud, messaging, google cloud messaging,
Donation Link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=2YCTDL7AFRHHG
Requires at least: 3.5
Tested up to: 3.8.1
Stable tag: 1.1.9
License: GPLv3
License URI: http://www.gnu.org/licenses/old-licenses/gpl-3.0.html

A WordPress Plugin for sending GCM messages trough the WordPress backend.

== Description ==
With this plugin you can send messages using Google Cloud Messaging to your Android Apps, when they're using GCM. 
You just need your Api-Key!

This Plugin can notify, when you want it, your users with your GCM App when a new post is published or a post was updated.
Of course you can also write them messages, e.g. when a special post is posted, or something like that

You can ONLY use this Plugin if you have an Android App which uses GCM AND is connected to your api key. 
If you don't know what GCM is then please go to: http://developer.android.com/google/gcm/index.html

= COMING SOON=
- Demo Blog with demo App
- Demo Android Eclipse Project
- For a little fee custom Android Blog App

== Installation ==
1.Upload the folder 'gcm' to the '/wp-content/plugins' directory on your server.
2. Go to 'Plugins' trough the admin dashboard and activate the plugin.
3. After the activation you will be redirected to the settings page where you can setup the plugin. First of all you need your Api-key.
4.When everything is setted up click save, and your finished!
Now you can write Messages.
___________

In your Android App you need to set the registration url to the following: {BLOG URL}/wp-content/plugins/gcm/register.php
You also need to include the " regId " parameter in the url containing the device regId.
A sample URL : " http:// www.myblog. com/wp-content/plugins/gcm/register.php?regId=AbCdEfG12345 "
When you need help, visit : http://developer.android.com/google/gcm/index.html

== Frequently Asked Questions ==
= Where to find the Api Key ? =

A: just go to the Api Console: " https://code.google.com/apis/console/ " log in and navigate to > your project > to Api Access.


= How to setup a GCM Android App ? =

A: You could go to: http://developer.android.com/google/gcm/index.html , and follow the tutorial, or you can send me an eMail for the sample Android Project I wrote.


= Is there a demo site ? =

A: Thre will be one soon.



== Screenshots ==
1. Writing a message

2. Settings page

== Changelog ==
1.1 Public Release
