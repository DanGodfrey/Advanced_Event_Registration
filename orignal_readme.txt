=== Advanced Events Registration ===

Contributors: 
Seth Shoultes http://www.shoultes.net
Ben Dunkle http://field2.com - Icon Design - Thanks Ben!!

Donate link: http://shoultes.net/wordpress-events-registration-with-paypal-ipn/

Tags: event management, event registration, paypal event registration, paypal ipn

Requires at least: 2.7.1

Tested up to: 2.9.2

Stable tag: 2.1.17


== Description ==

This plugin provides a way to take online registrations for events such as conference and seminars that are held live. While the pro version can be extended to use Authorize.net, this version only uses the PayPal IPN to record payments to a database. This is basically a fully working preview of the pro version. Some advanced  functionality has been left out and is available in the pro version of the plugin.

**[Upgrade to Pro Version](http://shoultes.net/upgrade-to-pro-version/)**

This wordpress plugin is designed to run on a Wordpress webpage and provide registration for an event. It allows you to capture the registering persons contact information to a database and provides an association to an events database. It provides the ability to send the registrant to your PayPal payment page for online collection of event fees. PayPal payments are captured to the database using the PayPal Standard IPN. Events are sorted by date and a short code is provided to display a single event or category of events on a page.

Reporting features provide a list of events, list of attendees, and excel export.

I have made several changes to this plugin in the last few months. Quite a bit has changed in the code and database tables. If you are upgrading from a previous version of this plugin, be sure to back up your current installation of this plugin. It is also a good idea to backup your Wordpress database as well. If you have modified the original code of your current installation you definitely want to make a backup of your existing plugin. I would even suggest installing the plugin on a test version of Wordpress.


== Support ==
Attention: Be sure to configure the Organization Settings to include the pages that are required for processing the registrations.

Email questions or comments to seth@smartwebutah.com.  
If you like the plugin and find it useful, your donations would also help me keep it going and improve it.  You can donate and find online information at http://shoultes.net/wordpress-events-registration-with-paypal-ipn/.

Version: 2.1.17

Author: Seth Shoultes
Author URI: http://www.shoultes.net

Changes:
2.1.17
Added detailed instructions for page settings.
2.1.16
Removed some extra space from the end of the event_register_attendees.php file. It was causing problems with header already being sent.
2.1.15
Fixed the rest of the places that were using is_active='yes'.
2.1.14
Fixed the bug with events disappearing when updating. This was being caused by the is_active field storing the data (Y or N instead of yes or no) when I updated the radio buttons.
2.1.13
Fixed the problems with the radio buttons not staying checked.
2.1.12
Fixed short tags and fixed a conflict with the pagination class, renamed it to event_regis_pagination.
2.1.11
Fixed the problem with free events showing payment button.
2.1.10
Fixed a problem with the email link to PayPal.
2.1.9
Several updates to the admin style.
2.1.8
Fixed problem with not escaping qoutes
2.1.7
Fixed some of the database insert functions
2.1.6
Minor fixes
2.1.5
Somehow the other changes didn't take effect!
2.1.4
Removed some old code.
2.1.3
Fixed database security holes.
2.1.2
Minor fixes throughout.
2.1.1
Added the ability to copy/duplicate an event.
Fixed a bug with the event questions/answers not showing in the Excel export.
Added event titles to the event url's for better SEO.
2.1.0
Removed the events_organization database table, we are now using the native Wordpress options database table to store the organization settings. This has speeded up the regsistration process considerably.


== Installation ==

1. After unzipping, upload everything in the `paypal-events-registration` folder to your `/wp-content/plugins/` directory (preserving directory structure).

2. Activate the plugin through the 'Plugins' menu in WordPress.

3. Go to the Event Registration Menu and Configure Organization and enter your company info - note you will need a paypal id if you plan on accepting paypal payments

4. Go to the Event Setup and create a new event, make sure you select 'make active'.

5. Create a new page (not post) on your site. Put {EVENTREGIS} in it on a line by itself.

6. Note: if you are upgradings from a previous version please backup your data prior to upgrade.

= License =

This plugin is provided "as is" and without any warranty or expectation of function. I'll probably try to help you if you ask nicely, but I can't promise anything. You are welcome to use this plugin and modify it however you want, as long as you give credit where it is due. 

== Screenshots ==

[View Sample Screens Here](http://shoultes.net/wordpress-events-registration-with-paypal-ipn/)

== Frequently Asked Questions ==
To use, create a new page with only  {EVENTREGIS}

To display list of attendees of an active event use {EVENTATTENDEES} on a page or post.

*For URL link back to the payment/thank you page use  {EVENTREGPAY} on a new page.

*For PayPal to notify about payment confirmation use  {EVENTPAYPALTXN} on a new page.

To display a single event on a page use the [SINGLEEVENT single_event_id="Unique Event ID"]

To display a list of events in sidebar, use the Event Registration Widget. If your theme doesn't use widgets, you can use  <?php display_all_events(); ?> in theme code.

*This page should be hidden from from your navigation menu. Exclude pages by using the ‘Exclude Pages’ plugin from http://wordpress.org/extend/plugins/exclude-pages/ or using the ‘exclude’ parameter in your ‘wp_list_pages’ template tag. Please refer to http://codex.wordpress.org/Template_Tags/wp_list_pages for more inforamation about excluding pages.

= Email Confirmations =
For customized confirmation emails, the following tags can be placed in the email form and they will pull data from the database to include in the email.

[fname], [lname], [phone], [event],[description], [cost], [company], [co_add1], [co_add2], [co_city],[co_state], [co_zip],[contact], [payment_url], [start_date], [start_time], [end_date], [end_time]


= Sample Mail Send =

***This is an automated response - Do Not Reply***

Thank you [fname] [lname] for registering for [event].  We hope that you will find this event both informative and enjoyable.  Should have any questions, please contact [contact].

If you have not done so already, please submit your payment in the amount of [cost].

Click here to reveiw your payment information [payment_url].

Thank You.

 
