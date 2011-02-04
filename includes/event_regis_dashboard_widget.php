<?php //Admin Dashboard Widget

//add_option('event_regis_dashboard_stats',$event_regis_dashboard_stats);
//$event_regis_dashboard_stats = event_regis_mod_remslashes($_POST['event_regis_dashboard_stats']);
//        update_option('event_regis_dashboard_stats',$event_regis_dashboard_stats);
//$event_regis_dashboard_stats = get_option('event_regis_dashboard_stats');
/*
$event_regis_dso_off = '';
    $event_regis_dso_activitybox = '';
    $event_regis_dso_separatewidget = '';
$event_regis_dso_off = '';
    $event_regis_dso_activitybox = '';
    $event_regis_dso_separatewidget = '';
    
    switch(strtolower($event_regis_dashboard_stats)) {
        case 'off':
            $event_regis_dso_off = ' checked="checked" ';
        break;        
        case 'abox':
            $event_regis_dso_activitybox = ' checked="checked" ';
        break;        
        case 'widget':
            $event_regis_dso_separatewidget = ' checked="checked" ';
        break;        
    }

<input class="event_regis_bnone" style="float:left; margin-right:5px; margin-top: 5px;" type="checkbox" name="event_regis_cron_clean_unsubscribed_every_week" value="1" <?php echo $event_regis_cron_clean_unsubscribed_every_week ? 'checked="checked"' : ''?> /><label style="float:left; line-height:22px; vertical-align:middle;" for="event_regis_cron_clean_unsubscribed_every_week">Delete subscribers who didn't confirm their subscription within 7 days</label><br style="clear:both;" />
                    <fieldset style="border: 1px solid #C6D9E9; margin: 10px 0; padding: 5px 0 5px 3px; width: 500px;">
                    <legend>Plugin statistics on the dashboard</legend>
                        <input class="event_regis_bnone" <?php echo $event_regis_dso_off; ?> style="float:left; margin-right:5px; margin-top: 5px;" type="radio" name="event_regis_dashboard_stats" value="off" />
                        <label style="float:left; line-height:22px; vertical-align:middle;">Do not show</label><br style="clear:both;" />
                        <input class="event_regis_bnone" <?php echo $event_regis_dso_activitybox; ?> style="float:left; margin-right:5px; margin-top: 5px;" type="radio" name="event_regis_dashboard_stats" value="abox" />
                        <label style="float:left; line-height:22px; vertical-align:middle;">Show in the activity box (Right Now)</label><br style="clear:both;" />
                        <input class="event_regis_bnone" <?php echo $event_regis_dso_separatewidget; ?> style="float:left; margin-right:5px; margin-top: 5px;" type="radio" name="event_regis_dashboard_stats" value="widget" />
                        <label style="float:left; line-height:22px; vertical-align:middle;">Show in the separate widget</label><br style="clear:both;" />
                    </fieldset>
*/
$event_regis_dashboard_stats = get_option('event_regis_dashboard_stats');
$event_regis_dashboard_stats = 'abox';
switch(strtolower($event_regis_dashboard_stats)) {
        case 'abox':
            // activity box
            add_action('activity_box_end', 'event_regis_admin_latest_activity');            
        break;        
        case 'widget':
            // separate widget  
			add_action('wp_dashboard_setup', 'event_regis_register_dashboard_widget');
			add_filter('wp_dashboard_widgets', 'event_regis_add_dashboard_widget');
        break;        
    }

### Function: Register Dashboard Widget

function event_regis_register_dashboard_widget() {
    //global $event_regis_full_plugin_name;    
    wp_register_sidebar_widget('dashboard_event_regis', __('Event Registration with PayPal IPN', 'Event Registration with PayPal IPN'), 'dashboard_event_regis',    
        array(
        'width' => 'half', // OR 'fourth', 'third', 'half', 'full' (Default: 'half')
        'height' => 'single', // OR 'single', 'double' (Default: 'single')
        )
    );
}

### Function: Add Dashboard Widget
function event_regis_add_dashboard_widget($widgets) {
    global $wp_registered_widgets;
    if (!isset($wp_registered_widgets['dashboard_event_regis'])) {
        return $widgets;
    }
	$w1 = array_slice($widgets,0,1);
	$w2 = array_slice($widgets,1);
	return array_merge($w1,array('dashboard_event_regis'),$w2);
    
    //$widgets[] = array('dashboard_event_regis');
    
    //return $widgets;
}


function event_regis_get_stats($opt){
    global $wpdb;
    switch($opt){
        case 'total_attendees':
            $sql = "SELECT count(id) FROM ".get_option('events_attendee_tbl');
        break;               
        case 'total_events':
            $sql = "SELECT count(id) FROM ".get_option('events_detail_tbl') ." WHERE (is_active='yes' OR is_active='Y') AND start_date >= '".date ( 'Y-m-d' )."'";        
        break;   
		case 'total_sales':
            $sql = "SELECT sum(amount_pd) FROM ".get_option('events_attendee_tbl')." WHERE amount_pd != '' OR amount_pd != '0.00'";        
        break;
		case 'total_paid':
            $sql = "SELECT count(id) FROM ".get_option('events_attendee_tbl')." WHERE amount_pd != '' OR amount_pd != '0.00'";        
        break;
		case 'total_not_paid':
            $sql = "SELECT count(id) FROM ".get_option('events_attendee_tbl')." WHERE amount_pd = '' OR amount_pd = '0.00'";        
        break;
    }
    $res = $wpdb->get_var($wpdb->prepare($sql));
    
    return $res;
}

