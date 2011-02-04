<?php /*
Plugin Name: Advanced Events Registration
Plugin URI: http://shoultes.net/wordpress-events-registration-with-paypal-ipn/
Description: Out-of-the-box Events Registration integrated with PayPal IPN for your Wordpress blog/website. <a href="http://wpplugins.com/plugin/73/events-registration-with-paypal-ipn">Upgrade to Pro Version</a> | <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=5JGX5GVUSU54Y">Donate</a> | <a href="admin.php?page=support">Support</a>

Reporting features provide a list of events, list of attendees, and excel export.

Version: 2.1.17

Author: Seth Shoultes
Author URI: http://www.shoultes.net

Contributors:
Ben Dunkle http://field2.com - Icon Design - Thanks Ben!!

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
*/

/*  Copyright 2010  SETH SHOULTES  (email: seth@smartwebutah.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


//Define static variables
define("EVNT_RGR_PLUGINPATH", "/" . plugin_basename( dirname(__FILE__) ) . "/");

define("EVNT_RGR_PLUGINFULLURL", WP_PLUGIN_URL . EVNT_RGR_PLUGINPATH );

//Install/Update Tables when plugin is activated
require("includes/database_install.php"); 
register_activation_hook(__FILE__,'events_data_tables_install');

//Event questions/options
require("includes/event_form_config.php");

//Payment Page/PayPal Buttons - Used to display the payment options and the payment link in the email. Used with the {EVENTREGPAY} tag
require("includes/paypal.class.php");
require("includes/payment_page.php");

//The calendar pop function
require("includes/tc_calendar.php");

//Events Listing - Shows the events on your page. Used with the {EVENTREGIS} tag
require("includes/get_event_details.php");
require("includes/display_all_events.php");

//List Attendees - Used with the {EVENTATTENDEES} tag
require("includes/attendee_list.php");

//Widget - Display the list of events in your sidebar
require("includes/widget.php");

//Admin Widget - Display event stats in your admin dashboard
require("includes/event_regis_dashboard_widget.php");

//Payment processing - Used for onsite payment processing. Used with the {EVENTPAYPALTXN} tag
require("includes/process_payments.php");

//Build the admin header for the plugin
require("includes/admin_header.php");
add_action('admin_head', 'admin_register_head');

//Event Registration Subpage - Configure Organization
require("includes/organization_config_mnu.php");

//Event Registration Subpage - Add/Delete/Edit Events
require("includes/manage_events.php");

//Event Registration Subpage - View Attendees
require("includes/event_registration_reports.php");
require("includes/edit_attendee_record.php");
//require("includes/admin_list_attendees.php");

//Event Registration Subpage - Enter Attendee Payments
require("includes/admin_reports.php");
require("includes/admin_process_payments.php");
require("includes/list_attendee_payments.php");
require("includes/enter_attendee_payments.php");

//Event Registration Subpage - Plugin Support
require("includes/admin_event_categories.php");
require("includes/event_regis_categories.php");

//Event Registration Subpage - Plugin Support
require("includes/admin_support.php");

//Main form events page
require("includes/event_register_attendees.php");

//Event Registration Main Admin Page
function event_regis_main_mnu(){

/*  The following functions are what I wish to add to the main menu page
	1. Display current count of attendees for active event (show event name, description and id)- shows by default
*/
organization_config_mnu();

}

/**
 * Add a settings link to the Plugins page, so people can go straight from the plugin page to the
 * settings page.
 */
function event_regis_filter_plugin_actions( $links, $file ){
	// Static so we don't call plugin_basename on every plugin row.
	static $this_plugin;
	if ( ! $this_plugin ) $this_plugin = plugin_basename(__FILE__);
	
	if ( $file == $this_plugin ){
		$org_settings_link = '<a href="admin.php?page='.__FILE__.'">' . __('Settings') . '</a>';
		$events_link = '<a href="admin.php?page=events">' . __('Events') . '</a>';
		array_unshift( $links, $org_settings_link, $events_link ); // before other links
	}
	return $links;
}
add_filter( 'plugin_action_links', 'event_regis_filter_plugin_actions', 10, 2 );


