<?php
//Event Registration Subpage 1 - Configure Organization
function organization_config_mnu()	{

		global $wpdb;
		$events_attendee_tbl = get_option('events_attendee_tbl');
		$events_detail_tbl = get_option('events_detail_tbl');

	if (isset($_POST['update_org'])) {
		$org_options = get_option('events_organization_settings');
		//$org_options = $_POST['org_settings'];
		$org_options['organization'] = $_POST['org_name'];
		$org_options['organization_street1'] = $_POST['org_street1'];
		$org_options['organization_street2'] = $_POST['org_street2'];
		$org_options['organization_city'] = $_POST['org_city'];
		$org_options['organization_state'] = $_POST['org_state'];
		$org_options['organization_zip'] = $_POST['org_zip'];
		$org_options['contact_email'] = $_POST['email'];
		$org_options['paypal_id'] = $_POST['paypal_id'];
		$org_options['currency_format'] = $_POST['currency_format'];
		$org_options['events_listing_type'] = $_POST['events_listing_type'];
		$org_options['event_page_id'] = $_POST['event_page_id'];
		$org_options['return_url'] = $_POST['return_url'];
		$org_options['cancel_return'] = $_POST['cancel_return'];
		$org_options['notify_url'] = $_POST['notify_url'];
		$org_options['use_sandbox'] = $_POST['use_sandbox'];
		$org_options['image_url'] = $_POST['image_url'];
		$org_options['default_mail'] = $_POST['default_mail'];
		$org_options['payment_subject'] = htmlentities2($_POST['payment_subject']);
		$org_options['payment_message'] = htmlentities2($_POST['payment_message']);
		$org_options['message'] = htmlentities2($_POST['message']);
		switch ($org_options['currency_format']){
			case 'USD':
			case 'HKD':
			case 'NZD':
			case 'SGD':
			$org_options['currency_symbol'] = '$';
			break;
							
			case 'AUD':
			$org_options['currency_symbol'] = 'A $';
			break;
							
			case 'GBP':
			$org_options['currency_symbol'] = '&pound;';
			break;
							
			case 'CAD':
			$org_options['currency_symbol'] = 'C $';
			break;
							
			case 'EUR':
			$org_options['currency_symbol'] = '&#8364;';
			break;
							
			case 'JPY':
			$org_options['currency_symbol'] = '&yen;';
			break;
							
			default:
			$org_options['currency_symbol'] = '$';
			break;
	}
	
	update_option( 'events_organization_settings', $org_options);
	echo '<div id="message" class="updated fade"><p><strong>Organization details saved. Maybe you would consider making a <a href="http://www.shoultes.net/wordpress-events-registration-with-paypal-ipn#donate" target="_blank">donation</a>?</strong></p></div>';

}
?>

<div id="configure_organization_form" class=wrap>
  <div id="icon-options-event" class="icon32"><br />
  </div>
  <h2> Organization Settings</h2>
<div id="event_regis-col-left">
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>">
<ul id="event_regis-sortables">

			<li>
				<div class="box-mid-head">
					<h2 class="fugue f-wrench">Set up Your Organization to Recieve Payments</h2>
				</div>

				<div class="box-mid-body" id="toggle2">
					<div class="padding">
<?php 				
$org_options = get_option('events_organization_settings');?>
    <ul>
      <li>
        <label for="Organization">Organization Name:</label>
        <input name="org_name" type="text" size="45" value="<?php echo $org_options['organization'];?>">
      </li>
      <li>
        <label for="Organization_street1">Organization Street 1: </label>
        <input name="org_street1" type="text" size="45" value="<?php echo $org_options['organization_street1'];?>">
      </li>
      <li>
        <label for="Organization_street2">Organization Street 2:</label>
        <input name="org_street2" type="text" size="45" value="<?php echo $org_options['organization_street2'];?>">
      </li>
      <li>
        <label for="Organization_city">Organization City:</label>
        <input name="org_city" type="text" size="45" value="<?php echo $org_options['organization_city'];?>">
      </li>
      <li>
        <label Organization_state>Organization State:</label>
        <input name="org_state" type="text" size="3" value="<?php echo $org_options['organization_state'];?>">
      </li>
      <li>
        <label for="Organization_zip">Organization Zip Code:</label>
        <input name="org_zip" type="text" size="10" value="<?php echo $org_options['organization_zip'];?>">
      </li>
      <li>
        <label for="contact">Primary contact email:</label>
        <input name="email" type="text" size="45" value="<?php echo $org_options['contact_email'];?>">
      </li>
    </ul>
 
    </div></div>
    </li>
    <li><a name="page_settings" id="page_settings"></a><div class="box-mid-head">
					<h2 class="fugue f-money">Page Settings</h2>
				</div>
<div class="box-mid-body" id="toggle3">
  <div class="padding">
            <?php if(($_POST['event_page_id'] == null || $org_options['event_page_id']=='0' )&& ($org_options['event_page_id']=='0' || $org_options['return_url']=='0' || $org_options['notify_url']=='0')){ ?><p class="updated fade red_text" align="center"><strong>**Attention**</strong><br />
These settings are very important and must be configured for the plugin to function correctly. Visibility must be set to <span id="post-visibility-display">Public on all pages</span>. If you need help, please visit the <a href="admin.php?page=support">support</a> page or <a href="http://shoultes.net" target="_blank">shoultes.net</a> for more information and instructions.</p><?php }?>
         <p>Do you want to show a single event or all events on the registration page?<span>*</span>
      <select name='events_listing_type'>
        <option value="<?php echo $org_options['events_listing_type'];?>">
       <?php echo $org_options['events_listing_type'];?>
        </option>
        <option value='all'>All Events</option>
        <option value='single'>Single Event</option>
      </select>
    <a class="ev_reg-fancylink" href="#how_display_info"><img src="<?php echo EVNT_RGR_PLUGINFULLURL?>/images/question-frame.png" width="16" height="16" /></a></p>
    <div id="how_display_info" style="display:none">
      <h2>Event Listing Types</h2>
      <p>If set to "Single Event", only one event will be displayed on the page.</p> <p class="red_text">**Attention** Setting this option to "Single Event" will disable the "Event Registration Widget" and "SINGLEEVENT" shortcode functionality.</p>
    </div>            
		    <p>Main registration page:
      <select name="event_page_id">
        <option value="0">
        <?php _e ('Main page'); ?>
        </option>
        <?php parent_dropdown ($default=$org_options['event_page_id']); ?>
      </select>
    <a class="ev_reg-fancylink" href="#registration_page_info"><img src="<?php echo EVNT_RGR_PLUGINFULLURL?>/images/question-frame.png" width="16" height="16" /></a><br />
<font  size="-2">(This page should contain the <strong>{EVENTREGIS}</strong> shortcode. This page can be hidden from navigation, if desired.)</font></p>
    <div id="registration_page_info" style="display:none">
      <h2>Main Events Page</h2>
      <p>This is the page that displays your events.</p>
      <p>This page should contain the <strong>{EVENTREGIS}</strong> shortcode.</p>
    </div>
   
    <p><a href="https://www.paypal.com/cgi-bin/webscr?cmd=p/mer/express_return_summary-outside" title="Auto Return Overview" target="_blank">Auto Return URL</a> (used for return to make payments):
    <select name="return_url">
        <option value="0">
        <?php _e ('Main page'); ?>
        </option>
        <?php parent_dropdown ($default=$org_options['return_url']); ?>
      </select>
      <a class="ev_reg-fancylink" href="#return_url_info" target="_blank"><img src="<?php echo EVNT_RGR_PLUGINFULLURL?>/images/question-frame.png" width="16" height="16" /></a><br />
<font size="-2">(This page should contain the <strong>{EVENTREGPAY}</strong> shortcode. This page should hidden from your navigation.)</font></p>
    <div id="return_url_info" style="display:none">
      <h2>Auto Return URL</h2>
      <p>The URL to which the payer's browser is redirected after completing the payment; for example, a URL on your site that displays a "Thank you for your payment" page.</p>
      <p>This page should contain the <strong>{EVENTREGPAY}</strong> shortcode.</p>
      <p class="red_text"><strong>ATTENTION:</strong><br />This page should be hidden from from your navigation menu. Exclude pages by using the 'Exclude Pages' plugin from http://wordpress.org/extend/plugins/exclude-pages/ or using the 'exclude' parameter in your 'wp_list_pages' template tag. Please refer to http://codex.wordpress.org/Template_Tags/wp_list_pages for more inforamation about excluding pages.</p>
    </div>
    <p>Cancel Return URL (used for cancelled payments):
    <select name="cancel_return">
        <option value="0">
        <?php _e ('Main page'); ?>
        </option>
        <?php parent_dropdown ($default=$org_options['cancel_return']); ?>
      </select>
      <a class="ev_reg-fancylink" href="#cancel_return_info"><img src="<?php echo EVNT_RGR_PLUGINFULLURL?>/images/question-frame.png" width="16" height="16" /></a><br />
      <font  size="-2">(This should be a page on your website that contains a cancelled message. No short tags are needed. This page should hidden from your navigation.)</font></p>
    <div id="cancel_return_info" style="display:none">
      <h2>Cancel Return URL</h2>
      <p>A URL to which the payer's browser is redirected if payment is cancelled; for example, a URL on your website that displays a "Payment Canceled" page.</p>
      <p>This should be a page on your website that contains a cancelled message. No short tags are needed.</p>
      <p class="red_text"><strong>ATTENTION:</strong><br />This page should be hidden from from your navigation menu. Exclude pages by using the 'Exclude Pages' plugin from http://wordpress.org/extend/plugins/exclude-pages/ or using the 'exclude' parameter in your 'wp_list_pages' template tag. Please refer to http://codex.wordpress.org/Template_Tags/wp_list_pages for more inforamation about excluding pages.</p>
    </div>
    <p>Notify URL (used to process payments):
    <select name="notify_url">
        <option value="0">
        <?php _e ('Main page'); ?>
        </option>
        <?php parent_dropdown ($default=$org_options['notify_url']); ?>
      </select>
      <a class="ev_reg-fancylink" href="#notify_url_info"><img src="<?php echo EVNT_RGR_PLUGINFULLURL?>/images/question-frame.png" width="16" height="16" /></a><br />
      <font size="-2">(This page should contain the <strong>{EVENTPAYPALTXN}</strong> shortcode. This page should hidden from your navigation.)</font></p>
    <div id="notify_url_info" style="display:none">
      <h2>Notify URL</h2>
      <p>The URL to which PayPal posts information about the transaction, in the form of Instant Payment Notification messages.</p>
      <p>This page should contain the <strong>{EVENTPAYPALTXN}</strong> shortcode.</p>
      <p class="red_text"><strong>ATTENTION:</strong><br />This page should be hidden from from your navigation menu. Exclude pages by using the 'Exclude Pages' plugin from http://wordpress.org/extend/plugins/exclude-pages/ or using the 'exclude' parameter in your 'wp_list_pages' template tag. Please refer to http://codex.wordpress.org/Template_Tags/wp_list_pages for more inforamation about excluding pages.</p>
    </div>
  </div></div>
    <div id="sandbox_info" style="display:none">
      <h2>PayPal Sandbox</h2>
      <p>In addition to using the PayPal Sandbox fetaure. The debugging feature will also output the form varibales to the payment page, send an email to the admin that contains the all PayPal variables.</p>
      <hr />
      <p>The PayPal Sandbox is a testing environment that is a duplicate of the live PayPal site, except that no real money changes hands. The Sandbox allows you to test your entire integration before submitting transactions to the live PayPal environment. Create and manage test accounts, and view emails and API credentials for those test accounts.</p>
    </div>
   </li>
   
   <li><div class="box-mid-head">
					<h2 class="fugue f-money">PayPal Settings</h2>
				</div>
<div class="box-mid-body" id="toggle3">
					<div class="padding">

    <h3>Paypal I.D. </h3>
    <p>Typically payment@yourdomain.com - leave blank if you do not want to accept paypal:
      <br />
      <input name="paypal_id" type="text" size="45" value="<?php echo $org_options['paypal_id'];?>">
    </p>
    <p>
      <label for="currency_format">Select the <a href="https://www.paypal.com/cgi-bin/webscr?cmd=p/sell/mc/mc_receive-outside||https://www.paypal.com/cgi-bin/webscr?cmd=p/sell/mc/mc_convert-outside||https://www.paypal.com/cgi-bin/webscr?cmd=p/sell/mc/mc_wa-outside" title="Receiving Money||Currency Conversion||Website Payments" target="_blank">PayPal Currency</a> for your country:</label>
      <select name="currency_format">
        <option value="<?php echo $org_options['currency_format'];?>"><?php echo $org_options['currency_format'];?></option>
        <option value="USD">U.S. Dollars ($)</option>
        <option value="AUD">Australian Dollars (A $)</option>
        <option value="GBP">Pounds Sterling (&pound;)</option>
        <option value="CAD">Canadian Dollars (C $)</option>
        <option value="CZK">Czech Koruna</option>
        <option value="DKK">Danish Krone</option>
        <option value="EUR">Euros (&#8364;)</option>
        <option value="HKD">Hong Kong Dollar ($)</option>
        <option value="HUF">Hungarian Forint</option>
        <option value="ILS">Israeli Shekel</option>
        <option value="JPY">Yen (&yen;)</option>
        <option value="MXN">Mexican Peso</option>
        <option value="NZD">New Zealand Dollar ($)</option>
        <option value="NOK">Norwegian Krone</option>
        <option value="PLN">Polish Zloty</option>
        <option value="SGD">Singapore Dollar ($)</option>
        <option value="SEK">Swedish Krona</option>
        <option value="BRL">Brazilian Real (only for Brazilian users)</option>
        <option value="MYR">Malaysian Ringgits (only for Malaysian users)</option>
        <option value="PHP">Philippine Pesos</option>
        <option value="TWD">Taiwan New Dollars</option>
        <option value="THB">Thai Baht</option>
      </select>
      <a class="ev_reg-fancylink" href="#paypal_currency_info"><img src="<?php echo EVNT_RGR_PLUGINFULLURL?>/images/question-frame.png" width="16" height="16" /></a> </p>
    <div id="paypal_currency_info" style="display:none">
      <h2>PayPal Currency Settings</h2>
      <p>Now you can accept payments on your website in any of the currencies supported by PayPal through the Multiple Currencies feature.</p>
      <p>PayPal launched Multiple Currencies to facilitate payments among our diverse base of international members. PayPal is pleased to offer conversion rates that are competitive with those of other consumer services.</p>
    </div>
    <p>Image URL (used for your personal logo on the PayPal page):
      <br />
      <input name="image_url" size="45" type="text" value="<?php echo $org_options['image_url'];?>" />
    <a class="ev_reg-fancylink" href="#image_url_info"><img src="<?php echo EVNT_RGR_PLUGINFULLURL?>/images/question-frame.png" width="16" height="16" /></a></p>
    <div id="image_url_info" style="display:none">
      <h2>PayPal Image URL (logo for PayPal page)</h2>
      <p>The URL of the 150x50-pixel image displayed as your logo in the upper left corner of the PayPal checkout pages.</p>
      <p>Default - Your business name, if you have a Business account, or your email address, if you have Premier or Personal account.</p>
    </div>
    <p>Use the debugging feature and the <a href="https://developer.paypal.com/devscr?cmd=_home||https://cms.paypal.com/us/cgi-bin/?&amp;cmd=_render-content&amp;content_ID=developer/howto_testing_sandbox||https://cms.paypal.com/us/cgi-bin/?&amp;cmd=_render-content&amp;content_ID=developer/howto_testing_sandbox_get_started" title="PayPal Sandbox Login||Sandbox Tutorial||Getting Started with PayPal Sandbox" target="_blank">PayPal Sandbox</a>?
      &nbsp;&nbsp;
      <input name="use_sandbox" type="checkbox" value="1" <?php echo $org_options['use_sandbox'] == "1" ? 'checked="checked"':'' ?> />
    
      &nbsp;<a class="ev_reg-fancylink" href="#sandbox_info"><img src="<?php echo EVNT_RGR_PLUGINFULLURL?>/images/question-frame.png" width="16" height="16" /></a></p>
      </div></div>
    <div id="sandbox_info" style="display:none">
      <h2>PayPal Sandbox</h2>
      <p>In addition to using the PayPal Sandbox fetaure. The debugging feature will also output the form varibales to the payment page, send an email to the admin that contains the all PayPal variables.</p>
      <hr />
      <p>The PayPal Sandbox is a testing environment that is a duplicate of the live PayPal site, except that no real money changes hands. The Sandbox allows you to test your entire integration before submitting transactions to the live PayPal environment. Create and manage test accounts, and view emails and API credentials for those test accounts.</p>
    </div>
   </li>
     <li> 
     				<div class="box-mid-head">

					<h2 class="fugue f-footer">Email Settings</h2>
				</div>
				<div class="box-mid-body" id="toggle5">
					<div class="padding">

      <p>Do You Want To Send Payment Confirmation Emails? 
      <input name="default_mail" type="checkbox" value="Y" <?php echo $org_options['default_mail'] == "Y" ? 'checked="checked"':'' ?> /><br />
       (This option must be enable to send custom mails in events)
      </p>
      <div style="clear:both;"></div>
    <div style="width:400px;float:left"><h3>Payment Confirmation Email: </h3>
      <p>Email Subject: <input name="payment_subject" type="text" value="<?php echo $org_options['payment_subject'];?>" /></p>
      <p>Email Body:<br />
        <textarea rows="5" cols="300" name="payment_message" id="payment_message"  class="my_ed"><?php echo $org_options['payment_message'];?></textarea>
        <br />
        <script>myEdToolbar('payment_message'); </script>
      </p>
      
      <h3>Default Registration Confirmation Email </h3>
      <p><a class="ev_reg-fancylink" href="#custom_email_settings">Settings</a> | <a class="ev_reg-fancylink" href="#custom_email_example">Example</a></p>
      <p>Email Body: <br />
      <textarea rows="5" cols="300" name="message" id="success_message"  class="my_ed"><?php echo $org_options['message'];?></textarea>
        <br />
        <script>myEdToolbar('success_message'); </script>
      </p>
    </div>
    
    <input type="hidden" name="update_org" value="update">
    <div style="clear:both;"></div>
 </div>
 </div>
  </li>
  </ul>
  <p>
      <input class="button-primary" type="submit" name="Submit" value="<?php _e('Save Options'); ?>" id="save_organization_setting" />
    </p>
   </form>
</div>
<?php event_regis_display_right_column ();?>
<div id="custom_email_settings" style="display:none">
      <h2>Email Settings</h2><p><strong>Email Confirmations:</strong><br>
For customized confirmation emails, the following tags can be placed in the email form and they will pull data from the database to include in the email.</p>
<p>[fname], [lname], [phone], [event],[description], [cost], [company], [co_add1], [co_add2], [co_city],[co_state], [co_zip],[contact], [payment_url], [start_date], [start_time], [end_date], [end_time]</p>
    </div>
    
    <div id="custom_email_example" style="display:none">
      <h2>Sample Mail Send:</h2>

<p>***This is an automated response - Do Not Reply***</p>
<p>Thank you [fname] [lname] for registering for [event]. We hope that you will find this event both informative and enjoyable. Should have any questions, please contact [contact].</p>
<p>If you have not done so already, please submit your payment in the amount of [cost].</p>
<p>Click here to review your payment information [payment_url].</p>
<p>Thank You.</p>
    </div>
<?php
event_regis_admin_footer();
}
?>
