<?php 
//Payment processing - Used for onsite payment processing. Used with the {EVENTPAYPALTXN} tag
function event_paypal_txn(){
	$org_options = get_option('events_organization_settings');
	$id="";
	$id=$_REQUEST['id'];//This is the id of the registrant
	if ($id ==""){
		echo "ID not supplied.";
	}else{
		if ($org_options['use_sandbox'] == '1'){
			sandbox_using_ipn($id=$_REQUEST['id']);
		}else{
			$p = new paypal_class;// initiate an instance of the class
			if ($p->validate_ipn()) {
				//store the results in reusable variables
				$payer_id = $p->ipn_data['payer_id'];
				$payment_date = $p->ipn_data['payment_date'];
				$txn_id = $p->ipn_data['txn_id'];
				$first_name = $p->ipn_data['first_name'];
				$last_name = $p->ipn_data['last_name'];
				$payer_email = $p->ipn_data['payer_email'];
				$payer_status = $p->ipn_data['payer_status'];
				$payment_type = $p->ipn_data['payment_type'];
				$memo = $p->ipn_data['memo'];
				$item_name = $p->ipn_data['item_name'];
				$item_number = $p->ipn_data['item_number'];
				$quantity = $p->ipn_data['quantity'];
				if (isset($_REQUEST['mc_gross'])){
							$amount_pd = $_REQUEST['mc_gross'];
						}else{
							$amount_pd = $_REQUEST['payment_gross'];
						}
				$mc_currency = $p->ipn_data['mc_currency'];
				$address_name = $p->ipn_data['address_name'];
				$address_street = nl2br($p->ipn_data['address_street']);
				$address_city = $p->ipn_data['address_city'];
				$address_state = $p->ipn_data['address_state'];
				$address_zip = $p->ipn_data['address_zip'];
				$address_country = $p->ipn_data['address_country'];
				$address_status = $p->ipn_data['address_status'];
				$payer_business_name = $p->ipn_data['payer_business_name'];
				$payment_status = $p->ipn_data['payment_status'];
				$pending_reason = $p->ipn_data['pending_reason'];
				$reason_code = $p->ipn_data['reason_code'];
				$txn_type = $p->ipn_data['txn_type'];
			
				global $wpdb;
				$events_attendee_tbl = get_option('events_attendee_tbl');
				
				$today = date("m-d-Y");	
				$sql="UPDATE ". $events_attendee_tbl . " SET payment_status = '$payment_status', txn_type = '$txn_type', txn_id = '$txn_id', amount_pd = '$amount_pd', payment_date ='$payment_date' WHERE id ='$id'";
				$wpdb->query($wpdb->prepare($sql));
				
				 $query  = "SELECT * FROM ". $events_attendee_tbl ." WHERE id ='".$id."'";
				 $result = mysql_query($query) or die('Error : ' . mysql_error());
					while ($row = mysql_fetch_assoc ($result)){
						$attendee_email = $row['email'];
				 }
				 
				$org_options = get_option('events_organization_settings');
						$email_subject = $org_options['payment_subject'];
						$email_body = $org_options['payment_message'];
						$default_mail=$org_options['default_mail'];
						$Organization =$org_options['organization'];
						$contact =$org_options['contact_email'];
				 
				$event_id = $_REQUEST['event_id'];
				$events_detail_tbl = get_option('events_detail_tbl');
				$query  = "SELECT * FROM ".$events_detail_tbl." WHERE id='$event_id'";
					$result = mysql_query($query) or die('Error : ' . mysql_error());
					while ($row = mysql_fetch_assoc ($result)){
						$event_name = $row['event_name'];
						$start_month =$row['start_month'];
						$start_day = $row['start_day'];
						$start_year = $row['start_year'];
						$end_month = $row['end_month'];
						$end_day = $row['end_day'];
						$end_year = $row['end_year'];
						$start_time = $row['start_time'];
						$end_time = $row['end_time'];
						$send_mail= $row['send_mail'];
					}
											
				//Replace the tags
				$tags = array("[fname]", "[lname]", "[payer_email]", "[event_name]", "[event_price]", "[txn_id]", "[address_street]", "[address_city]", "[address_state]", "[address_zip]", "[address_country]", "[start_date]", "[start_time]", "[end_date]", "[end_time]" );
				$vals = array($first_name, $last_name, $payer_email, $event_name, $amount_pd, $txn_id, $address_street, $address_city, $address_state, $address_zip, $address_country, $start_date, $start_time, $end_date, $end_time);
				//Dan's Code to autogen user
				
				$new_user_pass = generatePassword(6,8);

				$query  = "SELECT * FROM ". $events_attendee_tbl ." WHERE id ='".$id."'";
			 	$result = mysql_query($query) or die('Error : ' . mysql_error());
				while ($row = mysql_fetch_assoc ($result)){
					$attendee_email = $row['email'];
					$attendee_fname = $row['fname'];
					$attendee_lname = $row['lname'];

				 }
				$role = "none";	
				require_once(ABSPATH . WPINC . '/registration.php');
                                $myUserName = $attendee_fname . "_" . $attendee_lname;
				wp_insert_user( array ('user_login' => $myUserName, 'user_pass' => $new_user_pass, 'first_name' => $attendee_fname, 'last_name' => $attendee_lname, 'user_email' => $attendee_email, 'role' => $role) ) ;

				
				$headers = "MIME-Version: 1.0\r\n";
				$headers .= "From: " . $Organization . " <". $contact . ">\r\n";
				$headers .= "Reply-To: " . $Organization . "  <" . $contact . ">\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
				$message_top = "<html><body><b>Gamer Community Credentials</b><br/>Username: ".$attendee_fname."_".$attendee_lname."<br/>Password: ".$new_user_pass."<br/>"; 
				$message_bottom = "</html></body>";
				$email_body = $message_top.$email_body.$message_bottom;
				
				$subject = str_replace($tags,$vals,$email_subject);
				$body    = str_replace($tags,$vals,$email_body);
				if ($default_mail =='Y'){ if($send_mail == 'Y'){ wp_mail($attendee_email, html_entity_decode($subject), html_entity_decode($body), $headers);}}
				
				$events_paypal_transactions_tbl = get_option('events_paypal_transactions_tbl');
				//Store transaction details in the database
				$qry  = "INSERT INTO ".$events_paypal_transactions_tbl." VALUES (0, '".$payer_id."', '".$payment_date."', '".$txn_id."',";
				$qry .= "'".$first_name."', '".$last_name."', '".$payer_email."', '".$payer_status."',";
				$qry .= "'".$payment_type."', '".$memo."', '".$item_name."', '".$item_number."',";
				$qry .= "'".$quantity."', '".$mc_gross."', '".$mc_currency."', '".$address_name."',";
				$qry .= "'".$address_street."', '".$address_city."', '".$address_state."',";
				$qry .= "'".$address_zip."', '".$address_country."', '".$address_status."',";
				$qry .= "'".$payer_business_name."', '".$payment_status."', '".$pending_reason."',";
				$qry .= "'".$reason_code."', '".$txn_type."')";
				
				$wpdb->query( $wpdb->prepare( $qry ));
			}
		}
	}

}