function add_event_registration_menus() {

    add_menu_page('PayPal Events Registration', 'Event Manager', 8, __FILE__, 'event_regis_main_mnu', EVNT_RGR_PLUGINFULLURL.'images/events_icon_16.png');
	add_submenu_page(__FILE__, 'Configure Organization', 'Configure Organization', 8,  __FILE__, 'event_regis_main_mnu');
    add_submenu_page(__FILE__, 'Event Setup', 'Event Setup', 8, 'events', 'event_regis_manage_events');
	add_submenu_page(__FILE__, 'Manage Event Categories', 'Event Categories', 8, 'event_categories', 'event_regis_categories_config_mnu');
	add_submenu_page(__FILE__, 'Regform Setup', 'Regform Setup', 8, 'form', 'event_form_config');
	//add_submenu_page(__FILE__, 'View Attendees', 'View Attendees', 8, 'attendees', 'event_registration_reports');
	add_submenu_page(__FILE__, 'Attendees/Payments', 'Attendees/Payments', 8, 'admin_reports', 'event_admin_reports');
	add_submenu_page(__FILE__, 'Help/Support', 'Help/Support', 8, 'support', 'event_regis_support');
}

//ADMIN MENU
add_action('admin_menu', 'add_event_registration_menus');

 
// Enable the ability for the event_funct to be loaded from pages
add_filter('the_content','event_regis_insert');
add_filter('the_content','event_regis_attendees_insert');
add_filter('the_content','event_regis_pay_insert');
add_filter('the_content','event_paypal_txn_insert');

// Function to deal with loading the events into pages
function event_regis_insert($content)
		{
			  if (preg_match('{EVENTREGIS}',$content))
			    {
			      $content = str_replace('{EVENTREGIS}',event_regis_run(),$content);
			    }
			  return $content;
		}
		
function event_regis_attendees_insert($content)
		{
			  if (preg_match('{EVENTATTENDEES}',$content))
			    {
			      $content = str_replace('{EVENTATTENDEES}',event_attendee_list_run(),$content);
			    }
			  return $content;
		}		
		

function event_regis_pay_insert($content)
		{
			  if (preg_match('{EVENTREGPAY}',$content))
			    {
			      $content = str_replace('{EVENTREGPAY}',event_regis_pay(),$content);
			    }
			
			 return $content;
		}

	
function event_paypal_txn_insert($content)
		{
			  if (preg_match('{EVENTPAYPALTXN}',$content))
			    {
			      $content = str_replace('{EVENTPAYPALTXN}',event_paypal_txn(),$content);
			    }
			  return $content;
		}
		
/*********Shortcode support starts here************/

// [SINGLEEVENT single_event_id="your_event_identifier"]
function show_single_event($atts) {
	extract(shortcode_atts(array('single_event_id' => 'No ID Supplied'), $atts));
	$single_event_id = "{$single_event_id}";
	register_attendees($single_event_id);
}
add_shortcode('SINGLEEVENT', 'show_single_event');

// [EVENT_REGIS_CATEGORY event_category_id="your_category_identifier"]
function show_event_category($atts) {
	extract(shortcode_atts(array('event_category_id' => 'No Category ID Supplied'), $atts));
	$event_category_id = "{$event_category_id}";
	display_event_regis_categories($event_category_id);
}
add_shortcode('EVENT_REGIS_CATEGORY', 'show_event_category');



/*********Shortcode support ends here************/

//Date formatting function starts here
function event_date_display($date){	
	if (empty($date)){
		echo '<span style="color:red;">NO DATE SUPPLIED</span>';
	}else{
		list($year, $month, $day) = split("-", $date);
		$event_date_display = date('M d, Y', mktime(0, 0, 0, $month, $day, $year));
	}
	return $event_date_display;
}

	
//Run the program
function event_regis_run(){
	
global $wpdb;
$events_attendee_tbl = get_option('events_attendee_tbl');
$events_detail_tbl = get_option('events_detail_tbl');
	
	$org_options = get_option('events_organization_settings');
	$events_listing_type =$org_options['events_listing_type'];
	$event_page_id =$org_options['event_page_id'];

	if ($events_listing_type == ""){ echo "<br><br><strong>Please setup Organization in the Admin Panel!<br><br></strong>";}
	if ($events_listing_type == 'single'){
		if ($_REQUEST['regevent_action'] == "post_attendee"){add_attedees_to_db();}
		else if ($_REQUEST['regevent_action'] == "pay"){event_regis_pay();} //Linked to from confirmation email
		else if ($_REQUEST['regevent_action'] == "register"){register_attendees();}
		else if ($_REQUEST['regevent_action'] == "paypal_txn"){event_regis_paypal_txn();} //Runs the paypal transaction
		else if ($regevent_action == "process"){}
		else {register_attendees();}
	}

	if ($events_listing_type == 'all'){
		if ($_REQUEST['regevent_action'] == "post_attendee"){add_attedees_to_db();}
		else if ($_REQUEST['regevent_action'] == "pay"){event_regis_pay();}
		else if ($_REQUEST['regevent_action'] == "register"){register_attendees();}
		else if ($_REQUEST['regevent_action'] == "paypal_txn"){process_paypal_txn();}
		else if ($regevent_action == "process"){}
		else {display_all_events();}
	}
}

