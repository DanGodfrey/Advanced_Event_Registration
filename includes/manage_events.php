<?php
//Event Registration Subpage 2 - Add/Delete/Edit Events
function event_regis_manage_events(){    
?>
<div id="event_reg_theme" class="wrap">
<div id="icon-options-event" class="icon32"></div><h2>Event Management</h2>
<?php 
	
	//function to delete event
	function delete_event(){
		global $wpdb;
	
		if ( $_REQUEST['action'] == 'delete' ){
			$id=$_REQUEST['id'];
			$sql="DELETE FROM ".get_option('events_detail_tbl')." WHERE id='$id'";
		}
		
		if ($wpdb->query($wpdb->prepare($sql))){?>
            <div id="message" class="updated fade"><p><strong>The event has been deleted.</strong></p></div>
    <?php }else { ?>
            <div id="message" class="error"><p><strong>There was an error in your submission, please try again. The event was not deleted!<?php print mysql_error() ?>.</strong></p></div>
    <?php }
	}
// Adds an Event or Function to the Event Database
function add_event_funct_to_db(){
	global $wpdb;
	if (isset($_POST['Submit'])){
	if ( $_REQUEST['action'] == 'add' ){
		$event_name= esc_html($_REQUEST['event']);
		$event_identifier=($_REQUEST['event_identifier'] == '') ? $event_identifier = sanitize_title_with_dashes($event_name.'-'.time()) : $event_identifier = sanitize_title_with_dashes($_REQUEST['event_identifier']);
		$event_desc_new= esc_html($_REQUEST['event_desc_new']); 
		$display_desc=$_REQUEST['display_desc'];
		$reg_limit=$_REQUEST['reg_limit'];
		$allow_multiple=$_REQUEST['allow_multiple'];
		$event_cost = $_REQUEST['cost'];
		$is_active = $_REQUEST['is_active'];
		$start_time = $_REQUEST['start_time'];
		$start_time_am_pm = $_REQUEST['start_time_am_pm'];
		$start_time = $start_time." ".$start_time_am_pm;
		$end_time = $_REQUEST['end_time'];
		$end_time_am_pm = $_REQUEST['end_time_am_pm'];
		$end_time = $end_time." ".$end_time_am_pm;
		$conf_mail=esc_html($_REQUEST['conf_mail']);
		$send_mail=$_REQUEST['send_mail'];
		$use_coupon_code=$_REQUEST['use_coupon_code'];
		$coupon_code=$_REQUEST['coupon_code'];
		$coupon_code_price=$_REQUEST['coupon_code_price'];
		$use_percentage=$_REQUEST['use_percentage'];
		$event_category = serialize($_REQUEST['event_category']);
		
		$start_date =$_REQUEST['start_date'];
		$end_date =$_REQUEST['end_date'];
		
		if ($reg_limit == ''){
			$reg_limit = 999;
		}
	
		/*//Post the new event into the database
		$sql="INSERT INTO ".get_option('events_detail_tbl')." (event_name, event_desc, display_desc, event_identifier, start_month, start_day, start_year, start_date, start_time, end_month, end_day, end_year, end_date, end_time, reg_limit, allow_multiple, event_cost, send_mail, is_active, question1, question2, question3, question4, conf_mail, use_coupon_code, coupon_code, coupon_code_price, use_percentage, category_id) VALUES('$event_name', '$event_desc_new', '$display_desc', '$event_identifier', '$start_month', '$start_day', '$start_year', '$start_date', '$start_time', '$end_month', '$end_day', '$end_year', '$end_date', '$end_time', '$reg_limit', '$allow_multiple', '$event_cost', '$send_mail', '$is_active', '$question1', '$question2', '$question3', '$question4', '$conf_mail', '$use_coupon_code', '$coupon_code', '$coupon_code_price', '$use_percentage', '$event_category')";

	if ($wpdb->query($wpdb->prepare($sql))){?>*/
	
	$sql=array('event_name'=>$event_name, 'event_identifier'=>$event_identifier, 'reg_limit'=>$reg_limit, 'allow_multiple'=>$allow_multiple, 'event_desc'=>$event_desc_new, 'display_desc'=>$display_desc, 'send_mail'=>$send_mail, 'event_cost'=>$event_cost, 'is_active'=>$is_active, 'start_date'=>$start_date, 'end_month'=>$end_month, 'end_day'=>$end_day, 'end_year'=>$end_year, 'end_date'=>$end_date, 'start_time'=>$start_time, 'end_time'=>$end_time, 'conf_mail'=>$conf_mail, 'use_coupon_code'=>$use_coupon_code, 'coupon_code'=>$coupon_code, 'coupon_code_price'=>$coupon_code_price, 'category_id'=>$event_category, 'use_percentage'=>$use_percentage); 
		
		$sql_data = array('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s');
	
	if ($wpdb->insert( get_option('events_detail_tbl'), $sql, $sql_data )){?>
    
    
		<div id="message" class="updated fade"><p><strong>The event <a href="<?php echo $_SERVER["REQUEST_URI"]?>#event-id-<?php echo $wpdb->insert_id;?>"><?php echo stripslashes($_REQUEST['event'])?></a> has been added.</strong></p></div>
<?php }else { ?>
		<div id="message" class="error"><p><strong>There was an error in your submission, please try again. The event was not saved!<?php print mysql_error() ?>.</strong></p></div>
<?php }
	}
}//End add_event_funct_to_db()

if ( $_REQUEST['action'] == 'copy_event' ){
	global $wpdb;
	$event_id = $_REQUEST ['id'];
	
	$sql = "SELECT * FROM ". get_option('events_detail_tbl') ." WHERE id =" . $event_id;
		$result = mysql_query ($sql);

		while ($row = mysql_fetch_assoc ($result)){
				$event_id= $row['id'];
				$event_name=$row['event_name'];
				$event_desc=$row['event_desc'];
				$display_desc=$row['display_desc'];
				$event_identifier=$row['event_identifier'].'-'.time();
				$reg_limit = $row['reg_limit'];
				$allow_multiple = $row['allow_multiple'];
				$start_date =$row['start_date'];
				$end_date =$row['end_date'];
				$start_time = $row['start_time'];
				$end_time = $row['end_time'];
				$cost=$row['event_cost'];
				$active=$row['is_active'];
				$send_mail= $row['send_mail'];
				$conf_mail= $row['conf_mail'];
				$use_coupon_code= $row['use_coupon_code'];
				$coupon_code = $row['coupon_code'];
				$coupon_code_price = $row['coupon_code_price'];
				$use_percentage = $row['use_percentage'];
				$event_category = $row['category_id'];
		
		/*$sql="INSERT INTO ".get_option('events_detail_tbl')." (event_name, event_desc, display_desc, event_identifier, start_month, start_day, start_year, start_date, start_time, end_month, end_day, end_year, end_date, end_time, reg_limit, allow_multiple, event_cost, send_mail, is_active, question1, question2, question3, question4, conf_mail, use_coupon_code, coupon_code, coupon_code_price, use_percentage, category_id) VALUES('$event_name', '$event_desc_new', '$display_desc', '$event_identifier', '$start_month', '$start_day', '$start_year', '$start_date', '$start_time', '$end_month', '$end_day', '$end_year', '$end_date', '$end_time', '$reg_limit', '$allow_multiple', '$event_cost', '$send_mail', '$is_active', '$question1', '$question2', '$question3', '$question4', '$conf_mail', '$use_coupon_code', '$coupon_code', '$coupon_code_price', '$use_percentage', '$event_category')";
		}

	if ($wpdb->query($wpdb->prepare($sql))){?>*/
	
	$sql=array('event_name'=>$event_name, 'event_identifier'=>$event_identifier, 'reg_limit'=>$reg_limit, 'allow_multiple'=>$allow_multiple, 'event_desc'=>$event_desc, 'display_desc'=>$display_desc, 'send_mail'=>$send_mail, 'event_cost'=>$event_cost, 'is_active'=>$is_active, 'start_date'=>$start_date, 'end_month'=>$end_month, 'end_day'=>$end_day, 'end_year'=>$end_year, 'end_date'=>$end_date, 'start_time'=>$start_time, 'end_time'=>$end_time, 'conf_mail'=>$conf_mail, 'use_coupon_code'=>$use_coupon_code, 'coupon_code'=>$coupon_code, 'coupon_code_price'=>$coupon_code_price, 'category_id'=>$event_category, 'use_percentage'=>$use_percentage); 
	}
		$sql_data = array('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s');
	
	if ($wpdb->insert( get_option('events_detail_tbl'), $sql, $sql_data )){?>
		<div id="message" class="updated fade"><p><strong>The event <a href="<?php echo $_SERVER["REQUEST_URI"]?>#event-id-<?php echo $wpdb->insert_id;?>"><?php echo stripslashes($event_name)?></a> has been added.</strong></p></div>
<?php }else { ?>
		<div id="message" class="error"><p><strong>There was an error in your submission, please try again. The event was not saved!<?php print mysql_error() ?>.</strong></p></div>
<?php }
	}

	if ( $_REQUEST['action'] == 'update' ){
		$id=$_REQUEST['id'];
		$event_name=esc_html($_REQUEST['event']);
		$event_identifier=($_REQUEST['event_identifier'] == '') ? $event_identifier = sanitize_title_with_dashes($event_name.'-'.time()) : $event_identifier = sanitize_title_with_dashes($_REQUEST['event_identifier']);
		$event_desc=esc_html($_REQUEST['event_desc']); 
		$display_desc = $_REQUEST['display_desc'];
		$reg_limit=$_REQUEST['reg_limit'];
		$allow_multiple=$_REQUEST['allow_multiple'];
		$cost = $_REQUEST['cost'];
		$is_active = $_REQUEST['is_active'];
		$start_time = $_REQUEST['start_time'];
		$start_time_am_pm = $_REQUEST['start_time_am_pm'];
		$start_time = $start_time." ".$start_time_am_pm;
		$end_time = $_REQUEST['end_time'];
		$end_time_am_pm = $_REQUEST['end_time_am_pm'];
		$end_time = $end_time." ".$end_time_am_pm;

		$conf_mail=esc_html($_REQUEST['conf_mail']);
		$send_mail=$_REQUEST['send_mail'];
		$use_coupon_code=$_REQUEST['use_coupon_code'];
		$coupon_code=$_REQUEST['coupon_code'];
		$coupon_code_price=$_REQUEST['coupon_code_price'];
		$use_percentage=$_REQUEST['use_percentage'];
		$event_category = serialize($_REQUEST['event_category']);
		
		$start_date =$_REQUEST['start_date'];
		$end_date =$_REQUEST['end_date'];
		
		if ($reg_limit == ''){
			$reg_limit = 999;
		}

		/*$sql="UPDATE ".get_option('events_detail_tbl')." SET event_name='$event_name', event_identifier='$event_identifier', reg_limit='$reg_limit', allow_multiple='$allow_multiple', event_desc='$event_desc', display_desc='$display_desc', send_mail='$send_mail', event_cost='$cost', is_active='$is_active', start_month='$start_month', start_day='$start_day', start_year='$start_year', start_date='$start_date', end_month='$end_month', end_day='$end_day', end_year='$end_year', end_date='$end_date', start_time='$start_time', end_time='$end_time', question1='$quest1', question2='$quest2', question3='$quest3', question4='$quest4', conf_mail='$conf_mail', use_coupon_code='$use_coupon_code', coupon_code='$coupon_code', coupon_code_price='$coupon_code_price', category_id='$event_category', use_percentage='$use_percentage'  WHERE id = $id";
	
	if ($wpdb->query($wpdb->prepare($sql))){?>*/
	
	$sql=array('event_name'=>$event_name, 'event_identifier'=>$event_identifier, 'reg_limit'=>$reg_limit, 'allow_multiple'=>$allow_multiple, 'event_desc'=>$event_desc, 'display_desc'=>$display_desc, 'send_mail'=>$send_mail, 'event_cost'=>$cost, 'is_active'=>$is_active, 'start_date'=>$start_date, 'end_month'=>$end_month, 'end_day'=>$end_day, 'end_year'=>$end_year, 'end_date'=>$end_date, 'start_time'=>$start_time, 'end_time'=>$end_time, 'conf_mail'=>$conf_mail, 'use_coupon_code'=>$use_coupon_code, 'coupon_code'=>$coupon_code, 'coupon_code_price'=>$coupon_code_price, 'category_id'=>$event_category, 'use_percentage'=>$use_percentage); 
		$update_id = array('id'=> $id);
		
		$sql_data = array('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s');
	
	if ($wpdb->update( get_option('events_detail_tbl'), $sql, $update_id, $sql_data, array( '%d' ) )){?>
	<div id="message" class="updated fade"><p><strong>Event details saved for <a href="<?php echo $_SERVER["REQUEST_URI"]?>#event-id-<?php echo $_REQUEST['id']?>"><?php echo stripslashes($_REQUEST['event'])?></a>. Maybe you would consider making a <a href="http://www.shoultes.net/wordpress-events-registration-with-paypal-ipn#donate" target="_blank">donation</a>?</strong></p></div>
<?php }else { ?>
	<div id="message" class="error"><p><strong>There was an error in your submission, please try again. The event was not saved! <?php print mysql_error() ?>.</strong></p></div>
<?php
}

	}

		  	//function to display events
	function display_event_details($all = 0) {
		$org_options = get_option('events_organization_settings');
		?>
       <div style="float:right; margin-right:20px;">
  <form name="form" method="post" action="<?php echo $_SERVER["REQUEST_URI"]?>">
    <input type="hidden" name="action" value="add_new_event">
    <input type="hidden" name="id" value="<?php echo $event_id?>">
    <input class="button-primary" type="submit" name="add_new_event" value="Add New Event"/>
  </form>
</div> <h3>Current Events</h3> 

		<?php
		$curdate = date("Y-m-d");
		$sql = "SELECT * FROM ". get_option('events_detail_tbl') ." ORDER BY date(start_date) ASC";
		$result = mysql_query ($sql);

		while ($row = mysql_fetch_assoc ($result)){
				$event_id= $row['id'];
				$event_name=stripslashes($row['event_name']);
				$event_desc=stripslashes($row['event_desc']);
				$display_desc=stripslashes($row['display_desc']);
				$event_identifier=$row['event_identifier'];
				$reg_limit = $row['reg_limit'];
				$allow_multiple = $row['allow_multiple'];
				$start_date =$row['start_date'];
				$end_date =$row['end_date'];
				$start_time = $row['start_time'];
				$end_time = $row['end_time'];
				$cost=$row['event_cost'];
				$active=$row['is_active'];
				
				$send_mail= $row['send_mail'];
				$conf_mail= $row['conf_mail'];
				$use_coupon_code= $row['use_coupon_code'];
				$coupon_code = $row['coupon_code'];
				$coupon_code_price = $row['coupon_code_price'];
				$use_percentage = $row['use_percentage'];
				$event_category = unserialize($row['category_id']);
											
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
				
				if ($start_date <= date('Y-m-d')){
					$active_event = '<span style="color: #F00; padding-left:30px; font-weight:bold;">EXPIRED</span>';
				} elseif ($active == "yes"){
					$active_event = '<span style="color: #090; padding-left:20px; font-weight:bold;">ACTIVE EVENT</span>';
				} else if ($active == "no"){
					$active_event = '<span style="color: #F00; padding-left:30px; font-weight:bold;">NOT ACTIVE</span>';
				}
?>

	<div class="metabox-holder">
  <div class="postbox">	
  <h3><a id="event-id-<?php echo $event_id?>" name="event-id-<?php echo $event_id?>" title="View event page" href="<?php echo get_option('siteurl')?>/?page_id=<?php echo  $org_options['event_page_id']?>&regevent_action=register&event_id=<?php echo $event_id?>&name_of_event=<?php echo $event_name?>" target="_blank"><?php echo $event_name?></a> | Start Date: <?php echo event_date_display($start_date)?> <?php echo $start_time?> | End Date: <?php echo event_date_display($end_date)?> <?php echo $end_time?> | Attendees: <?php echo $number_attendees?> / <?php echo $reg_limit?> <?php echo $active_event?></h3>
<ul>
  <li>
<div style="float:left">
  <form name="form" method="post" action="<?php echo $_SERVER["REQUEST_URI"]?>">
    <input type="hidden" name="action" value="edit">
    <input type="hidden" name="id" value="<?php echo $event_id?>">
    <input class="button-primary" type="submit" name="edit" value="Edit this Event" id="edit_event_setting-<?php echo $event_id?>" />
  </form>
</div>
<div style="float:left; margin-left:20px;">
            <form name="form" method="post" action="<?php echo $_SERVER["REQUEST_URI"]?>">
              <input type="hidden" name="action" value="copy_event">
              <input type="hidden" name="id" value="<?php echo $event_id?>">
              <input class="button-primary" type="submit" name="copy" value="Copy This Event" id="copy_event_setting-<?php echo $event_id?>"  onclick="return confirm('Are you sure you want to copy <?php echo $event_name?>?')"/>
            </form>
        </div>
<div style="float:left; margin-left:20px;">
  <form name="form" method="post" action="<?php echo $_SERVER["REQUEST_URI"]?>">
    <input type="hidden" name="action" value="delete">
    <input type="hidden" name="id" value="<?php echo $event_id?>">
    <input class="button-primary" type="submit" name="delete" value="Delete This Event" id="delete_event-<?php echo $event_id?>" onclick="return confirm('Are you sure you want to delete <?php echo $event_name?>?')"/>
  </form>
</div>
<div style="float:left; margin-left:20px;">
  <form name="form" method="post" action="<?php echo $_SERVER["REQUEST_URI"]?>">
    <input type="hidden" name="action" value="add_new_event">
    <input type="hidden" name="id" value="<?php echo $event_id?>">
    <input class="button-primary" type="submit" name="add_new_event" value="Add New Event" id="add_new_event-<?php echo $event_id?>"/>
  </form>
</div>
<div style="float:left; margin-left:20px;">
<form name="form" method="post" action="admin.php?page=admin_reports&event_admin_reports=list_attendee_payments">
    <input type="hidden" name="event_id" value="<?php echo $event_id?>">
    <input class="button-primary" <?php if ($number_attendees == '0'){echo 'disabled="disabled" value="No Attendees"';}else {echo 'value="View Attendees"';}?> type="submit" name="add_new_event"  id="view_event_attendees"/>
  </form>
</div>
<button style="margin-left:20px" class="button-primary" <?php if ($number_attendees == '0'){echo 'disabled="disabled" value="No Attendees"';}else {echo 'value="View Attendees"';}?> onclick="window.location='<?php echo get_bloginfo('wpurl')."/wp-admin/admin.php?event_regis&id=".$event_id."&export=report&action=payment";?>'">Export Payment List to Excel </button>
<div style="clear:both"></div>

<div class="col-container">
<div class="col-right">
<p><strong>Do you want to display the event description on registration page?</strong>
      
      <?php
		if ($display_desc =="Y"){
			echo "Yes";
		}
		if ($display_desc =="N"){
			echo "No";
		}
?>
    </p>
    <p><strong>Event Description:</strong></p>
    <?php
		if ($display_desc ==""){
			echo " <p class='red_text'><strong><i>PLEASE UPDATE THIS EVENT</i></strong></p>";
		}
?>		
    <?php echo htmlspecialchars_decode($event_desc)?>
    <p><strong>Send custom confirmation messages for this event?</strong>
      
      <?php 
	  if ($send_mail ==""){
			echo "<p class='red_text'><strong><i>PLEASE UPDATE THIS EVENT</i></strong>";
		}
		if ($send_mail =="Y"){
			echo "Yes";
		}
		if ($send_mail =="N"){
			echo "No</p>";
		}
?>
  <p><strong>Custom Confirmation Mail:</strong></p>
    <?php echo htmlspecialchars_decode($conf_mail)?>
</div>
  <div id="col-left">
  <p><strong>Event Identifier:</strong> <?php echo $event_identifier?> 
    <a class="ev_reg-fancylink" href="#unique_id_info"><img src="<?php echo EVNT_RGR_PLUGINFULLURL?>/images/question-frame.png" width="16" height="16" /></a></p>
    
    <p><strong>Cost:</strong> <?php echo $org_options['currency_symbol']?><?php echo $cost?>
    </p>
    <p><strong>Allow promo codes for this event?</strong> <?php echo $use_coupon_code?> <a class="ev_reg-fancylink" href="#coupon_code_info"><img src="<?php echo EVNT_RGR_PLUGINFULLURL?>/images/question-frame.png" width="16" height="16" /></a> </p>
    <p><strong>Promo Code:</strong> <?php echo $coupon_code?></p>
    <p><strong>Discount w/Promo Code:</strong> -$<?php echo $coupon_code_price?> </p>
     <li><strong>Percentage Discount? <?php echo $use_percentage?></strong> </li>
    <p><strong>Allow payment for more than one person at a time? (max # people 5)</strong>: <?php echo $allow_multiple?></p>
    
    <p><strong>Event Categories:</strong></p>
   <?php  if (is_array($event_category)){
					?>
                    <ul style="padding:0;">
                    <?php
				foreach ($event_category as $category){
					
						$sql2= "SELECT * FROM " . get_option('events_category_detail_tbl') . " WHERE id = '$category[0]'";
						$result2 = mysql_query($sql2);
						while($row = mysql_fetch_assoc($result2)){
							$category_id= $row['id'];
							$category_identifier=$row['category_identifier'];

							echo '<li>'.$row['category_name']." ".'<a class="ev_reg-fancylink" href="#unique_id_info-'.$category_id.'"><img src="'.EVNT_RGR_PLUGINFULLURL.'/images/question-frame.png" width="16" height="16" /></a></li><div id="unique_id_info-'.$category_id.'" style="display:none">
      <h2>Category Shortcode for '.$row['category_name'].'</h2>
      <p>Use this shortcode to display all events assigned to this category:<br />
[EVENT_REGIS_CATEGORY event_category_id="'.$category_identifier.'"]</p>
    </div>';
						}
					}
					?>
                   </ul> 
             <?php	} else {
				 echo '<p>No category selected</p>';
				}?>
    <div style=" border:#999 1px solid; background:#E6E6E6; padding:10px; margin:10px 0;">  <p><strong>Unique Url for this event:</strong><br /> 
    <a href="<?php echo get_option('siteurl')?>/?page_id=<?php echo $org_options['event_page_id']?>&regevent_action=register&event_id=<?php echo $event_id?>&name_of_event=<?php echo $event_name?>" target="_blank"><?php echo get_option('siteurl')?>/?page_id=<?php echo $org_options['event_page_id']?>&amp;regevent_action=register&amp;event_id=<?php echo $event_id?>&amp;name_of_event=<?php echo $event_name?></a></p>
    <p><strong>Shortcode for Page:</strong><br />
      [SINGLEEVENT single_event_id="<?php echo $event_identifier?>"]
      </p>
     
  </div>
   
  </li>
</ul>
</div>
<?php	}

}

//function to edit event
function edit_event(){
	$org_options = get_option('events_organization_settings');
	global $wpdb;			
	$id=$_REQUEST['id'];
	//Query Database for Active event and get variable
	$sql  = "SELECT * FROM " . get_option('events_detail_tbl') . " WHERE id =".$id;
	$result = mysql_query($sql);
	$in_event_category= array();
	while ($row = mysql_fetch_assoc ($result)){
		$event_id = $row['id'];
		$event_name = stripslashes($row['event_name']);
		$event_desc = stripslashes($row['event_desc']);
		$display_desc= $row['display_desc'];
		$event_description = stripslashes($row['event_desc']);
		$event_identifier = stripslashes($row['event_identifier']);
		$start_date =$row['start_date'];
		$end_date =$row['end_date'];
		$start_time = $row['start_time'];
		$end_time = $row['end_time'];
		$reg_limit = $row['reg_limit'];
		$reg_limit_display = $row['reg_limit_display'];
		$allow_multiple = $row['allow_multiple'];
		$event_cost = $row['event_cost'];
		$active = $row['is_active'];
		
		$conf_mail=$row['conf_mail'];
		$send_mail=$row['send_mail'];
		$use_coupon_code=$row['use_coupon_code'];
		$coupon_code = $row['coupon_code'];
		$coupon_code_price = $row['coupon_code_price'];
		$use_percentage = $row['use_percentage'];
		$in_event_category = unserialize($row['category_id']);
		}
		
		$sql2= "SELECT SUM(quantity) FROM " . get_option('events_attendee_tbl') . " WHERE event_id='$event_id'";
				$result2 = mysql_query($sql2);
	
				while($row = mysql_fetch_array($result2)){
					$number_attendees =  $row['SUM(quantity)'];
				}
		if ($number_attendees == '' || $number_attendees == 0){
			$number_attendees = '0';
		}
		
		if ($reg_limit == "" || $reg_limit == " "){
			$reg_limit_display = "&#8734;";
		}else {
			$reg_limit_display = $reg_limit;
		}
		
		if ($start_date <= date('Y-m-d')){
					$active_event = '<span style="color: #F00; padding-left:30px; font-weight:bold;">EXPIRED</span>';
				} elseif ($active == "yes"){
					$active_event = '<span style="color: #090; padding-left:20px; font-weight:bold;">ACTIVE EVENT</span>';
				} else if ($active == "no"){
					$active_event = '<span style="color: #F00; padding-left:30px; font-weight:bold;">NOT ACTIVE</span>';
				}
				
?>
<!--Update event display-->
<div class="metabox-holder">
  <div class="postbox">
    <h3>Edit - <a title="View event page" href="<?php echo get_option('siteurl')?>/?page_id=<?php echo $org_options['event_page_id']?>&regevent_action=register&event_id=<?php echo $event_id?>&name_of_event=<?php echo $event_name?>" target="_blank"><?php echo $event_name?></a> | Start Date: <?php echo event_date_display($start_date)?> <?php echo $start_time?> | End Date: <?php echo event_date_display($end_date)?> <?php echo $end_time?> | Attendees: <?php echo $number_attendees?> / <?php echo $reg_limit_display?> <?php echo $active_event?></h3>
    <form method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
    <input type="hidden" name="action" value="update"> 
      <input type="hidden" name="id" value="<?php echo $event_id?>">
      <div class="col-container">
<div class="col-right">
      <ul>
        
        <li><label><strong>Do you want to display the event description on registration page?</strong></label>
        <?php $values=array(					
        array('id'=>'Y','text'=> __('Yes','event_regis')),
        array('id'=>'N','text'=> __('No','event_regis')));				
		echo select_input('display_desc', $values, $display_desc); ?> 
         
          </li>
        <li> <label><strong>Event Description:</strong></label> <br />
          <textarea rows="5" cols="300" name="event_desc" id="event_desc"  class="my_ed"><?php echo $event_desc?></textarea>
          <br />
          <script>myEdToolbar('event_desc'); </script>
          </li>
        
        <li><?php //dateSelectionBox ( $start_month, $start_day, $start_year, $end_month, $end_day, $end_year ); ?></li>          
        
        <li> <strong>Send A Custom Cofiramtion Eamil For This Event?</strong>
       <?php $values=array(					
        array('id'=>'Y','text'=> __('Yes','event_regis')),
        array('id'=>'N','text'=> __('No','event_regis')));				
		echo select_input('send_mail', $values, $send_mail); ?>
      
          </li>
        <li><strong>Custom Confirmation Email For This Event:</strong> <a class="ev_reg-fancylink" href="#custom_email_info"><img src="<?php echo EVNT_RGR_PLUGINFULLURL?>/images/question-frame.png" width="16" height="16" /></a><br />
          <textarea rows="5" cols="300" name="conf_mail" id="conf_mail"  class="my_ed"><?php echo $conf_mail?></textarea>
          <br />
          <script>myEdToolbar('conf_mail'); </script>
          </li>
        <li>
          <p>
            <input class="button-primary" type="submit" name="Submit" value="<?php _e('Update Event'); ?>" id="save_event_setting" />
            </p>
          </li>
          
        </ul>
</div>
<div class="col-left">
<ul>
<li><label for="event_name"><strong>Event Name:</strong></label>
          <input type="text" name="event" size="25" value ="<?php echo $event_name;?>" /></li>
        <li>
          <label for="event_identifier"><strong>Unique Event Identifier:</strong> </label>
          <input type="text" name="event_identifier" value ="<?php echo $event_identifier;?>" /> <a class="ev_reg-fancylink" href="#unique_id_info"><img src="<?php echo EVNT_RGR_PLUGINFULLURL?>/images/question-frame.png" width="16" height="16" /></a></li>
          <li>
        <p><strong>Event Date(s):</strong></p>
                <div style="float: left;">
                  <div style="float: left; padding-right: 3px; line-height: 18px;"><strong>from</strong></div>
                  <div style="float: left;">
		<?php 
			list($year, $month, $day) = split("-", $start_date);
			$myCalendar = new tc_calendar("start_date", true, false);
			$myCalendar->setIcon(EVNT_RGR_PLUGINFULLURL.'images/iconCalendar.gif');
			$myCalendar->setDate("$day", "$month", "$year");
			$myCalendar->setPath(EVNT_RGR_PLUGINFULLURL);
			$myCalendar->setYearInterval(1970, 2020);
			$myCalendar->setWidth(200); 
			$myCalendar->setHeight(260); 
			$myCalendar->writeScript();
			
	  ?>
      </div>
                </div>
                <div style="float: left;">
                  <div style="float: left; padding-left: 3px; padding-right: 3px; line-height: 18px;"><strong>to</strong></div>
                  <div style="float: left;">
                  <?php 
			list($year, $month, $day) = split("-", $end_date);
			$myCalendar = new tc_calendar("end_date", true, false);
			$myCalendar->setIcon(EVNT_RGR_PLUGINFULLURL.'images/iconCalendar.gif');
			$myCalendar->setDate("$day", "$month", "$year");
			$myCalendar->setPath(EVNT_RGR_PLUGINFULLURL);
			$myCalendar->setYearInterval(1970, 2020);
			$myCalendar->setWidth(200); 
			$myCalendar->setHeight(260); 
			$myCalendar->writeScript();
			
	  ?>
                  </div>
                </div>
                <div style="clear:both;"></div>
      </li>
        
        
        <li><strong>Start Time:</strong>
          <select name="start_time">
            <option name="<?php echo $start_time;?>"><?php echo $start_time;?></option>              
            <option name="1:00">1:00</option>
            <option name="2:00">2:00</option>
            <option name="3:00">3:00</option>
            <option name="4:00">4:00</option>
            <option name="5:00">5:00</option>
            <option name="6:00">6:00</option>
            <option name="7:00">7:00</option>
            <option name="8:00">8:00</option>
            <option name="9:00">9:00</option>
            <option name="10:00">10:00</option>
            <option name="11:00">11:00</option>
            <option name="12:00">12:00</option>
            </select>
          <select name="start_time_am_pm">
            <option name="<?php echo $start_time_am_pm;?>"><?php echo $start_time_am_pm;?></option>
            <option name="AM">AM</option>
            <option name="PM">PM</option>
            </select>
          -  <strong>End Time:</strong>
          <select name="end_time">
            <option name="<?php echo $end_time;?>"><?php echo $end_time;?></option>
            <option name="1:00">1:00</option>
            <option name="2:00">2:00</option>
            <option name="3:00">3:00</option>
            <option name="4:00">4:00</option>
            <option name="5:00">5:00</option>
            <option name="6:00">6:00</option>
            <option name="7:00">7:00</option>
            <option name="8:00">8:00</option>
            <option name="9:00">9:00</option>
            <option name="10:00">10:00</option>
            <option name="11:00">11:00</option>
            <option name="12:00">12:00</option>
            </select>
          <select name="end_time_am_pm">
            <option name="<?php echo $end_time_am_pm;?>">
              <?php echo $end_time_am_pm;?>
              </option>
            <option name="AM">AM</option>
            <option name="PM">PM</option>
          </select></li>
        
        
        <li><strong>Attendee Limit</strong>: <input name="reg_limit" size="10" value ="<?php echo $reg_limit;?>"><br />
(leave blank for unlimited)</li>
        <li><strong>Allow payment for more than one person at a time?</strong> 
         <?php
			$values=array(					
        array('id'=>'Y','text'=> __('Yes','event_regis')),
        array('id'=>'N','text'=> __('No','event_regis')));				
		echo select_input('allow_multiple', $values, $allow_multiple);
		?>
			<br />
        (max # people 5)
		</li>
          <li><strong>Cost of the Event:</strong> <?php echo $org_options['currency_symbol']?><input name="cost" size="10" value ="<?php echo $event_cost;?>"><br />
(leave blank for free events, enter 2 place decimal i.e. <?php echo $org_options['currency_symbol']?>7.00)
          </li>
        <li><strong>Allow promo codes for this event?</strong> 
          <?php $values=array(					
        array('id'=>'Y','text'=> __('Yes','event_regis')),
        array('id'=>'N','text'=> __('No','event_regis')));				
		echo select_input('use_coupon_code', $values, $use_coupon_code); ?>
          <a class="ev_reg-fancylink" href="#coupon_code_info"><img src="<?php echo EVNT_RGR_PLUGINFULLURL?>/images/question-frame.png" width="16" height="16" /></a>
          </li>
        <li><strong>Promo Code for Event:</strong> <input name="coupon_code" size="20" value="<?php echo $coupon_code;?>"><br />
(leave blank for no promo)</li>
        <li><strong>Discount w/Promo Code:</strong> -<?php echo $org_options['currency_symbol']?><input name="coupon_code_price" size="10" value ="<?php echo $coupon_code_price;?>"><br />
(enter 2 place decimal i.e. <?php echo $org_options['currency_symbol']?>7.00.)</li>
        <li><strong>Percentage Discount?</strong> 
	
              <?php
			$values=array(					
        array('id'=>'Y','text'=> __('Yes','event_regis')),
        array('id'=>'N','text'=> __('No','event_regis')));				
		echo select_input('use_percentage', $values, $use_percentage);
		?>
              </li>
        <li><strong>Is this an active event?</strong>
         <?php
			$values=array(					
        array('id'=>'Y','text'=> __('Yes','event_regis')),
        array('id'=>'N','text'=> __('No','event_regis')));				
		echo select_input('is_active', $values, $active);
		?></li>
        <li><strong>Event Category:</strong><br />
		<ul> 
<?php  
            $sql = "SELECT * FROM ". get_option('events_category_detail_tbl');
            $result = mysql_query ($sql);
            
            while ($row = mysql_fetch_assoc ($result)){
                $category_id= $row['id'];
                $category_name=$row['category_name'];
                $checked = ($in_event_category == '') ? '' : in_array( $category_id, $in_event_category);
                echo '<li id="event-category-', $category_id, '"><label for="in-event-category-', $category_id, '" class="selectit"><input value="', $category_id, '" type="checkbox" name="event_category[]" id="in-event-category-', $category_id, '"', ($checked ? ' checked="checked"' : "" ), '/> ', $category_name, "</label></li>";
            }
        ?></ul></li>    
</ul>
</div>
</div>
    </form>
  </div>
  
</div>

<?php
	}
	if ( $_REQUEST['action'] == 'delete' ){delete_event();}
	if ( $_REQUEST['action'] == 'edit' ){edit_event();}

}
function add_new_event(){
	$org_options = get_option('events_organization_settings');
	?>
<!--Add event display-->
<div class="metabox-holder">
  <div class="postbox">
<h3>Add An Event</h3>
  <form method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
  <input type="hidden" name="action" value="add">
<div class="col-container">
<div class="col-right">
   <ul>
   
   <li><strong>Do you want to display the event description on registration page?</strong>
   	<input type="radio" name="display_desc" value="Y">Yes
	<input type="radio" name="display_desc" value="N">No
	</li>
   <li><strong>Event Description:</strong><br />
   <textarea rows="5" cols="300" name="event_desc_new" id="event_desc_new"  class="my_ed"></textarea>
      <br />
      <script>myEdToolbar('event_desc_new'); </script>
   </li>
   <li> <strong>Do you want to send a custom confirmation email?</strong>
	<input type="radio" name="send_mail" value="Y">Yes
	<input type="radio" name="send_mail" value="N">No
   </li>
    <li>Custom Confirmation Email For This Event: <a class="ev_reg-fancylink" href="#custom_email_info"><img src="<?php echo EVNT_RGR_PLUGINFULLURL?>/images/question-frame.png" width="16" height="16" /></a><br />
    <textarea rows='4' cols='125' name='conf_mail' id="conf_mail_new"  class="my_ed"><p>***This is an automated response - Do Not Reply***</p>
<p>Thank you [fname] [lname] for registering for [event].</p>
<p> We hope that you will find this event both informative and enjoyable. Should have any questions, please contact [contact].</p>

<p>If you have not done so already, please submit your payment in the amount of <?php echo htmlentities($org_options['currency_symbol'])?>[cost].</p>
<p>Click here to reveiw your payment information [payment_url].</p>
<p>Thank You.</p></textarea>
      <br />
      <script>myEdToolbar('conf_mail_new'); </script>
</li>   
    
    <li>
    <p>
            <input class="button-primary" type="submit" name="Submit" value="<?php _e('Submit New Event'); ?>" id="add_new_event" />
            </p>
    </li></ul>
    </div>
    <div class="col-left">
 <ul>       
  <li><label><strong>Event Name:</strong></label> <input name="event" size="25"></li>
   <li><label><strong>Unique Event Identifier:</strong></label> <input name="event_identifier"> <a class="ev_reg-fancylink" href="#unique_id_info"><img src="<?php echo EVNT_RGR_PLUGINFULLURL?>/images/question-frame.png" width="16" height="16" /></a></li>
   <li>
        <p><strong>Event Date(s):</strong></p>
                <div style="float: left;">
                  <div style="float: left; padding-right: 3px; line-height: 18px;"><strong>from</strong></div>
                  <div style="float: left;">
		<?php 
			$myCalendar = new tc_calendar("start_date", true, false);
			$myCalendar->setIcon(EVNT_RGR_PLUGINFULLURL.'images/iconCalendar.gif');
			//$myCalendar->setDate(1, 1, 2010);
			$myCalendar->setPath(EVNT_RGR_PLUGINFULLURL);
			$myCalendar->setYearInterval(date('Y'), date('Y')+10);
			$myCalendar->setWidth(200); 
			$myCalendar->setHeight(260); 
			$myCalendar->writeScript();
			
	  ?>
      </div>
                </div>
                <div style="float: left;">
                  <div style="float: left; padding-left: 3px; padding-right: 3px; line-height: 18px;"><strong>to</strong></div>
                  <div style="float: left;">
                  <?php 
			$myCalendar = new tc_calendar("end_date", true, false);
			$myCalendar->setIcon(EVNT_RGR_PLUGINFULLURL.'images/iconCalendar.gif');
			//$myCalendar->setDate(1, 1, 2010);
			$myCalendar->setPath(EVNT_RGR_PLUGINFULLURL);
			$myCalendar->setYearInterval(date('Y'), date('Y')+10);
			$myCalendar->setWidth(200); 
			$myCalendar->setHeight(260); 
			$myCalendar->writeScript();
			
	  ?>
                  </div>
                </div>
                <div style="clear:both;"></div>
      </li>
    <li>
    <strong>Start Time:</strong>
    <select name="start_time">
      <option name="01:00">01:00</option>
      <option name="02:00">02:00</option>
      <option name="03:00">03:00</option>
      <option name="04:00">04:00</option>
      <option name="05:00">05:00</option>
      <option name="06:00">06:00</option>
      <option name="07:00">07:00</option>
      <option name="08:00">08:00</option>
      <option name="09:00">09:00</option>
      <option name="10:00">10:00</option>
      <option name="11:00">11:00</option>
      <option name="12:00">12:00</option>
    </select>
    <select name="start_time_am_pm">
      <option name="AM">AM</option>
      <option name="PM">PM</option>
    </select>
    -  <strong>End Time:</strong>
    <select name="end_time">
      <option name="01:00">01:00</option>
      <option name="02:00">02:00</option>
      <option name="03:00">03:00</option>
      <option name="04:00">04:00</option>
      <option name="05:00">05:00</option>
      <option name="06:00">06:00</option>
      <option name="07:00">07:00</option>
      <option name="08:00">08:00</option>
      <option name="09:00">09:00</option>
      <option name="10:00">10:00</option>
      <option name="11:00">11:00</option>
      <option name="12:00">12:00</option>
    </select>
    <select name="end_time_am_pm">
      <option name="AM">AM</option>
      <option name="PM">PM</option>
    </select>
   </li>
 <li><strong>Attendee Limit:</strong> <input name="reg_limit" size="15"><br />
 (leave blank for unlimited attendees)</li>
    <li><strong>Allow payment for more than one person at a time?</strong>
    <input type="radio" name="allow_multiple" checked="checked" value="Y">Yes
	<input type="radio" name="allow_multiple" value="N">No
    <br />(max # people 5)
    </li>
    <li><strong>Event Cost:</strong>
    <?php echo $org_options['currency_symbol']?><input name="cost" size="10"><br />
(leave blank for free events, enter 2 place decimal i.e. <?php echo $org_options['currency_symbol']?>7.00)</li>
	<li><strong>Allow promo codes for this event?</strong> 
    <input type="radio" name="use_coupon_code" value="Y">Yes
              <input type="radio" name="use_coupon_code" value="N">No
 <a class="ev_reg-fancylink" href="#coupon_code_info"><img src="<?php echo EVNT_RGR_PLUGINFULLURL?>/images/question-frame.png" width="16" height="16" /></a> </li>
    <li><strong>Promo Code:</strong> <input name="coupon_code" size="20" > </li>
    <li><strong>Discount w/Promo Code:</strong> -<?php echo $org_options['currency_symbol']?><input name="coupon_code_price" size="10" >  <br />(enter 2 place decimal i.e. <?php echo $org_options['currency_symbol']?>7.00.)</li>
    
	<li><strong>Percentage Discount?</strong>
              <input type="radio" name="use_percentage" value="Y">Yes
              <input type="radio" name="use_percentage" value="N">No
              </li>
  

      
    <li> <strong>Is this event active?</strong>
      <select name="is_active">
        <option>yes</option>
        <option>no</option>
      </select></li>
      <li><strong>Event Category:</strong><br />
		<ul><?php 
            $sql = "SELECT * FROM ". get_option('events_category_detail_tbl');
            $result = mysql_query ($sql);
            
            while ($row = mysql_fetch_assoc ($result)){
                $category_id= $row['id'];
                $category_name=$row['category_name'];
                //$checked = in_array( $category_id, $in_event_category );
                echo '<li id="event-category-', $category_id, '"><label for="in-event-category-', $category_id, '" class="selectit"><input value="', $category_id, '" type="checkbox" name="event_category[]" id="in-event-category-', $category_id, '"', ($checked ? ' checked="checked"' : "" ), '/> ', $category_name, "</label></li>";
            }
        ?></ul>
        </li> </ul>
      </div>
</div>
  </form>
	</div>
</div>

<?php
}

if ($_REQUEST['action'] == 'add_new_event'){
		add_new_event();
	}
	add_event_funct_to_db();
	display_event_details();
	
?>
</div>
<?php event_regis_admin_footer();?>
 </div>
<div id="coupon_code_info" style="display:none">
  <h2>Coupon/Promo Code</h2>
  <p>This is used to apply discounts to events.</p>
  <p>A coupon or promo code could can be anything you want. For example: Say you have an event that costs <?php echo $org_options['currency_symbol']?>200. If you supplied a promo like "PROMO50" and entered 50.00 into the "Discount w/Promo Code" field your event will be discounted <?php echo $org_options['currency_symbol']?>50.00, Bringing the cost of the event to <?php echo $org_options['currency_symbol']?>150.</p>
</div>
<div id="unique_id_info" style="display:none">
      <h2>Event Identifier</h2>
      <p>This should be a unique identifier for the event. Example: "Event1" (without qoutes.)</p>
      <p>The unique ID can also be used in individual pages using the [SINGLEEVENT single_event_id="Unique Event ID"] shortcode.</p>
</div>
<div id="custom_email_info" style="display:none">
    <h2>Email Confirmations</h2>
  <p>For customized confirmation emails, the following tags can be placed in the email form and they will pull data from the database to include in the email.</p>
  <p>[fname], [lname], [phone], [event],[description], [cost], [company], [co_add1], [co_add2], [co_city],[co_state], [co_zip],[contact], [payment_url], [start_date], [start_time], [end_date], [end_time]</p>
</div>
<?php
}
?>
