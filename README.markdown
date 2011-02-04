##**This application was originally forked from the "Advanced Events Registration" plugin version 2.1.17 by Seth Shoultes. Not Found on Github**

This plugin as well as its original branch, are openly distributed using the GNU General Public License.

The original branch of this plugin is now known as "Event Espresso" and is on version 2.1.28 as of this posting.

Be sure to check out [@Seth](http://twitter.com/eventespresso)

**SEE "original_readme.txt" FOR INSTALLATION INSTRUCTIONS AND OTHER DETAILS**

##New Features in this version:

+ Localization (Canadian) - Later version of original branch included multiple configurations based on location

+ A few bug fixes, some of which made their way into later versions of the plugin. 

+ Auto-Generation of Wordpress user accounts for *paid* attendees. This is the **Meat and Potatoes** of this version of the plugin. When payment confirmation is received for an attendee, a WordPress user account is automatically generated for that attendee such that: {"username": [attendeeFirstName]"_"[attendeeLastName], "password": [randomlyGenerated], "FirstName":[attendeeFirstName], "LastName": [attendeeLastName], "Email": [attendeeEmail],"Role": "-No role for this site-"} 
These changes can be found in includes/process_payments.php 