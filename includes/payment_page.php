<?php
//Payment Page/PayPal Buttons - Used to display the payment options and the payment link in the email. Used with the {EVENTREGPAY} tag

//This is the initial PayPal button
function events_payment_page($event_id,$attendee_id){
	// Setup class
	$p = new paypal_class;// initiate an instance of the class

			global $wpdb;
			
			$events_detail_tbl = get_option('events_detail_tbl');
			
		
	  			$org_options = get_option('events_organization_settings');
				$Organization =$org_options['organization'];
				$Organization_street1 =$org_options['organization_street1'];
				$Organization_street2=$org_options['organization_street2'];
				$Organization_city =$org_options['organization_city'];
				$Organization_state=$org_options['organization_state'];
				$Organization_zip =$org_options['organization_zip'];
				$contact =$org_options['contact_email'];
 				$registrar = $org_options['contact_email'];
				$paypal_id =$org_options['paypal_id'];
				$paypal_cur =$org_options['currency_format'];
				$events_listing_type =$org_options['events_listing_type'];
				$message =$org_options['message'];
				$return_url = $org_options['return_url'];
				$cancel_return = $org_options['cancel_return'];
				$notify_url = $org_options['notify_url'];
				$image_url = $org_options['image_url'];
				$use_sandbox = $org_options['use_sandbox'];
			
	if ($use_sandbox == 1) {
		$p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; // testing paypal url
		echo "<h3 style=\"color:#ff0000;\" title=\"Payments will not be processed\">Debug Mode Is Turned On</h3>";
	}else {
		$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr'; // paypal url
	}

			//Query Database for Active event and get variable
			$sql = "SELECT * FROM ". $events_detail_tbl . " WHERE id ='$event_id'";

			$result = mysql_query($sql);
			while ($row = mysql_fetch_assoc ($result)){
						$event_id = $row['id'];
						$event_name = $row['event_name'];
						$event_desc = $row['event_desc'];
						$event_description = $row['event_desc'];
						$event_identifier = $row['event_identifier'];
						$event_cost = $row['event_cost'];
						$send_mail = $row['send_mail'];
						$active = $row['is_active'];
						$conf_mail = $row['conf_mail'];
						$use_coupon_code = $row['use_coupon_code'];	
						$coupon_code = $row['coupon_code'];						
						$coupon_code_price = $row['coupon_code_price'];
						$use_percentage= $row['use_percentage'];
			}

		$events_attendee_tbl = get_option('events_attendee_tbl');
		$query  = "SELECT * FROM $events_attendee_tbl WHERE id='$attendee_id'";
		//echo $query;
	   		$result = mysql_query($query) or die('Error : ' . mysql_error());
	   		while ($row = mysql_fetch_assoc ($result))
				{
	  		    $attendee_id = $row['id'];
				$attendee_last = $row['lname'];
				$attendee_first = $row['fname'];
				$attendee_address = $row['address'];
				$attendee_city = $row['city'];
				$attendee_state = $row['state'];
				$attendee_zip = $row['zip'];
				$attendee_email = $row['email'];
				$phone = $row['phone'];
				$date = $row['date'];
				$num_people = $row['quantity'];
				$payment_status = $row['payment_status'];
				$txn_type = $row['txn_type'];
				$amount_pd = $row['amount_pd'];
				$payment_date = $row['payment_date'];
				$event_id = $row['event_id'];
				
				}
				$attendee_name = $attendee_first.' '.$attendee_last;

			$event_cost = $event_cost * $num_people;
			
			if ($use_coupon_code == "Y"){ 
				if ($_REQUEST['coupon_code'] != ''){
					if ($coupon_code == $_POST['coupon_code']){
					
					$valid_discount = true;
						
						$discount_type_price = $use_percentage == 'Y' ? $coupon_code_price.'%' : $org_options['currency_symbol'].$coupon_code_price;
						_e('<p><strong>You are using discount code:</strong> '.$coupon_code.' ('.$discount_type_price.' discount)</p>','event_regis');
						if($use_percentage == 'Y'){
							$pdisc  = $coupon_code_price / 100;
							$event_cost = $event_cost - ($event_cost * $pdisc);
						}else{
							$event_cost = $event_cost - $coupon_code_price;
						}
						
						if($event_cost == '0.00'){
							$event_cost = __('0.00','event_regis');
							$payment_status = __('Completed','event_regis');
						}
						
						$sql=array('coupon_code'=>$_REQUEST['coupon_code'], 'amount_pd'=>$event_cost, 'payment_status'=>$payment_status);
		
						$sql_data = array('%s','%s','%s');
						
						$update_id = array('id'=> $attendee_id);
						
						$wpdb->update($events_attendee_tbl, $sql, $update_id, $sql_data, array( '%d' ) );
							//print_r( $sql );
		
					}else{
						_e('<p><font color="red">Sorry, that coupon code is invalid or expired.</font></p>','event_regis');
					}
				}
			 }else {
				 
				if($event_cost == '0.00'){
					//$event_cost_disp = __('0.00','event_regis');
					$payment_status = __('Completed','event_regis');
				}
						
				 $sql=array('amount_pd'=>$event_cost, 'payment_status'=>$payment_status);
		
						$sql_data = array('%s','%s');
						
						$update_id = array('id'=> $attendee_id);
						
						$wpdb->update($events_attendee_tbl, $sql, $update_id, $sql_data, array( '%d' ) );
			 }
			 
	if ($event_cost != "0.00" || $event_cost != "" || $event_cost != " "){
			 			
			if ($paypal_id !="" || $paypal_id !=" "){
			
				  $p->add_field('business', $paypal_id);
				  $p->add_field('return', get_option('siteurl').'/?page_id='.$return_url);
				  $p->add_field('cancel_return', get_option('siteurl').'/?page_id='.$cancel_return);
				  $p->add_field('notify_url', get_option('siteurl').'/?page_id='.$notify_url.'&id='.$attendee_id.'&event_id='.$event_id.'&attendee_action=post_payment&form_action=payment');
				  $p->add_field('item_name', $event_name . ' | Reg. ID: '.$attendee_id. ' | Name: '. $attendee_name .' | Total Registrants: '.$num_people);
				  $p->add_field('amount', $event_cost);
				  $p->add_field('currency_code', $paypal_cur);
				  
				  //Post variables
				  $p->add_field('first_name', $attendee_first);
				  $p->add_field('last_name', $attendee_last);
				  $p->add_field('email', $attendee_email);
				  $p->add_field('address1', $attendee_address);
				  $p->add_field('city', $attendee_city);
				  $p->add_field('state', $attendee_state);
				  $p->add_field('zip', $attendee_zip);				 
?>				  
<p align="left"><strong>Please verify your registration details:</strong></p>
                    <table style="background-color:transparent;" width="95%" border="0" id="event_regis_attendee_verify">
                      <tr>
                        <td><strong>Event Name/Cost:</strong></td>
                        <td><?php echo $event_name?> - <?php echo $org_options['currency_symbol']?><?php echo $event_cost?></td>
                      </tr>
                      <tr>
                        <td><strong>Attendee Name:</strong></td>
                        <td><?php echo $attendee_name?></td>
                      </tr>
                      <tr>
                        <td><strong>Email Address:</strong></td>
                        <td><?php echo $attendee_email?></td>
                      </tr>
                       <tr>
                        <td><strong>Number of Attendees:</strong></td>
                        <td><?php echo $num_people?></td>
                      </tr>
                    </table>
<?php
					 $p->submit_paypal_post(); // submit the fields to paypal
				  if ($use_sandbox == true) {
					  $p->dump_fields(); // for debugging, output a table of all the fields
				  }   
			
			}
	  }
}