function event_form_build(&$question, $answer="") {
	$required = '';
	if ($question->required == "Y") {
		$required = ' class="r"';
	}
	switch ($question->question_type) {
		case "TEXT":
			echo "<input type=\"text\"$required id=\"TEXT-$question->id\"  name=\"TEXT-$question->id\" size=\"40\" title=\"$question->question\" value=\"$answer\" />\n";
			break;

		case "TEXTAREA":
			echo "<textarea id=\"TEXTAREA-$question->id\"$required name=\"TEXTAREA-$question->id\" title=\"$question->question\" cols=\"30\" rows=\"5\">$answer</textarea>\n";
			break;

		case "SINGLE":
			$values = explode(",", $question->response);
			$answers = explode(",", $answer);

			foreach ($values as $key => $value) {
				$checked = in_array($value, $answers)? " checked=\"checked\"": "";
				echo "<label><input id=\"MULTIPLE-$question->id-$key\"$required name=\"SINGLE-$question->id\" title=\"$question->question\" type=\"radio\" value=\"$value\"$checked /> $value</label><br/>\n";
			}
			break;

		case "MULTIPLE":
			$values = explode(",", $question->response);
			$answers = explode(",", $answer);
			foreach ($values as $key => $value) {
				$checked = in_array($value, $answers)? " checked=\"checked\"": "";
				echo "<label><input type=\"checkbox\"$required id=\"MULTIPLE-$question->id-$key\" name=\"MULTIPLE-$question->id-$key\" title=\"$question->question\" value=\"$value\"$checked /> $value</label><br/>\n";
			}
			break;
			
		case "DROPDOWN":
			$values = explode(",", $question->response);
			$answers = $answer;
			echo "<select name=\"DROPDOWN-$question->id-$key\" id=\"DROPDOWN-$question->id-$key\" title=\"$question->question\" /><br>";
			foreach ($values as $key => $value) {
				$checked = in_array($value, $answers)? " selected =\" selected\"": "";
				echo "<option value=\"$value\" selected=\"$checked\" /> $value</option><br/>\n";
			}
			echo "</select>";
			break;	
			

		default:
			break;
	}
}