//Using Sandbox
function sandbox_using_ipn($id){
	$org_options = get_option('events_organization_settings');
					$email_subject = $org_options['payment_subject'];
					$email_body = $org_options['payment_message'];
					$default_mail=$org_options['default_mail'];
					$Organization =$org_options['organization'];
					$contact =$org_options['contact_email'];
					$events_detail_tbl = get_option('events_detail_tbl');
	$id=$id;
	$p = new paypal_class;// initiate an instance of the class
			$p->validate_ipn();  
			//store the results in reusable variables
			$payer_id = $p->ipn_data['payer_id'];
			$payment_date = $p->ipn_data['payment_date'];
			$txn_id = $p->ipn_data['txn_id'];
			$first_name = $p->ipn_data['first_name'];
			$last_name = $p->ipn_data['last_name'];
			$payer_email = $p->ipn_data['payer_email'];
			$payer_status = $p->ipn_data['payer_status'];
			$payment_type = $p->ipn_data['payment_type'];
			$memo = $p->ipn_data['memo'];
			$item_name = $p->ipn_data['item_name'];
			$item_number = $p->ipn_data['item_number'];
			$quantity = $p->ipn_data['quantity'];
			if (isset($_REQUEST['mc_gross'])){
						$amount_pd = $_REQUEST['mc_gross'];
					}else{
						$amount_pd = $_REQUEST['payment_gross'];
					}
			$mc_currency = $p->ipn_data['mc_currency'];
			$address_name = $p->ipn_data['address_name'];
			$address_street = nl2br($p->ipn_data['address_street']);
			$address_city = $p->ipn_data['address_city'];
			$address_state = $p->ipn_data['address_state'];
			$address_zip = $p->ipn_data['address_zip'];
			$address_country = $p->ipn_data['address_country'];
			$address_status = $p->ipn_data['address_status'];
			$payer_business_name = $p->ipn_data['payer_business_name'];
			$payment_status = $p->ipn_data['payment_status'];
			$pending_reason = $p->ipn_data['pending_reason'];
			$reason_code = $p->ipn_data['reason_code'];
			$txn_type = $p->ipn_data['txn_type'];
		
			//Debugging option
			$email_paypal_dump = true;
			if ($email_paypal_dump == true) {
				 // For this, we'll just email ourselves ALL the data as plain text output.
				 $subject = 'Instant Payment Notification - PayPal Variable Dump';
				 $body =  "An instant payment notification was successfully recieved\n";
				 $body .= "from ".$p->ipn_data['payer_email']." on ".date('m/d/Y');
				 $body .= " at ".date('g:i A')."\n\nDetails:\n";
				 foreach ($p->ipn_data as $key => $value) { $body .= "\n$key: $value"; }
				 wp_mail($contact, $subject, $body);
			}
			
			global $wpdb;
			$events_attendee_tbl = get_option('events_attendee_tbl');
			
			$today = date("m-d-Y");	
			$sql="UPDATE ". $events_attendee_tbl . " SET payment_status = '$payment_status', txn_type = '$txn_type', txn_id = '$txn_id', amount_pd = '$amount_pd', quantity = '$quantity', payment_date ='$payment_date' WHERE id ='$id'";
			$wpdb->query($wpdb->prepare($sql));
			
			 $query  = "SELECT * FROM ". $events_attendee_tbl ." WHERE id ='".$id."'";
			 $result = mysql_query($query) or die('Error : ' . mysql_error());
				while ($row = mysql_fetch_assoc ($result)){
					$attendee_email = $row['email'];
					$attendee_fname = $row['fname'];
					$attendee_lname = $row['lname'];

			 }
			 			 
			$event_id = $_REQUEST['event_id'];
			$query  = "SELECT * FROM ".$events_detail_tbl." WHERE id='$event_id'";
				$result = mysql_query($query) or die('Error : ' . mysql_error());
				while ($row = mysql_fetch_assoc ($result)){
					$event_name = $row['event_name'];
					$start_month =$row['start_month'];
					$start_day = $row['start_day'];
					$start_year = $row['start_year'];
					$end_month = $row['end_month'];
					$end_day = $row['end_day'];
					$end_year = $row['end_year'];
					$start_time = $row['start_time'];
					$end_time = $row['end_time'];
					$send_mail= $row['send_mail'];
				}
										
			//Replace the tags
			$tags = array("[fname]", "[lname]", "[payer_email]", "[event_name]", "[event_price]", "[txn_id]", "[address_street]", "[address_city]", "[address_state]", "[address_zip]", "[address_country]", "[start_date]", "[start_time]", "[end_date]", "[end_time]" );
			$vals = array($first_name, $last_name, $payer_email, $event_name, $amount_pd, $txn_id, $address_street, $address_city, $address_state, $address_zip, $address_country, $start_date, $start_time, $end_date, $end_time);
			
			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "From: " . $Organization . " <". $contact . ">\r\n";
			$headers .= "Reply-To: " . $Organization . "  <" . $contact . ">\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
			$message_top = "<html><body>"; 
			$message_bottom = "</html></body>";
			$email_body = $message_top.$email_body.$message_bottom;
			
			$subject = str_replace($tags,$vals,$email_subject);
			$body    = str_replace($tags,$vals,$email_body);
			if ($default_mail =='Y'){ if($send_mail == 'Y'){ wp_mail($attendee_email, html_entity_decode($subject), html_entity_decode($body), $headers);}}
			
			$events_paypal_transactions_tbl = get_option('events_paypal_transactions_tbl');
				//Store transaction details in the database
				$qry  = "INSERT INTO ".$events_paypal_transactions_tbl." VALUES (0, '".$payer_id."', '".$payment_date."', '".$txn_id."',";
				$qry .= "'".$first_name."', '".$last_name."', '".$payer_email."', '".$payer_status."',";
				$qry .= "'".$payment_type."', '".$memo."', '".$item_name."', '".$item_number."',";
				$qry .= "'".$quantity."', '".$mc_gross."', '".$mc_currency."', '".$address_name."',";
				$qry .= "'".$address_street."', '".$address_city."', '".$address_state."',";
				$qry .= "'".$address_zip."', '".$address_country."', '".$address_status."',";
				$qry .= "'".$payer_business_name."', '".$payment_status."', '".$pending_reason."',";
				$qry .= "'".$reason_code."', '".$txn_type."')";
				
				$wpdb->query( $wpdb->prepare( $qry ));
}

function generatePassword($length=9, $strength=0) {
	$vowels = 'aeuy';
	$consonants = 'bdghjmnpqrstvz';
	if ($strength & 1) {
		$consonants .= 'BDGHJLMNPQRSTVWXZ';
	}
	if ($strength & 2) {
		$vowels .= "AEUY";
	}
	if ($strength & 4) {
		$consonants .= '23456789';
	}
	if ($strength & 8) {
		$consonants .= '@#$%';
	}
 
	$password = '';
	$alt = time() % 2;
	for ($i = 0; $i < $length; $i++) {
		if ($alt == 1) {
			$password .= $consonants[(rand() % strlen($consonants))];
			$alt = 0;
		} else {
			$password .= $vowels[(rand() % strlen($vowels))];
			$alt = 1;
		}
	}
	return $password;
}

?>
