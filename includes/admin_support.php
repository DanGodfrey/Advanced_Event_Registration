<?php 
function event_regis_support(){
?>
<div id="event_reg_theme" class="wrap">
<div id="icon-options-event" class="icon32"></div><h2>Help and Support</h2>

<?php if ($_REQUEST['action'] == "update_event_dates"){update_event_start_date_fields();}?>
<div id="event_regis-col-left">
<ul id="event_regis-sortables">
<li>
<div class="box-mid-head">
<h2>Contact Support</h2>
</div>
<div class="box-mid-body" id="toggle1">
					<div class="padding">
<p>If you are having any problems that are not discussed here, suggestions, comments or gripes please visit <a href="http://shoultes.net/wordpress-events-registration-with-paypal-ipn/" target="_blank">Shoultes.net</a>, <a href="http://wordpress.org/tags/events-registration-with-paypal-ipn?forum_id=10" target="_blank">visit this plugins forum </a>or feel free to send me an <a href="mailto:seth@smartwebutah.com">email</a>. If you would like to hire me for a web project, please feel free to use one of the methods below.</p>
<table width="58%" border="0">
  <tr>
   <td width="51%" align="center"><a href="http://www.youtube.com/watch?v=sXu4Ecmx50A" target="_blank"><img src="<?php echo  EVNT_RGR_PLUGINFULLURL; ?>images/YouTube-Video.gif" alt="You Tube Video" width="220" height="132" border="0" /><br />
      Video Instructions</a></td>
      
    <td width="51%" align="center"><!-- http://www.LiveZilla.net Chat Button Link Code --><div style="text-align:center;width:191px;"><a href="javascript:void(window.open('http://www.shoultes.net/support/livezilla.php','','width=590,height=550,left=0,top=0,resizable=yes,menubar=no,location=no,status=yes,scrollbars=yes'))"><img src="http://www.shoultes.net/support/image.php?id=02" width="191" height="69" border="0" alt="LiveZilla Live Help"></a><noscript><div><a href="http://www.shoultes.net/support/livezilla.php" target="_blank">Start Live Help Chat</a></div></noscript><div style="margin-top:2px;"><a href="http://www.livezilla.net" target="_blank" title="LiveZilla Live Help" style="font-size:10px;color:#bfbfbf;text-decoration:none;font-family:verdana,arial,tahoma;">LiveZilla Live Help</a></div></div><!-- http://www.LiveZilla.net Chat Button Link Code --><!-- http://www.LiveZilla.net Tracking Code --><div id="livezilla_tracking" style="display:none"></div><script type="text/javascript">var script = document.createElement("script");script.type="text/javascript";var src = "http://www.shoultes.net/support/server.php?request=track&output=jcrpt&nse="+Math.random();setTimeout("script.src=src;document.getElementById('livezilla_tracking').appendChild(script)",1);</script><!-- http://www.LiveZilla.net Tracking Code --></td>
    <td width="49%" align="center"><object type="application/x-shockwave-flash" data="https://clients4.google.com/voice/embed/webCallButton" width="230" height="85"><param name="movie" value="https://clients4.google.com/voice/embed/webCallButton" /><param name="wmode" value="transparent" /><param name="FlashVars" value="id=1717fddb5cce6e35c6788ebbe25b8e653445f2a5&style=0" /></object></td>
  </tr>
</table>
</div>
</div>
</li>
<li><div class="box-mid-head">
<h2>Donations and Reviews</h2>
</div>
<div class="box-mid-body" id="toggle2">
					<div class="padding">
<p>If you find this plugin useful and profitable, please consider making a <a href="http://shoultes.net/wordpress-events-registration-with-paypal-ipn/" target="_blank">donation</a>, give this plugin a <a href="http://wordpress.org/extend/plugins/events-registration-with-paypal-ipn/" target="_blank">good review</a> or upgrade to the <a href="http://shoultes.net/upgrade-to-pro-version/" target="_blank">Pro Version</a>.</p>

<table width="60%" border="0">
  <tr>
    <td><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="10464587">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<p><img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1"></p>
</form></td>
    <td><a class="ec_ejc_thkbx" onclick="javascript:return EJEJC_lc(this);" href="https://www.e-junkie.com/ecom/gb.php?c=cart&amp;i=AERPRO&amp;cl=113214&amp;ejc=2"><img style="border: 0pt none;" src="http://shoultes.net/wp-content/uploads/2010/04/add-to-cart.gif" border="0" alt="Add to Cart" width="90" height="29" /></a> <a class="ec_ejc_thkbx" onclick="javascript:return EJEJC_lc(this);" href="https://www.e-junkie.com/ecom/gb.php?c=cart&amp;cl=113214&amp;ejc=2"><img style="border: 0pt none;" src="http://shoultes.net/wp-content/uploads/2010/04/checkout-button.gif" border="0" alt="View Cart" width="90" height="30" /></a><script type="text/javascript">// <![CDATA[
      function EJEJC_lc(th) { return false; }
// ]]></script>
<script src="http://www.e-junkie.com/ecom/box.js" type="text/javascript"></script></td>
  </tr>
</table>
</div>
</div></li>
<li>
<div class="box-mid-head">
<h2>Settings</h2>
</div>
<div class="box-mid-body" id="toggle3">
					<div class="padding">
<p>To use, create a new page with only  {EVENTREGIS}</p>
<p>To display list of attendees of an active event use {EVENTATTENDEES} on a page or post.</p>
<p><span class="red_text">*</span>For URL link back to the payment/thank you page use  {EVENTREGPAY} on a new page.</p>
<p><span class="red_text">*</span>For PayPal to notify about payment confirmation use  {EVENTPAYPALTXN} on a new page.</p>
<p>To display a single event on a page use the [SINGLEEVENT single_event_id=&quot;Unique Event ID&quot;]</p>
<p>To display a list of events in sidebar, use the Event Registration Widget. If your theme doesn't use widgets, you can use  &lt;?php display_all_events(); ?&gt; in theme code.</p>
<p><span class="red_text">*</span>This page should be hidden from from your navigation menu. Exclude pages by using the &lsquo;Exclude Pages&rsquo; plugin from <a href="http://wordpress.org/extend/plugins/exclude-pages/" target="_blank">http://wordpress.org/extend/plugins/exclude-pages/</a> or using the &lsquo;exclude&rsquo; parameter in your &lsquo;wp_list_pages&rsquo; template tag. Please refer to <a href="http://codex.wordpress.org/Template_Tags/wp_list_pages" target="_blank">http://codex.wordpress.org/Template_Tags/wp_list_pages</a> for more inforamation about excluding pages.</p>
<p> Email Confirmations<br />
  For customized confirmation emails, the following tags can be placed in the email form and they will pull data from the database to include in the email.</p>
<p>[fname], [lname], [phone], [event],[description], [cost], [company], [co_add1], [co_add2], [co_city],[co_state], [co_zip],[contact], [payment_url], [start_date], [start_time], [end_date], [end_time]<br />
</p>
<h3>Sample Mail Send </h3>
<p>***This is an automated response - Do Not Reply***</p>
<p>Thank you [fname] [lname] for registering for [event].  We hope that you will find this event both informative and enjoyable.  Should have any questions, please contact [contact].</p>
<p>If you have not done so already, please submit your payment in the amount of [cost].</p>
<p>Click here to reveiw your payment information [payment_url].</p>
<p>Thank You.</p>

<h3>Trouble Shooting and Frequently Asked Questions </h3>
<p><strong>Registration Page Just Refreshes</strong><br />
Usually its because you need to point the &quot;Main registration page:&quot; (in the Organization Settings page) to whatever page you have the shortcode {EVENTREGIS} on.</p>
<p><strong>For the event times, is there a way I can specify a time that is not  at the top of the hour, say like 5:15 or 5:30?</strong><br />
Yes, in the file /wp-content/plugins/events-registration-with-paypal-ipn/includes/manage_events.php. You will need to change it in multiple places (currently around line #'s 510, 695.)</p>
<p><strong>State Dropdown in the Registration Form </strong><br />
I am working on a way to make the State dropdown easier to manage if you are outside the U.S. Until then,  you can edit the form in the event_register_attendees.php file located  in the includes folder of the plugin. Just be sure to keep the field names the same.</p>
<p><strong>Wrong Event Dates!</strong><br />
  If you have just updated the plugin from a previous version, your event dates may be out of order, showing an error, or are wrong. Event categories were also affected in a previous update. Pressing the button below should fix all of these problems.</p>
<p>Click the button below to update the date fields.</p>
<form name="form" method="post" action="<?php echo $_SERVER["REQUEST_URI"]?>">
  <p>
    <input type="hidden" name="action" value="update_event_dates">
    <input class="button-primary" type="submit" name="update_event_dates_button" value="Fix Dates and Categories" id="update_event_dates"/>
  </p>

</form> 
 <p>If you have clicked the button and event dates that should be expired, are showing an error or seem to be out of order. Go into the "<a href="admin.php?page=events">Event Management</a>" page and click the "Edit this Event" button then click the "Update Event" button on each event that is displaying the wrong date(s). This process should fix the problem. If it doesn't then send a support request to the email address listed below.</p>

</div>
</div> </li>
 </ul>
 </div>
 </div>
<?php
event_regis_display_right_column ();
event_regis_admin_footer();
}

function update_event_start_date_fields(){	
		$sql = "SELECT * FROM ". get_option('events_detail_tbl') . " WHERE start_date = '' OR start_date LIKE '%--%' OR end_date = '' OR end_date LIKE '%--%'";
		$result = mysql_query ($sql);
		$num = mysql_num_rows($result);
		$i=0;
		
			while ($row = mysql_fetch_assoc ($result)){
				
				$event_id = $row['id'];
				
				$start_month=$row['start_month'];
				$start_day=$row['start_day'];
				$start_year=$row['start_year'];
				
				$end_month=$row['end_month'];
				$end_day=$row['end_day'];
				$end_year=$row['end_year'];
				
				//Build the start and end dates for sorting purposes
				if ($start_month == "Jan"){$month_no = '01';}
				if ($start_month == "Feb"){$month_no = '02';}
				if ($start_month == "Mar"){$month_no = '03';}
				if ($start_month == "Apr"){$month_no = '04';}
				if ($start_month == "May"){$month_no = '05';}
				if ($start_month == "Jun"){$month_no = '06';}
				if ($start_month == "Jul"){$month_no = '07';}
				if ($start_month == "Aug"){$month_no = '08';}
				if ($start_month == "Sep"){$month_no = '09';}
				if ($start_month == "Oct"){$month_no = '10';}
				if ($start_month == "Nov"){$month_no = '11';}
				if ($start_month == "Dec"){$month_no = '12';}
				$start_date = $start_year."-".$month_no."-".$start_day;
				
				if ($end_month == "Jan"){$end_month_no = '01';}
				if ($end_month == "Feb"){$end_month_no = '02';}
				if ($end_month == "Mar"){$end_month_no = '03';}
				if ($end_month == "Apr"){$end_month_no = '04';}
				if ($end_month == "May"){$end_month_no = '05';}
				if ($end_month == "Jun"){$end_month_no = '06';}
				if ($end_month == "Jul"){$end_month_no = '07';}
				if ($end_month == "Aug"){$end_month_no = '08';}
				if ($end_month == "Sep"){$end_month_no = '09';}
				if ($end_month == "Oct"){$end_month_no = '10';}
				if ($end_month == "Nov"){$end_month_no = '11';}
				if ($end_month == "Dec"){$end_month_no = '12';}
				$end_date = $end_year."-".$end_month_no."-".$end_day;
			
				$sql2="UPDATE ". get_option('events_detail_tbl'). " SET start_date='$start_date', end_date='$end_date' WHERE id = $event_id";
				$wpdb->query($wpdb->prepare($sql2));
			}
			mysql_query("ALTER TABLE `".get_option('events_detail_tbl')."` CHANGE `category_id` `category_id` TEXT");
			?>
            <div id="message" class="updated fade"><p><strong>Event dates have been updated!</strong></p></div>
<?php	}
	?>
