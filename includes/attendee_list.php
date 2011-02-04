<?php 
//List Attendees - used for the {EVENTATTENDEES} tag
function event_attendee_list_run(){
	global $wpdb;
	$events_detail_tbl = get_option('events_detail_tbl');
	$events_attendee_tbl = get_option('events_attendee_tbl');
						
						
	$sql = "SELECT * FROM ". $events_detail_tbl . " WHERE (is_active='yes' OR is_active='Y')";
	$result = mysql_query($sql);
	while ($row = mysql_fetch_assoc ($result))
		{
		$event_id = $row['id'];
		$event_name = $row['event_name'];
		$event_desc = $row['event_desc'];
		echo "<h2>Attendee Listing For: <u>".$event_name."</u></h2>";
		echo htmlspecialchars_decode($event_desc)."<br><br><hr>";
	
	$x=1;					
	$sql  = "SELECT * FROM " . $events_attendee_tbl . " WHERE event_id='$event_id'";
	$eresult = mysql_query($sql);
	while ($erow = mysql_fetch_assoc ($eresult))
		{
	    $id = $erow['id'];
		$lname = $erow['lname'];
		$fname = $erow['fname'];
		
		$city = $erow['city'];
		$country = $erow['state'];
		echo $x. " ) " .$fname." ".$lname." | ".$city." |".$country. "<br>";
		$x++ ;
		}
	}
}?>