function add_attedees_to_db(){
			 global $wpdb;
			
			 $org_options = get_option('events_organization_settings');
				
						$Organization =$org_options['organization'];
						$Organization_street1 =$org_options['organization_street1'];
						$Organization_street2=$org_options['organization_street2'];
						$Organization_city =$org_options['organization_city'];
						$Organization_state=$org_options['organization_state'];
						$Organization_zip =$row['organization_zip'];
						$contact =$org_options['contact_email'];
						$registrar = $org_options['contact_email'];
						$paypal_id =$org_options['paypal_id'];
						$paypal_cur =$org_options['currency_format'];
						$return_url = $org_options['return_url'];
						$cancel_return = $org_options['cancel_return'];
						$notify_url = $org_options['notify_url'];
						$events_listing_type =$org_options['events_listing_type'];
						$default_mail=$org_options['default_mail'];
						$conf_message =$org_options['message'];
						
			 $events_attendee_tbl = get_option('events_attendee_tbl');

			   $fname = $_POST['fname'];
			   $lname = $_POST['lname'];
			   $address = $_POST['address'];
			   $city = $_POST['city'];
			   $state = $_POST['state'];
			   $zip = $_POST['zip'];
			   $phone = $_POST['phone'];
			   $email = $_POST['email'];
			   $hear = $_POST['hear'];
			   $num_people = $_POST ['num_people'];
			   $event_id=$_POST['event_id'];
			   $payment = $_POST['payment'];
			  
			  $wpdb->query($wpdb->prepare("INSERT INTO ".$events_attendee_tbl." (lname ,fname ,address ,city ,state ,zip ,email ,phone ,hear, quantity, payment, event_id ) VALUES ('$lname', '$fname', '$address', '$city', '$state', '$zip', '$email', '$phone', '$hear','$num_people', '$payment',  '$event_id')")); 
			
			$attendee_id = $wpdb->get_var("SELECT LAST_INSERT_ID()");
			
			// Insert Extra From Post Here
			$events_question_tbl = get_option('events_question_tbl');
			$events_answer_tbl = get_option('events_answer_tbl');
			
			
				$questions = $wpdb->get_results("SELECT * from `$events_question_tbl` where event_id = '$event_id'");
				if ($questions) {
					foreach ($questions as $question) {
						switch ($question->question_type) {
							case "TEXT":
							case "TEXTAREA":
							case "SINGLE":
								$post_val = $_POST[$question->question_type . '-' . $question->id];
								$wpdb->query($wpdb->prepare("INSERT into `$events_answer_tbl` (registration_id, question_id, answer)
									values ('$attendee_id', '$question->id', '$post_val')"));
								break;
							case "MULTIPLE":
								$values = explode(",", $question->response);
								$value_string = '';
								foreach ($values as $key => $value) {
									$post_val = $_POST[$question->question_type . '-' . $question->id . '-' . $key];
									if ($key > 0 && !empty($post_val))
										$value_string .= ',';
									$value_string .= $post_val;
								}
								$wpdb->query($wpdb->prepare("INSERT into `$events_answer_tbl` (registration_id, question_id, answer)
									values ('$attendee_id', '$question->id', '$value_string')"));
								break;
						}
						
					}
				}		 
			
					$events_detail_tbl = get_option('events_detail_tbl');
					$sql = "SELECT * FROM ". $events_detail_tbl ." WHERE id='".$event_id."'";
					$result = mysql_query($sql);
					while ($row = mysql_fetch_assoc ($result)){
						$event_name=$row['event_name'];
						$event_desc=$row['event_desc']; // BHC
						$display_desc=$row['display_desc'];
						$event_identifier=$row['event_identifier'];
						$reg_limit = $row['reg_limit'];
						$cost=$row['event_cost'];
						$start_time = $row['start_time'];
						$end_time = $row['end_time'];
						$active=$row['is_active'];

						$send_mail= $row['send_mail'];
						$conf_mail= $row['conf_mail'];
						$start_date =  $row['start_date'];
						$end_date =  $row['end_date'];
					}
						$headers = "MIME-Version: 1.0\r\n";
						$headers .= "From: " . $Organization . " <". $contact . ">\r\n";
						$headers .= "Reply-To: " . $Organization . "  <" . $contact . ">\r\n";
						$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

						   
					// Email Confirmation to Registrar
			
						$distro=$registrar;
						$message=("$fname $lname has signed up on-line for $event_name.\n\nEmail address is  $email.");
						
						wp_mail($distro, $event_name, $message, $headers); 
						
						//Email Confirmation to Attendee
						
				$payment_link = get_option('siteurl') . "/?page_id=" . $return_url . "&id=".$attendee_id;
				
						//Email Confirmation to Attendee
				$SearchValues = array(
						"[fname]",
						"[lname]",
						"[phone]",
						"[event]",
						"[description]",
						"[cost]",
						"[qst1]",
						"[qst2]",
						"[qst3]",
						"[qst4]",
						"[contact]",
						"[company]",
						"[co_add1]",
						"[co_add2]",
						"[co_city]",
						"[co_state]",
						"[co_zip]",
						"[payment_url]",
						"[start_date]",
						"[start_time]",
						"[end_date]",
						"[end_time]");
						
				$ReplaceValues = array(
						$fname,
						$lname,
						$phone,
						$event_name,
						$event_desc,		
						$cost,
						$question1,
						$question2,
						$question3,
						$question4,
						$contact,
						$Organization,
						$Organization_street1,
						$Organization_street2,
						$Organization_city,
						$Organization_state,
						$Organization_zip,
						$payment_link,
						$start_date,
						$start_time,
						$end_date,
						$end_time);
				

			$custom = str_replace($SearchValues, $ReplaceValues, $conf_mail);
			$default_replaced = str_replace($SearchValues, $ReplaceValues, $conf_message);			
			
			$distro="$email";
			
			
			$message_top = "<html><body>"; 
			$message_bottom = "</html></body>";
			$email_body = $message_top.$custom.$message_bottom;
			//wp_mail($payer_email,$subject,$body,$headers);
			
			if ($default_mail =='Y'){ if($send_mail == 'Y'){ wp_mail($distro, $event_name, html_entity_decode($email_body), $headers);}}
			
			if ($default_mail =='Y'){ if($send_mail == 'N'){ wp_mail($distro, $event_name, $default_replaced, $headers);}}


		//Get registrars id from the data table and assign to a session variable for PayPal.

			$query  = "SELECT * FROM $events_attendee_tbl WHERE id = '".$attendee_id."'";
	   		$result = mysql_query($query) or die('Error : ' . mysql_error());
	   		while ($row = mysql_fetch_assoc ($result))
				{
	  		    //$attendee_id = $row['id'];
				$lname = $row['lname'];
				$fname = $row['fname'];
				$address = $row['address'];
				$city = $row['city'];
				$state = $row['state'];
				$zip = $row['zip'];
				$email = $row['email'];
				$phone = $row['phone'];
				$date = $row['date'];
				$payment_status = $row['payment_status'];
				$txn_type = $row['txn_type'];
				$amount_pd = $row['amount_pd'];
				$payment_date = $row['payment_date'];
				$event_id = $row['event_id'];
				}

			//update_option("attendee_id", $id);

			//Send screen confirmation & forward to paypal if selected.
			
			if ($cost== '' || $cost== ' ' || $cost== '0.00'){
				$event_message = '<p>This is a free event. Details have been sent to your email.</p>';
			}else{
				$event_message = '<p>Payment must be made to complete registration. Please click the button below to pay for your registration.</p>';
			}
?>
			<p>Your Registration data has been added to our records.</p>
            <?=$event_message?>
<?php			
			events_payment_page($event_id,$attendee_id);
			//echo $attendee_id;
		}


function view_attendee_list(){
	//Displays attendee information from current active event.
	global $wpdb;
	$events_detail_tbl = get_option('events_detail_tbl');
	$events_attendee_tbl = get_option('events_attendee_tbl');


	$sql = "SELECT * FROM ". $events_detail_tbl . " WHERE (is_active='yes' OR is_active='Y')";
		$result = mysql_query($sql);
		while ($row = mysql_fetch_assoc ($result)){
			$event_id = $row['id'];
			$event_name = $row['event_name'];
			$event_desc = $row['event_desc'];
			$event_description = $row['event_desc'];
			$event_identifier = $row['event_identifier'];
			$cost = $row['event_cost'];
			$active = $row['is_active'];
		}

	$sql  = "SELECT * FROM " . $events_attendee_tbl . " WHERE event_id='$event_id'";
	$result = mysql_query($sql);

	echo "<table>";
	while ($row = mysql_fetch_assoc ($result)){
		$id = $row['id'];
		$lname = $row['lname'];
		$fname = $row['fname'];
		$address = $row['address'];
		$city = $row['city'];
		$state = $row['state'];
		$zip = $row['zip'];
		$email = $row['email'];
		$phone = $row['phone'];
		$date = $row['date'];
		$payment_status = $row['payment_status'];
		$txn_type = $row['txn_type'];
		$amount_pd = $row['amount_pd'];
		$payment_date = $row['payment_date'];
		$event_id = $row['event_id'];
		
		echo "<tr><td align='left'>".$lname.", ".$fname."</td><td>".$email."</td><td>".$phone."</td>";
		echo "<td>";
		echo "<form name='form' method='post' action='".$_SERVER['REQUEST_URI']."'>";
		echo "<input type='hidden' name='attendee_action' value='edit'>";
		echo "<input type='hidden' name='attendee_id' value='".$id."'>";
		echo "<input type='SUBMIT' value='EDIT'></form>";
		echo "</td></tr>";
	}
	echo "</table>";
}

function attendee_display_edit(){
	edit_attendee_record();
	event_list_attendees();
}

// gets current URL to return to after donating
function get_event_regis_current_location() {
	$event_regis_current_location = "http";
	$event_regis_current_location .= ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') ? "s" : "")."://";
	$event_regis_current_location .= $_SERVER['SERVER_NAME'];
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') {
		if($_SERVER['SERVER_PORT']!='443') {
			$event_regis_current_location .= ":".$_SERVER['SERVER_PORT'];
		}
	}
	else {
		if($_SERVER['SERVER_PORT']!='80') {
			$event_regis_current_location .= ":".$_SERVER['SERVER_PORT'];
		}
	}
	$event_regis_current_location .= $_SERVER['REQUEST_URI'];
	echo $event_regis_current_location;
}

 function event_regis_admin_footer(){
?>
    <div style="clear:both">
</div>
<iframe src="http://shoultes.net/theme-admin.php" scrolling="no" frameborder="0" width="100%"></iframe>
<?php
}
function tep_not_null($value) {
    if (is_array($value)) {
      if (sizeof($value) > 0) { return true; } else { return false; }
    } else {
      if (($value != '') && (strtolower($value) != 'null') && (strlen(trim($value)) > 0)) 
			{ return true; } else { return false;  }
    }
  }
function tep_output_string($string, $translate = false, $protected = false) {
    if ($protected == true) {
      return htmlspecialchars($string);
    } else {
      if ($translate == false) {
        return tep_parse_input_field_data($string, array('"' => '&quot;'));
      } else {
        return tep_parse_input_field_data($string, $translate);
      }
    }
 }
 function tep_parse_input_field_data($data, $parse) {
    return strtr(trim($data), $parse);
 }
  
/*Turns an array into a select field*/
function select_input($name, $values, $default = '', $parameters = '') {
    $field = '<select name="' . tep_output_string($name) . '"';
    if (tep_not_null($parameters)) $field .= ' ' . $parameters;
    $field .= '>';

    if (empty($default) && isset($GLOBALS[$name])) $default = stripslashes($GLOBALS[$name]);

    for ($i=0, $n=sizeof($values); $i<$n; $i++) {
      $field .= '<option value="' . $values[$i]['id'] . '"';
      if ($default == $values[$i]['id']) {
        $field .= ' SELECTED';
      }

      $field .= '>' . $values[$i]['text'] . '</option>';
    }
    $field .= '</select>';    

    return $field;
 }

function event_regis_display_right_column (){
?>
<div id="event_regis-col-right">
<div class="box-right">
		<div class="box-right-head">
			<h3 class="fugue f-pro-version"><?php _e('Upgrade to Pro Version', 'event_regis'); ?></h3>
		</div>
		<div class="box-right-body">
			<div class="padding">
				<p>There are two ways to upgrade. <a href="http://wpplugins.com/plugin/73/events-registration-with-paypal-ipn" target="_blank">Upgrade to Pro Version at the WP Plugins App Store</a> or purchase directly from my <a href="http://shoultes.net/upgrade-to-pro-version/" target="_blank">website</a> using the button below.</p>
                <p align="center"><a class="ec_ejc_thkbx" onclick="javascript:return EJEJC_lc(this);" href="https://www.e-junkie.com/ecom/gb.php?c=cart&amp;i=AERPRO&amp;cl=113214&amp;ejc=2"><img style="border: 0pt none;" src="http://shoultes.net/wp-content/uploads/2010/04/add-to-cart.gif" border="0" alt="Add to Cart" width="90" height="29" /></a> <a class="ec_ejc_thkbx" onclick="javascript:return EJEJC_lc(this);" href="https://www.e-junkie.com/ecom/gb.php?c=cart&amp;cl=113214&amp;ejc=2"><img style="border: 0pt none;" src="http://shoultes.net/wp-content/uploads/2010/04/checkout-button.gif" border="0" alt="View Cart" width="90" height="30" /></a><script type="text/javascript">// <![CDATA[
      function EJEJC_lc(th) { return false; }
// ]]></script>
<script src="http://www.e-junkie.com/ecom/box.js" type="text/javascript"></script></p>
<p><a href="http://shoultes.net/upgrade-to-pro-version/" target="_blank">More Information</a></p>
			</div>
		</div>
	</div>
<div class="box-right">
		<div class="box-right-head">
			<h3 class="fugue f-megaphone"><?php _e('New @ Shoultes.net', 'event_regis'); ?></h3>
		</div>
		<div class="box-right-body">
			<div class="padding">
				<ul class="infolinks">
					<?php // Get RSS Feed(s)
include_once(ABSPATH . WPINC . '/feed.php');
$rss = fetch_feed('http://shoultes.net/feed/rss/?cat=-1538');
$maxitems = $rss->get_item_quantity(3); 
$rss_items = $rss->get_items(0, $maxitems); 
?>
    <?php if ($maxitems == 0) echo '<li>No items.</li>';
    else
    // Loop through each feed item and display each item as a hyperlink.
    foreach ( $rss_items as $item ) : ?>
       <li> <a target="_blank" href='<?php echo $item->get_permalink(); ?>' title='<?php echo $item->get_title(); ?>'>
        	<?php echo $item->get_title(); ?>
		</a></li>
    <?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
	<div class="box-right">
		<div class="box-right-head">
			<h3 class="fugue f-info-frame"><?php _e('Helpful Plugin Links', 'event_regis'); ?></h3>
		</div>
		<div class="box-right-body">
			<div class="padding">
				<ul class="infolinks">
					<li><a href="http://shoultes.net/wordpress-events-registration-with-paypal-ipn/" target="_blank"><?php _e('Installation &amp; Usage Guide', 'event_regis'); ?></a></li>
					<li><a href="http://shoultes.net/wordpress-events-registration-with-paypal-ipn/" target="_blank"><?php _e('Frequently Asked Questions', 'event_regis'); ?></a></li>
					<li><a href="http://shoultes.net/bug-submission/" target="_blank"><?php _e('Bug Submission Form', 'event_regis'); ?></a></li>
					<li><a href="http://shoultes.net/feature-request/" target="_blank"><?php _e('Feature Request Form', 'event_regis'); ?></a></li>
					
				</ul>
			</div>
		</div>
	</div>
	<div class="box-right event_regisdonation-box" id="event_regis_donations_box">
		<div class="box-right-head">
			<h3 class="fugue f-money"><?php _e('Support by Donating', 'event_regis'); ?></h3>
		</div>
		<div class="box-right-body">
			<div class="padding">
				<p><?php _e("If you like Advanced Events Registration and wish to contribute towards it's continued development, you can use the form below to do so.", "event_regis"); ?></p>
				<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
					<input type="hidden" name="cmd" value="_donations" />
					<input type="hidden" name="business" value="seth@smartwebutah.com" />
					<input type="hidden" name="item_name" value="<?php _e('Advanced Events Registration Development Support' , 'event_regis'); ?>" />
					<input type="hidden" name="no_shipping" value="0">
					<input type="hidden" name="no_note" value="0">
					<input type="hidden" name="cn" value="<?php _e("Please enter the URL you'd like me to link to if you are a top contributor.", "event_regis"); ?>" />
					<input type="hidden" name="return" value="<?php get_event_regis_current_location(); ?>" />
					<input type="hidden" name="cbt" value="<?php _e('Return to Your Dashboard' , 'event_regis'); ?>" />
					<input type="hidden" name="currency_code" value="USD">
					<input type="hidden" name="lc" value="US">
					<input type="hidden" name="bn" value="PP-BuyNowBF">
					<label><?php _e('Select Preset Amount? ', 'event_regis'); ?>
					<span>$</span> <select name="amount" id="preset-amounts">
						<option value="10">10</option>
						<option value="20" selected>20</option>
						<option value="30">30</option>
						<option value="40">40</option>
						<option value="50">50</option>
						<option value="100">100</option>
						<option value="200">200</option>
						<option value="300">300</option>
						<option value="400">400</option>
						<option value="500">500</option>
					</select> <span>USD</span></label><br /><br />
					<label><?php _e('Enter Custom Amount?', 'event_regis'); ?> <span>$</span> <input type="text" name="amount" size="4" id="custom-amounts"> <span>USD</span></label>
					<br /><br />
					<input type="submit" value="Pay with PayPal!" class="payment">
				</form>
			</div>
		</div>
	</div>
	<div class="box-right">
		<div class="box-right-head">
			<h3 class="fugue f-info-frame"><?php _e('Sponsors', 'event_regis'); ?></h3>
		</div>
		<div class="box-right-body">
			<div class="padding"> <?php
					$event_regis_sponsors = wp_remote_retrieve_body( wp_remote_get('http://shoultes.net/plugin-sponsors.php') );
					echo $event_regis_sponsors;
				?>
            </div>
		</div>
	</div>
</div>
<?php 
}
//Export data to Excel file
switch ($_REQUEST['export']) {
 case "report";
	global $wpdb;
	
	$id= $_REQUEST['id'];
	$events_attendee_tbl = $_REQUEST['atnd'];
	$today = date("Y-m-d_Hi",time()); 
	
	$events_answer_tbl = get_option('events_answer_tbl');
	$events_question_tbl = get_option('events_question_tbl');
	$events_detail_tbl = get_option('events_detail_tbl');
	$events_attendee_tbl = get_option('events_attendee_tbl');
	$sql  = "SELECT * FROM " . $events_detail_tbl . " WHERE id='$id'";
	$result = mysql_query($sql);
	list($event_id, $event_name, $event_description, $event_identifier, $event_cost, $is_active) = mysql_fetch_array($result, MYSQL_NUM);
	switch ($_REQUEST['action']) {
		case "excel";
					$st = "";
				$et = "\t";
				$s = $et . $st;
		
				$basic_header = array('Reg ID', 'Last Name', 'First Name', 'Email', 'Address', 
						'City', 'State', 'Zip', 'Phone', 'Payment Method', 'Reg Date');
				$question_sequence = array();


				$questions = $wpdb->get_results("select question, sequence from ".$events_question_tbl." where event_id = '$event_id' order by sequence");
				foreach ($questions as $question) {
					array_push($basic_header, $question->question);
					array_push($question_sequence, $question->sequence);
				}
	
				$participants = $wpdb->get_results("SELECT * from $events_attendee_tbl where event_id = '$event_id'");
				$filename = $event_name."-Attendees_". $today . ".xls";
			
			  header("Content-Disposition: attachment; filename=\"$filename\"");
			  header("Content-Type: application/vnd.ms-excel");
			  header("Pragma: no-cache"); 
			  header("Expires: 0"); 
	
				//echo header
				echo implode($s, $basic_header) . $et . "\r\n";
	
				//echo data
				if ($participants) {
					foreach ($participants as $participant) {
						echo $participant->id
						. $s . $participant->lname
						. $s . $participant->fname
						. $s . $participant->email
						. $s . $participant->address
						. $s . $participant->city
						. $s . $participant->state
						. $s . $participant->zip
						. $s . $participant->phone
						. $s . $participant->payment
						. $s . $participant->date;
						$answers = $wpdb->get_results("select a.answer from ".$events_answer_tbl." a join ".$events_question_tbl." q on   q.id = a.question_id where registration_id = '$participant->id' order by q.sequence");
		
						foreach($answers as $answer) {
							echo $s . $answer->answer;
						}
		
						echo $et . "\r\n";
					}
				} else {
					echo "<tr><td>No participant data has been collected.</td></tr>";
				}
				exit;
		break;
		
		case "payment";
				$st = "";
				$et = "\t";
				$s = $et . $st;

				$basic_header = array('Reg ID', 'Last Name', 'First Name', 'Email', 'Address', 'City', 'State', 'Zip', 'Phone', 'Payment Method', 'Reg Date', 'Pay Status', 'Type of Payment', 'Transaction ID', 'Payment', '# Attendees', 'Date Paid', 'Answers' );
				$question_sequence = array();
				
	
				$participants = $wpdb->get_results("SELECT * from $events_attendee_tbl where event_id = '$event_id'");
				$filename = $event_name."-Payments_". $today . ".xls";
			
			  header("Content-Disposition: attachment; filename=\"$filename\"");
			  header("Content-Type: application/vnd.ms-excel");
			  header("Pragma: no-cache"); 
			  header("Expires: 0"); 
	
				//echo header
				echo implode($s, $basic_header) . $et . "\r\n";
	
				//echo data
				if ($participants) {
					foreach ($participants as $participant) {
						echo $participant->id
						. $s . $participant->lname
						. $s . $participant->fname
						. $s . $participant->email
						. $s . $participant->address
						. $s . $participant->city
						. $s . $participant->state
						. $s . $participant->zip
						. $s . $participant->phone
						. $s . $participant->payment
						. $s . $participant->date
						. $s . $participant->payment_status
						. $s . $participant->txn_type
						. $s . $participant->txn_id
						. $s . $participant->amount_pd
						. $s . $participant->quantity
						. $s . $participant->payment_date
						;
						$answers = $wpdb->get_results("select a.answer from ".$events_answer_tbl." a join ".$events_question_tbl." q on   q.id = a.question_id where registration_id = '$participant->id' order by q.sequence");	
						foreach($answers as $answer) {
							echo $s . $answer->answer;
						}
		
						echo $et . "\r\n";
					}
				} else {
					echo "<tr><td>No participant data has been collected.</td></tr>";
				}
				exit;
		break;
		
		default:
		echo "This Is Not A Valid Selection!";
		break;
	}
	
	default:
	break;
}

function event_regis_activation_notice(){
		if(function_exists('admin_url')){
						echo '<div class="error fade"><p><strong>Advanced Events Registration must be configured. Go to <a href="' . admin_url( 'options-general.php?page=advanced-events-registration/event_regis.php#page_settings' ) . '">the Organization Settings page</a> to configure the plugin "Page Settings."</strong></p></div>';
		}else{
				echo '<div class="error fade" ><p><strong>Advanced Events Registration must be configured. Go to <a href="' . get_option('siteurl') . 'options-general.php?page=advanced-events-registration/event_regis.php#page_settings' . '">the Organization Settings page</a> to configure the plugin "Page Settings."</strong></p></div>';
		}
}
$org_options = get_option('events_organization_settings');
if($_POST['event_page_id'] == null && ($org_options['event_page_id']=='0' || $org_options['return_url']=='0' || $org_options['notify_url']=='0')){
	add_action( 'admin_notices', 'event_regis_activation_notice');
	}