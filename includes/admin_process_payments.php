<?php
include('pagination.class.php');
function event_process_payments(){
	$org_options = get_option('events_organization_settings');
	global $wpdb;
	$events_detail_tbl = get_option('events_detail_tbl');
	$events_attendee_tbl = get_option('events_attendee_tbl');
	
	//Pagination
	$items = mysql_num_rows(mysql_query("SELECT * FROM ".$events_detail_tbl.";")); // number of total rows in the database
	if($items > 0) {
		$p = new event_regis_pagination;
		$p->items($items);
		$p->limit(30); // Limit entries per page
		$p->target("admin.php?page=admin_reports");
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
}//End pagination
?>
<div id="event_reg_theme" class="wrap">
<div id="icon-options-event" class="icon32"></div><h2>Attendees/Payments</h2>
<h3>Select an event to view attendee details and payments</h3>

<table class="widefat">
<thead>
  <tr>
    <th>Event ID</th>
    <th>Name</th>
    <th>Cost</th>
    <th>Start Date</th>
    <th>End Date</th>
    <th>Status</th>
    <th># Attendees</th>
    <th>Export</th>
    <th>Action</th>
  </tr>
</thead>
<tfoot>
  <tr>
    <th>Event ID</th>
    <th>Name</th>
    <th>Cost</th>
    <th>Start Date</th>
    <th>End Date</th>
    <th>Status</th>
    <th># Attendees</th>
    <th>Export</th>
    <th>Action</th>
  </tr>
</tfoot>
<tbody>
<?php

	$sql = "SELECT * FROM ". $events_detail_tbl. " ORDER BY date(start_date) ".$limit;
	$result = mysql_query($sql);
	if (mysql_num_rows($result) > 0 ) {
		while ($row = mysql_fetch_assoc ($result)){
			$event_id = $row['id'];
			$event_name=$row['event_name'];
			$event_desc = $row['event_desc'];
			$event_description = $row['event_desc'];
			$event_identifier = $row['event_identifier'];
			$event_cost = $row['event_cost'];
			$active = $row['is_active'];
			$start_date = $row['start_date'];
			$end_date = $row['end_date'];
			
			$reg_limit=$row['reg_limit'];
				
			$sql2= "SELECT SUM(quantity) FROM " . $events_attendee_tbl . " WHERE event_id='$event_id'";
			$result2 = mysql_query($sql2);
									
			while($row = mysql_fetch_array($result2)){
				$number_attendees =  $row['SUM(quantity)'];
			}
			if ($number_attendees == '' || $number_attendees == 0){
					$number_attendees = '0';
			}
			
			if ($reg_limit == "" || $reg_limit == " " || $reg_limit == "999"){
					$reg_limit = "&#8734;";
				}
				
			if ($start_date <= date('Y-m-d')){
					$active_event = '<span style="color: #F00; font-weight:bold;">EXPIRED</span>';
				} elseif ($active == "yes"){
					$active_event = '<span style="color: #090; font-weight:bold;">ACTIVE EVENT</span>';
				} else if ($active == "no"){
					$active_event = '<span style="color: #F00; font-weight:bold;">NOT ACTIVE</span>';
				}
	?>
  <tr>
    <td><?php echo $event_id; ?></td>
    <td><?php echo $event_name; ?></td>
    <td><?php echo $org_options['currency_symbol']?><?php echo $event_cost; ?></td>
    <td><?php echo $start_date; ?></td>
    <td><?php echo $end_date; ?></td>
    <td><?php echo $active_event ; ?></td>
    <td><?php echo $number_attendees?> / <?php echo $reg_limit?></td>
    <td><a href="#" onclick="window.location='<?php get_bloginfo('wpurl')."/wp-admin/admin.php?event_regis&id=".$event_id."&export=report&action=payment";?>'">Export To Excel</a></td>
    <td><a href="admin.php?page=admin_reports&event_id=<?php echo $event_id?>&event_admin_reports=list_attendee_payments">View Attendees</a> | <a href="admin.php?page=events&action=edit&id=<?php echo $event_id?>">Edit Event</a> | <a title="View event" href="admin.php?page=events#event-id-<?php echo $event_id?>">View Event</a></td>
  </tr>
  <?php
	}
 } else { ?>
  <tr>
    <td>No Record Found!</td>
  <tr>
    <?php	}?>
  </tbody>
</table>
<div class="tablenav">
    <div class='tablenav-pages'>
        <?php echo $p->show();  // Echo out the list of paging. ?>
    </div>
</div>
</div>
    <?php
	
}//End function event_process_payments
?>
