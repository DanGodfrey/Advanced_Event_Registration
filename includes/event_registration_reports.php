<?php 
//Event Registration Subpage 4 - View Attendees
function event_registration_reports(){

global $wpdb;
$events_detail_tbl = get_option('events_detail_tbl');
$current_event = get_option('current_event');
$events_attendee_tbl = get_option('events_attendee_tbl');


$sql = "SELECT * FROM ". $events_detail_tbl;
$result = mysql_query ($sql);
echo "<p align='center'><p align='left'>SELECT EVENT TO VIEW ATTENDEES:</p><table width = '400'>";
	while ($row = mysql_fetch_assoc ($result))
		{
			$event_id = $row['id'];
			$event_name=$row['event_name'];
		
			echo "<tr><td width='25'></td><td><form name='form' method='post' action='".$_SERVER['REQUEST_URI']."'>";
			echo "<input type='hidden' name='display_action' value='view_list'>";
			echo "<input type='hidden' name='event_id' value='".$row['id']."'>";
			echo "<input type='SUBMIT' value='".$event_name."'></form></td><tr>";
		}
		echo "</table>";
	
		if ( $_REQUEST['display_action'] == 'view_list' ){
			attendee_display_edit();
		}

}
?>