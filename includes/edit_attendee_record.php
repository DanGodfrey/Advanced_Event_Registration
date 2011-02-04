<?php 
function edit_attendee_record(){
	global $wpdb;
		
	$events_detail_tbl = get_option('events_detail_tbl');
	$events_attendee_tbl = get_option('events_attendee_tbl');
	if ($_REQUEST['event_id'] !=""){$view_event = $_REQUEST['event_id'];}
	if ($_REQUEST['view_event'] !=""){$view_event = $_REQUEST['view_event'];}
	if ( $_REQUEST['form_action'] == 'edit_attendee' ){
				if ( $_REQUEST['attendee_action'] == 'delete_attendee' ){
					$id = $_REQUEST['id'];
					$sql= " DELETE FROM ". $events_attendee_tbl . " WHERE id ='$id'";
					$wpdb->query($wpdb->prepare($sql));
				
				}
				else if ( $_REQUEST['attendee_action'] == 'update_attendee' ){
					$id = $_REQUEST['id'];
											   
					$regisration_id=$row['id'];
					$fname = $_POST['fname'];
					$lname = $_POST['lname'];
					$address = $_POST['address'];
					$city = $_POST['city'];
					$state = $_POST['state'];
					$zip = $_POST['zip'];
					$phone = $_POST['phone'];
					$email = $_POST['email'];
					$hear = $_POST['hear'];
					$event_id=$_POST['event_id'];
					$payment = $_POST['payment'];
					$custom_1 =$_POST['custom_1'];
					$custom_2 =$_POST['custom_2'];
					$custom_3 =$_POST['custom_3'];
					$custom_4 =$_POST['custom_4'];
					$sql="UPDATE ". $events_attendee_tbl . " SET fname='$fname', lname='$lname', address='$address', city='$city', state='$state', zip='$zip', phone='$phone', email='$email', payment='$payment', hear='$hear', custom_1='$custom_1', custom_2='$custom_2', custom_3='$custom_3', custom_4='$custom_4' WHERE id ='$id'";
					$wpdb->query($wpdb->prepare($sql));
									
					// Insert Extra From Post Here
					$events_question_tbl = get_option('events_question_tbl');
					$events_answer_tbl = get_option('events_answer_tbl');
					$reg_id = $id;
					$wpdb->query($wpdb->prepare("DELETE FROM $events_answer_tbl where registration_id = '$reg_id'"));

					$questions = $wpdb->get_results("SELECT * from `$events_question_tbl` where event_id = '$event_id'");
	
						if ($questions) {
							foreach ($questions as $question) {
								switch ($question->question_type) {
									case "TEXT":
									case "TEXTAREA":
									case "SINGLE":
										$post_val = $_POST[$question->question_type . '-' . $question->id];
										$wpdb->query($wpdb->prepare("INSERT into $events_answer_tbl (registration_id, question_id, answer) values ('$reg_id', '$question->id', '$post_val')"));
									break;
										case "MULTIPLE":
											$values = explode(",", $question->response);
											$value_string = '';
											foreach ($values as $key => $value) {
												$post_val = $_POST[$question->question_type . '-' . $question->id . '-' . $key];
												if ($key > 0 && !empty($post_val)){
													$value_string .= ',';
													$value_string .= $post_val;
												}
											}
									$wpdb->query($wpdb->prepare("INSERT into $events_answer_tbl (registration_id, question_id, answer) values ('$reg_id', '$question->id', '$value_string')"));
									break;
								}
							}
						}			
					
				}
					$sql = "SELECT * FROM ". $events_detail_tbl . " WHERE id='".$view_event."'";
					$result = mysql_query($sql);
						while ($row = mysql_fetch_assoc ($result)){
							$event_id = $row['id'];
							$event_name = $row['event_name'];
							$event_desc = $row['event_desc'];
							$event_description = $row['event_desc'];
							$event_identifier = $row['event_identifier'];
							$cost = $row['event_cost'];
							$active = $row['is_active'];
							$question1 = $row['question1'];
							$question2 = $row['question2'];
							$question3 = $row['question3'];
							$question4 = $row['question4'];
						}
					   			     	
					$id = $_REQUEST['id'];
					$sql  = "SELECT * FROM " . $events_attendee_tbl . " WHERE id ='$id'";
					$result = mysql_query($sql);
						while ($row = mysql_fetch_assoc ($result)){
							$id = $row['id'];
							$regisration_id=$row['id'];
							$lname = $row['lname'];
							$fname = $row['fname'];
							$address = $row['address'];
							$city = $row['city'];
							$state = $row['state'];
							$zip = $row['zip'];
							$email = $row['email'];
							$hear = $row['hear'];
							$payment = $row['payment'];
							$phone = $row['phone'];
							$date = $row['date'];
							$payment_status = $row['payment_status'];
							$txn_type = $row['txn_type'];
							$txn_id = $row['txn_id'];
							$amount_pd = $row['amount_pd'];
							$quantity = $row['quantity'];
							$payment_date = $row['payment_date'];
							$event_id = $row['event_id'];
							$custom_1 = $row['custom_1'];
							$custom_2 = $row['custom_2'];
							$custom_3 = $row['custom_3'];
							$custom_4 = $row['custom_4'];
						}
			
?>
<div id="event_reg_theme" class="wrap">
<div id="icon-options-event" class="icon32"></div><h2>Attendee Management</h2>
<?php if ( $_REQUEST['status'] == 'saved' ) { ?>
	<div id="message" class="updated fade"><p><strong>Attendee details saved for <?php echo $fname?> <?php echo $lname?>.</strong></p></div>
<?php  } ?>
<div class="metabox-holder">
  <div class="postbox">	
  <h3>Attendee #<?php echo $id?> | Name: <?php echo $fname?> <?php echo $lname?> | Registered For: <a href="admin.php?page=events#event-id-<?php echo $event_id?>"><?php echo $event_name?></a></h3>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>&status=saved">
<ul><li><strong>First Name: <input tabIndex="1" maxLength="45" size="47" name="fname" value ="<?php echo $fname;?>"></strong> </li>
<li><strong>Last Name: <input tabIndex="2" maxLength="45" size="47" name="lname" value ="<?php echo $lname;?>"></strong></li>
<li><strong>Address: <input tabIndex="5" maxLength="45" size="49" name="address" value ="<?php echo $address;?>"></strong></li>
<li><strong>City: <input tabIndex="6" maxLength="20" size="33" name="city" value ="<?php echo $city;?>"></strong></li>
<li><strong>State or Province: <input tabIndex="7" maxLength="30" size="18" name="state" value ="<?php echo $state;?>"></strong> </li>
<li><strong>Zip: <input tabIndex="8" maxLength="10" size="16" name="zip" value ="<?php echo $zip;?>"></strong></li>
<li><strong>Email: <input tabIndex="3" maxLength="37" size="37" name="email" value ="<?php echo $email;?>"></strong></li>
<li><strong>Phone: <input tabIndex="4" maxLength="15" size="28" name="phone" value ="<?php echo $phone;?>"></strong></li>
<li><strong>How is attendee paying for registration?</strong>
<select tabIndex="10" size="1" name="payment">
  <option value="<?php echo $payment;?>" selected><?php echo $payment;?></option>
  <option value="Paypal">Credit Card or Paypal</option>
  <option value="Cash">Cash</option>
  <option value="Check">Check</option>
</select></li>
<?php
$events_question_tbl = get_option('events_question_tbl');
$events_answer_tbl = get_option('events_answer_tbl');

$questions = $wpdb->get_results("SELECT * from $events_question_tbl where event_id = '$event_id' order by sequence");		

	if ($questions){
		for ($i = 0; $i < count($questions); $i++) {
	
		echo "<p><strong>".$questions[$i]->question."</strong><br>";
		
		$question_id = $questions[$i]->id;
		$query  = "SELECT * FROM $events_answer_tbl WHERE registration_id = '$id' AND question_id = '$question_id'";
		$result = mysql_query($query) or die('Error : ' . mysql_error());
			while ($row = mysql_fetch_assoc ($result)){
			$answers = $row['answer'];
			}
		
		event_form_build($questions[$i], $answers);
		echo "</p>";
		
	 } 
	}
												
?>
<input type="hidden" name="id" value=<?php echo $id?>>
<input type="hidden" name="event_id" value="<?php echo $event_id?>" />
<input type="hidden" name="display_action" value="view_list" />
<input type="hidden" name="view_event" value="<?php echo $view_event?>" />
<input type="hidden" name="form_action" value="edit_attendee">
<input type="hidden" name="attendee_action" value="update_attendee">

<li><input type="submit" name="Submit" value="Update Record"></li></ul>
</form>

</div>
</div>
</div>
<?php
									   			
			}
}
?>
