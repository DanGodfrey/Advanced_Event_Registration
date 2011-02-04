<?php 
//Displays the list of attendees and the paymnts they have made
function list_attendee_payments(){
	$org_options = get_option('events_organization_settings');
?>
<div id="event_reg_theme" class="wrap">
<div id="icon-options-event" class="icon32"></div><h2>Attendees and Payments</h2>

<?php 
	global $wpdb;
	
	
	if($_POST['delete_customer']){
		if (is_array($_POST['checkbox'])){
			while(list($key,$value)=each($_POST['checkbox'])):
				$del_id=$key;
				//Delete customer data
				$sql = "DELETE FROM ".get_option('events_attendee_tbl')." WHERE id='$del_id'";
				$result = mysql_query($sql) or die(mysql_error());
			endwhile;	
		}
		?>
	<div id="message" class="updated fade"><p><strong>Customer(s) have been successfully deleted from the event.</strong></p></div>
<?php
	}


	$p = new event_regis_pagination;
	$events_detail_tbl = get_option('events_detail_tbl');
	$events_attendee_tbl = get_option('events_attendee_tbl');
	$event_id = $_REQUEST['event_id'];
						
	$sql = "SELECT * FROM ". $events_detail_tbl . " WHERE id='$event_id'";
	$result = mysql_query($sql);
		while ($row = mysql_fetch_assoc ($result)){
			$event_id = $row['id'];
			$event_name = $row['event_name'];
			$event_desc = $row['event_desc'];
			$event_description = $row['event_desc'];
			$event_identifier = $row['event_identifier'];
			$start_date =$row['start_date'];
			$start_month =$row['start_month'];
			$start_day = $row['start_day'];
			$start_year = $row['start_year'];
			$end_month = $row['end_month'];
			$end_day = $row['end_day'];
			$end_year = $row['end_year'];
			$start_time = $row['start_time'];
			$end_time = $row['end_time'];
			$cost = $row['event_cost'];
			$active = $row['is_active'];
			$question1 = $row['question1'];
			$question2 = $row['question2'];
			$question3 = $row['question3'];
			$question4 = $row['question4'];
		}
								
//Pagination
	$items = mysql_num_rows(mysql_query("SELECT * FROM ".$events_attendee_tbl." WHERE event_id='$event_id';")); // number of total rows in the database
	if($items > 0) {
		$p->items($items);
		$p->limit(30); // Limit entries per page
		$p->target("admin.php?page=admin_reports&event_id=".$event_id."&event_admin_reports=list_attendee_payments");
		$p->currentPage($_GET[$p->paging]); // Gets and validates the current page
		$p->calculate(); // Calculates what to show
		$p->parameterName('paging');
		$p->adjacents(1); //No. of page away from the current page

		if(!isset($_GET['paging'])) {
			$p->page = 1;
		} else {
			$p->page = $_GET['paging'];
		}

		//Query for limit paging
		$limit = "LIMIT " . ($p->page - 1) * $p->limit  . ", " . $p->limit;
	
} else {
	echo "No Record Found";
}//End pagination?>
	
<?php 
	$sql  = "SELECT * FROM " . $events_attendee_tbl . " WHERE event_id='$event_id' $limit";
	$result = mysql_query($sql);
	
	$sql2= "SELECT SUM(quantity) FROM " . $events_attendee_tbl . " WHERE event_id='$event_id'";
				$result2 = mysql_query($sql2);
	
				while($row = mysql_fetch_array($result2)){
					$number_attendees =  $row['SUM(quantity)'];
				}
				
				if ($number_attendees == '' || $number_attendees == 0){
					$number_attendees = '0';
				}
				
				if ($reg_limit == ""){
					$reg_limit = "&#8734;";
				}
				
				if ($start_date <= date('Y-m-d')){
					$active_event = '<span style="color: #F00; padding-left:30px; font-weight:bold;">EXPIRED</span>';
				} elseif ($active == "yes"){
					$active_event = '<span style="color: #090; padding-left:20px; font-weight:bold;">ACTIVE EVENT</span>';
				} else if ($active == "no"){
					$active_event = '<span style="color: #F00; padding-left:30px; font-weight:bold;">NOT ACTIVE</span>';
				}
		?>
<h3>Event: <a title="View event" href="admin.php?page=events#event-id-<?php echo $event_id?>"><?php echo $event_name?></a></h3>        

<div class="metabox-holder">
  <div class="stuffbox">
  <h3>Start Date: <?php echo $start_month?> <?php echo $start_day?>, <?php echo $start_year?> <?php echo $start_time?> | End Date: <?php echo $end_month?> <?php echo $end_day?>, <?php echo $end_year?> <?php echo $end_time?> | Attendees: <?php echo $number_attendees?> / <?php echo $reg_limit?> <?php echo $active_event?> <button style="margin-left:20px" class="button-primary" onclick="window.location='<?php echo get_bloginfo('wpurl')."/wp-admin/admin.php?event_regis&id=".$event_id."&export=report&action=payment";?>'" > Export to Excel </button>  | <a  class="button-primary" href="admin.php?page=events&action=edit&id=<?php echo $event_id?>">Edit Event</a> | <a  class="button-primary"title="View event" href="admin.php?page=events#event-id-<?php echo $event_id?>">View Event</a></h3>
</div>
</div>
<form id="form1" name="form1" method="post" action="<?php echo $_SERVER["REQUEST_URI"]?>">
<table class="widefat">
	  <thead>
		<tr>
		  <th>Delete</th>
          <th>ID</th>
		  <th> Name </th>
		  <th>Email</th>
		  <th>Pay Status</th>
		  <th>TXN Type</th>
		  <th>TXN ID</th>
		  <th>Amount Pd</th>
		  <th>Quantity</th>
		  <th>Date Paid</th>
		  <th>Action</th>
		</tr>
	  </thead>
      <tfoot>
    	 <tr> 
          <th>Delete</th>
          <th>ID</th>
		  <th> Name </th>
		  <th>Email</th>
		  <th>Pay Status</th>
		  <th>TXN Type</th>
		  <th>TXN ID</th>
		  <th>Amount Pd</th>
		  <th>Quantity</th>
		  <th>Date Paid</th>
		  <th>Action</th>
         </tr>
      </tfoot>
    <tbody>
		<?php
		if (mysql_num_rows($result) > 0 ) {
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
			$txn_id = $row['txn_id'];
			$amount_pd = $row['amount_pd'];
			$payment_date = $row['payment_date'];
			$quantity = $row['quantity'];
			$event_id = $row['event_id'];
			$custom1 = $row['custom_1'];
			$custom2 = $row['custom_2'];
			$custom3 = $row['custom_3'];
			$custom4 = $row['custom_4'];
			
			
						?>
    <tr <?php if ($amount_pd == "" || $amount_pd == " "){ echo "class='not_paid'"; }else if ($payment_status == "None"){echo "class='not_paid'";}else if ($payment_status == "Pending"){ echo "class='payment_pending'";}else if ($payment_status == "Completed"){ echo "class='payment_completed'";} ?>>
		  <td><input name="checkbox[<?php echo $id?>]" type="checkbox"  title="Delete <?php echo $fname?><?php echo $lname?>"></td>
          <td><?php echo $id?></td>
		  <td><?php echo $fname?> <?php echo $lname?></td>
		  <td><?php echo $email?></td>
		  <td><?php echo $payment_status?></td>
		  <td><?php echo $txn_type?></td>
		  <td><?php echo $txn_id?></td>
		  <td><?php echo $org_options['currency_symbol']?><?php echo $amount_pd?></td>
		  <td><?php echo $quantity?></td>
		  <td><?php echo $payment_date?></td>
		  <td style="background-color:#FFF"><a href="admin.php?page=admin_reports&attendee_pay=paynow&form_action=payment&id=<?php echo $id?>&event_admin_reports=enter_attendee_payments">Edit Payment</a> | <a href="admin.php?page=admin_reports&event_admin_reports=edit_attendee_record&event_id=<?php echo $event_id?>&form_action=edit_attendee&id=<?php echo $id?>">Edit Attendee</a> 
		  <?php if ($org_options['use_sandbox'] == 1) {
				?>
                | <a href="<?php echo get_option('siteurl'); ?>?page_id=<?php echo get_option('notify_url')?>&id=<?php echo $id?>&event_id=<?php echo $event_id?>&attendee_action=post_payment&form_action=payment">IPN Handler URL</a> <a class="ev_reg-fancylink" href="#ipn_handler_info"><img src="<?php echo EVNT_RGR_PLUGINFULLURL?>/images/question-frame.png" width="16" height="16" /></a>
                <?php
			} ?> </td>
		</tr>
		<?php	} 
        } else { ?>
  <tr>
    <td>No Record Found!</td>
  <tr>
    <?php	}?>
	  </tbody>
	</table>
    <input type="checkbox" name="sAll" onclick="selectAll(this)" /> <strong>Check All</strong> 
    <input name="delete_customer" type="submit" class="button-secondary" id="delete_customer" value="Delete Customer(s)" style="margin-left:100px;" onclick="return confirmDelete();">
</form>
    <?php if($items > 0) { ?>
        <div class="tablenav">
    	<div class='tablenav-pages'>
        <?php echo $p->show();  // Echo out the list of paging. ?>
    	</div>
		</div>
<?php } ?>
</div>
<div id="ipn_handler_info" style="display:none">
      <h2>More Info</h2>
      <p>This URL can be used to initiate transactions to test the Instant Payment Notification (IPN). </p>
      <p>PayPal has an <a href="https://developer.paypal.com/us/cgi-bin/devscr?cmd=_ipn-link-session" target="_blank">Instant Payment Notification (IPN) simulator</a>. This is where the URL can be used to test your installation of this program.</p>
      <p>Copy the URL of this link and paste it into the <a href="https://developer.paypal.com/us/cgi-bin/devscr?cmd=_ipn-link-session" target="_blank">Instant Payment Notification (IPN) simulator</a> to test. </p>
    </div>
<?php
}//End function list_attendee_payments
?>