//This is the alternate PayPal button used for the email 
function event_regis_pay(){

		global $wpdb;
		$events_attendee_tbl = get_option('events_attendee_tbl');
		$events_detail_tbl = get_option('events_detail_tbl');
		$paypal_cur = get_option('paypal_cur');
		$id="";
		$id=$_GET['id'];
if ($id ==""){echo "Please check your email for payment information.";}
else{
			$query  = "SELECT * FROM $events_attendee_tbl WHERE id='$id'";
	   		$result = mysql_query($query) or die('Error : ' . mysql_error());
	   		while ($row = mysql_fetch_assoc ($result))
				{
	  		    $attendee_id = $row['id'];
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
				
				$attendee_name = $fname." ".$lname;
				}

				
			$org_options = get_option('events_organization_settings');
				$Organization =$org_options['organization'];
				$Organization_street1 =$org_options['organization_street1'];
				$Organization_street2=$org_options['organization_street2'];
				$Organization_city =$org_options['organization_city'];
				$Organization_state=$org_options['organization_state'];
				$Organization_zip =$org_options['organization_zip'];
				$contact =$org_options['contact_email'];
 				$registrar = $org_options['contact_email'];
				$paypal_id =$org_options['paypal_id'];
				$paypal_cur =$org_options['currency_format'];
				$events_listing_type =$org_options['events_listing_type'];
				$message =$org_options['message'];
				$return_url = $org_options['return_url'];
				$cancel_return = $org_options['cancel_return'];
				$notify_url = $org_options['notify_url'];
				$use_sandbox = $org_options['use_sandbox'];
				$image_url = $org_options['image_url'];
				$currency_symbol = $org_options['currency_symbol'];
			


			//Query Database for event and get variable

			$sql = "SELECT * FROM ". $events_detail_tbl . " WHERE id='$event_id'";
			$result = mysql_query($sql);
			while ($row = mysql_fetch_assoc ($result))
			{
						//$event_id = $row['id'];
						$event_name = $row['event_name'];
						$event_desc = $row['event_desc'];
						$event_description = $row['event_desc'];
						$event_identifier = $row['event_identifier'];
						$event_cost = $row['event_cost'];
						$active = $row['is_active'];
					
							}
echo "<br><br><strong>Thank You ".$fname." ".$lname." for registering for ".$event_name."</strong><br><br>";

if ($payment_status == "Completed"){echo "<p><font color='red' size='3'>Our records indicate you have paid ".$currency_symbol.$amount_pd."</font></p>";}
if ($payment_status == "Pending"){echo "<p><font color='red' size='3'>Our records indicate your payment is pending.<br />Amount pending: ".$currency_symbol.$amount_pd."</font></p>";}

if ($payment_status != ("Completed" || "Pending") ){
	
if ($event_cost != "0.00" && $paypal_id !=""){
	
//Payment Selection with data hidden - forwards to paypal
		?>
<p align="left"><strong>Payment By Credit Card, Debit Card or Pay Pal Account<br>
  (a PayPal account is not required to pay by credit card).</strong></p>
<p>Payment will be in the amount of  <?php echo $currency_symbol.$event_cost;?>.</p>
<p>PayPal Payments will be sent to: <?php echo $Organization?> (<?php echo $paypal_id?>)</p>
  
  

<table style="background-color:transparent;" width="500">
  <tr>
    <td align="center" valign="middle">&nbsp;<br />
      <strong>
      <?php echo $event_name." - ".$currency_symbol.$event_cost;?>
      </strong>&nbsp;
      <?php 
	  if ($use_sandbox == 1){ 
      		echo "<form action='https://www.sandbox.paypal.com/cgi-bin/webscr' method='post'>";
       }else{
      		echo "<form action='https://www.paypal.com/cgi-bin/webscr' method='post'>";
	   }
    ?>
      <br />
      <br />
      <input type="hidden" name="bn" value="AMPPFPWZ.301">
      <input type="hidden" name="cmd" value="_ext-enter">
      <input type="hidden" name="redirect_cmd" value="_xclick">
      <input type="hidden" name="business" value="<?php echo $paypal_id;?>" >
      <input type="hidden" name="item_name" value="<?php echo $event_name." - ".$attendee_id." - ".$attendee_name;?>">
      <input type="hidden" name="item_number" value="<?php echo $event_identifier;?>">
      <input type="hidden" name="amount" value="<?php echo $event_cost;?>">
      <input type="hidden" name="currency_code" value="<?php echo $paypal_cur;?>">
      <input type="hidden" name="undefined_quantity" value="0">
      <input type="hidden" name="custom" value="<?php echo $attendee_id;?>">
      <input type="hidden" name="image_url" value="<?php echo $image_url;?>">
      <input type="hidden" name="email" value="<?php echo $attendee_email;?>">
      <input type="hidden" name="first_name" value="<?php echo $attendee_first;?>">
      <input type="hidden" name="last_name" value="<?php echo $attendee_last;?>">
      <input type="hidden" name="address1" value="<?php echo $attendee_address;?>">
      <input type="hidden" name="address2" value="">
      <input type="hidden" name="city" value="<?php echo $attendee_city;?>">
      <input type="hidden" name="state" value="<?php echo $attendee_state;?>">
      <input type="hidden" name="zip" value="<?php echo $attendee_zip;?>">
      <input type="hidden" name="return" value="<?php echo get_option('siteurl')?>/?page_id=<?php echo $return_url;?>">
      <input type="hidden" name="cancel_return" value="<?php echo get_option('siteurl')?>/?page_id=<?php echo $cancel_return;?>">
      <input type="hidden" name="notify_url" value="<?php echo get_option('siteurl')?>/?page_id=<?php echo $notify_url?>&id=<?php echo $attendee_id;?>&event_id=<?php echo $event_id?>&attendee_action=post_payment&form_action=payment">
      <input type="hidden" name="rm" value="2">
      <input type="hidden" name="add" value="1">
      <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_paynowCC_LG.gif" border="0" align='middle' name="submit">
      </form></td>
  </tr>
</table>
<?php		}
		}
	}
}
?>