### Function: Print Dashboard Widget
function dashboard_event_regis($sidebar_args) {
    global $wpdb;    
	$org_options = get_option('events_organization_settings');
    if (is_array($sidebar_args)){
        extract($sidebar_args, EXTR_SKIP);
    }
    echo $before_widget;
    echo $before_title;
    echo $widget_name;
    echo $after_title;
    
        //global $event_regis_plugindir;
        echo '<div>';
        echo '<div class="youhave" style="clear:both; overflow:hidden;">';        
        echo '<p class="event-regis_sub" style="margin: 0; float:left;">Events stats</p>';
        echo '<a style="line-height:140%; float:right" href="admin.php?page=admin_reports">View Attendees/Payments</a>';
        echo '</div>';        
        
        //$admin_current_event = event_regis_get_current_event('current_event');
        $admin_total_events = event_regis_get_stats('total_events');
        $admin_total_attendees = event_regis_get_stats('total_attendees');        
		$admin_total_event_sales = event_regis_get_stats('total_sales');
		$admin_total_total_paid = event_regis_get_stats('total_paid');
		$admin_total_total_not_paid = event_regis_get_stats('total_not_paid');
        
?>
        <div style="overflow-y: auto;">     
        <table style="width:auto;" class="event-regis-dboard-summary">
            <thead>
                <tr>
                    <th>Total Active Events</th>
                    <th>All Time Attendees</th>
                    <th>All Time Paid</th>
                    <th>All Time Not Paid</th>
					<th>All Time Payments</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $admin_total_events?></td>
                    <td><?php echo $admin_total_attendees?></td>
                    <td style="color: orange;"><?php echo $admin_total_total_paid?></td>
                    <td style="color: red;"><?php echo $admin_total_total_not_paid?></td>
                    <td style="color: green;"><?php echo $org_options['currency_symbol'].$admin_total_event_sales?></td>
                </tr>
                
            </tbody>
        </table></div></div>
		<?php

    echo $after_widget;
}

//Add the Event Registration stats to the admin dashboard under the latest activity box
function event_regis_admin_latest_activity() {
	$org_options = get_option('events_organization_settings');
        echo '<div style="margin-top:10px;">';
        echo '<div class="youhave" style="clear:both; overflow:hidden;">';        
        echo '<p class="event-regis_sub" style="margin: 0; float:left; font-weight: bold;">Event Registration with PayPal IPN</p>';
        echo '<a style="line-height:140%; float:right" href="admin.php?page=admin_reports">View Attendees/Payments</a>';
        echo '</div>';        
        
         //$admin_current_event = event_regis_get_current_event('current_event');
        $admin_total_events = event_regis_get_stats('total_events');
        $admin_total_attendees = event_regis_get_stats('total_attendees');
		$admin_total_event_sales = event_regis_get_stats('total_sales');
		$admin_total_total_paid = event_regis_get_stats('total_paid');
		$admin_total_total_not_paid = event_regis_get_stats('total_not_paid');        
?>
        <div style="overflow-y: auto;">     
        <table style="width:auto;" class="event-regis-dboard-summary">
            <thead>
                <tr>
                     <th>Total Active Events</th>
                    <th>All Time Attendees</th>
                    <th>All Time Paid</th>
                    <th>All Time Not Paid</th>
					<th>All Time Payments</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                     <td><?php echo $admin_total_events?></td>
                    <td><?php echo $admin_total_attendees?></td>
                    <td style="color: orange;"><?php echo $admin_total_total_paid?></td>
                    <td style="color: red;"><?php echo $admin_total_total_not_paid?></td>
                    <td style="color: green;"><?php echo $org_options['currency_symbol'].$admin_total_event_sales?></td>
                </tr>
             </tbody>
             </table>   
           <table style="width:99%;" class="event-regis-dboard-summary">
            <thead>
                <tr  style="text-align:left">
                     <th>Next 3 Upcoming Events</th>
                     </tr>
                     </thead>
                     <tbody>
               
               <?php 
			  $sql = "SELECT * FROM ".get_option('events_detail_tbl')." WHERE (is_active='yes' OR is_active='Y') AND start_date >= '".date ( 'Y-m-d' )."' ORDER BY date(start_date) LIMIT 3"; 
			  $result = mysql_query ($sql);
			  while ($row = mysql_fetch_assoc ($result)){
				$event_id=$row['id'];
				$event_name=$row['event_name'];   
				$reg_limit = $row['reg_limit'];
				$start_date =$row['start_date'];
	
				
				$sql2= "SELECT SUM(quantity) FROM " . get_option('events_attendee_tbl') . " WHERE event_id='$event_id'";
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
				?>
                
                <tr>
                	<td style="text-align:left; padding:2px">
                    <a title="View event" href="admin.php?page=events#event-id-<?php echo $event_id?>"><?php echo $event_name?></a> | Start Date: <?php event_date_display($start_date)?> <?php echo $start_time?> | Attendees: <?php echo $number_attendees?> / <?php echo $reg_limit?> <?php echo $active_event?>
                    </td>
                </tr>
                <?php
			  }
			   ?>
            </tbody>
        </table></div></div>
		<?php

  }
?>
