<?php
function event_list_attendees(){
						//Displays attendee information from current active event.
									global $wpdb;
									$events_detail_tbl = get_option('events_detail_tbl');
									$events_attendee_tbl = get_option('events_attendee_tbl');
									
					             if ($_REQUEST['event_id'] !=""){$view_event = $_REQUEST['event_id'];}
					             if ($_REQUEST['view_event'] !=""){$view_event = $_REQUEST['view_event'];}
					
						$sql = "SELECT * FROM ". $events_detail_tbl . " WHERE id='$view_event'";
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
						$sql  = "SELECT * FROM " . $events_attendee_tbl . " WHERE event_id='$view_event'";
						$result = mysql_query($sql);
						echo "<hr><br><strong>Current Attendee List is from: ".$event_name." - ".$event_identifier."     </strong>";
						?>
<button style="background-color:lightgreen; width:200px; height: 40px" onclick="window.location='<?php get_bloginfo('wpurl')."/wp-admin/admin.php?event_regis&id=".$view_event."&export=report&action=excel";  ?>'" > Export Current Attendee List To Excel </button>
<br>
<hr>
<table width="80%">
  <thead>
    <tr>
      <th width="15"></th>
      <th>ID </th>
      <th>Name </th>
      <th>Email </th>
      <th>City</th>
      <th>State </th>
      <th>Phone </th>
      <th></th>
      <th></th>
    </tr>
  <tbody>
    <?php						while ($row = mysql_fetch_assoc ($result))
									{
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
									$quantity = $row['quantity'];
									$payment_date = $row['payment_date'];
									$event_id = $row['event_id'];
									$custom1 = $row['custom_1'];
									$custom2 = $row['custom_2'];
									$custom3 = $row['custom_3'];
									$custom4 = $row['custom_4'];
	?>
    <tr>
      <td width="15" align="center"></td>
      <td align="center"><?php echo $id?></td>
      <td align="center"><?php echo $lname?>
        ,
        <?php echo $fname?></td>
      <td align="center"><?php echo $email?></td>
      <td width="15" align="center"><?php echo $city?></td>
      <td align="center"><?php echo $state?></td>
      <td align="center"><?php echo $phone?></td>
      <td align="center"><form name="form" method="post" action="<?php echo $_SERVER["REQUEST_URI"]?>">
          <input type="hidden" name="display_action" value="view_list">
          <input type="hidden" name="view_event" value="<?php echo $view_event?>">
          <input type="hidden" name="form_action" value="edit_attendee">
          <input type="hidden" name="id" value="<?php echo $id?>">
          <input type="SUBMIT" style="background-color:yellow" value="EDIT RECORD">
        </form></td>
      <td align="center"><form name="form" method="post" action="<?php echo $_SERVER["REQUEST_URI"]?>">
          <input type="hidden" name="form_action" value="edit_attendee">
          <input type="hidden" name="display_action" value="view_list">
          <input type="hidden" name="attendee_action" value="delete_attendee">
          <input type="hidden" name="view_event" value="<?php echo $view_event?>">
          <input type="hidden" name="id" value="<?php echo $id?>">
          <input type="SUBMIT" style="background-color:pink" value="DELETE" onclick="return confirm
										('Are you sure you want to delete record for <?php echo $fname?> <?php echo $lname?> - ID <?php echo $id?>?')">
        </form></td>
    </tr>
    <?php 	} ?>
  </tbody>
  <tfoot>
  <td></td>
    <td align="center"><strong>ID </strong></td>
    <td align="center"><strong>Name </strong></td>
    <td align="center"><strong>Email </strong></td>
    <td align="center"><strong>City</strong></td>
    <td align="center"><strong>State </strong></td>
    <td align="center"><strong>Phone </strong></td>
    <td></td>
    <td></td>
</table>
<?php 	}?>
