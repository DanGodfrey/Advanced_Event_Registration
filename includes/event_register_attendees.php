<?php function register_attendees($single_event_id = "null"){
	
	global $wpdb;
			
	$event_id = $_REQUEST['event_id'];
	
			$org_options = get_option('events_organization_settings');
				$event_page_id =$org_options['event_page_id'];
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
				
	$events_attendee_tbl = get_option('events_attendee_tbl');
	$events_detail_tbl = get_option('events_detail_tbl');
	
	if ($single_event_id != "null"){
		$single_event_id = $single_event_id;
		$sql  = "SELECT * FROM " . $events_detail_tbl . " WHERE event_identifier = '$single_event_id'";
				$result = mysql_query($sql);
				while ($row = mysql_fetch_assoc ($result))
					{
				$event_id = $row['id'];
					}
	}
	
				

	//Query Database for Active event and get variable
	if ($events_listing_type == 'single'){
		$sql  = "SELECT * FROM " . $events_detail_tbl . " WHERE (is_active='yes' OR is_active='Y') AND start_date >= '".date ( 'Y-m-d' )."' ORDER BY date(start_date)";
	}else {
		$sql  = "SELECT * FROM " . $events_detail_tbl . " WHERE id = $event_id";
	}
	
if (mysql_query($sql)){
		$result = mysql_query($sql);
		while ($row = mysql_fetch_assoc ($result))
			{
				$event_id = $row['id'];
				$event_name = stripslashes($row['event_name']);
				$event_desc = stripslashes($row['event_desc']);
				$display_desc = $row['display_desc'];
				$event_description = stripslashes($row['event_desc']);
				$event_identifier = stripslashes($row['event_identifier']);
				$event_cost = $row['event_cost'];
				$use_coupon_code = $row['use_coupon_code'];
				$active = $row['is_active'];
		
				$reg_limit = $row['reg_limit'];
				$allow_multiple = $row ['allow_multiple'];
				$start_time = $row['start_time'];
				$end_time = $row['end_time'];
				$start_date =  $row['start_date'];
				$end_date =  $row['end_date'];
				$reg_limit=$row['reg_limit'];
			}
			if ($reg_limit != ""){
				if ($reg_limit > $num_attendees){
					$available_spaces = $reg_limit - $num_attendees - 72; // HACK by Jeffrey A. to fix space limit
				}else if ($reg_limit <= $num_attendees){
					$available_spaces = '<span style="color: #F00; font-weight:bold;">EVENT FULL</span>';
				}
			}

			if ($reg_limit == "" || $reg_limit == " " || $reg_limit == "999"){$available_spaces = "Unlimited";}
	  			
				
	
	//get attendee count	
	$events_attendee_tbl = get_option ( 'events_attendee_tbl' );

	$sql= "SELECT SUM(quantity) FROM " . $events_attendee_tbl . " WHERE event_id='$event_id' AND payment_date IS NOT NULL";
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)){
		$num_attendees =  $row['SUM(quantity)'];
		}
	
	if ($reg_limit == "" or $reg_limit >= "$num_attendees") {
		if ($reg_limit == "" || $reg_limit == " "){
			$reg_limit = 999;
		}
    	if ($reg_limit <= $num_attendees){	?>
            <p><font color="#FF0000"><strong>We are sorry but this event has reached the maximun number of attendees!</strong></font></p>
			<p><strong>Please check back in the event someone cancels.</strong></p>
			<p>Current Number of Attendees: <?php echo $num_attendees?></p>
            
<?php	}else{ 

if ($reg_limit != ""){
				if ($reg_limit > $num_attendees){
					$available_spaces = $reg_limit - $num_attendees - 72; // HACK by Jeffrey A. to fix space limit
				}
			}

			if ($reg_limit == "" || $reg_limit == " " || $reg_limit == "999"){$available_spaces = "Unlimited";}
	  			
				?>
        <h3><?php echo $event_name;?></h3>
        <p><strong>Start Date:</strong> <?php echo event_date_display($start_date);?> - Start Time: <?php echo $start_time;?><br />
		<strong>End Date:</strong> <?php echo event_date_display($end_date);?> - End Time: <?php echo $end_time;?>
        </p>
     <?php if ($display_desc == "Y"){ ?>
			<p><strong>Description:</strong><br /><?php echo htmlspecialchars_decode($event_desc);?></p>
		<?php }
		if ($event_cost != "" || $event_cost != '0.00'){	?>	
			<p><strong>Cost <?php echo $org_options['currency_symbol'].$event_cost;?></strong></p>
            <p><strong>Spaces Available:</strong> <?php echo $available_spaces?></p>
		<?php }
		

	//JavaScript for Registration Form Validation ?>
	<SCRIPT>
        function echeck(str) {
            var at="@"
            var dot="."
            var lat=str.indexOf(at)
            var lstr=str.length
            var ldot=str.indexOf(dot)
            if (str.indexOf(at)==-1){
                alert("Invalid E-mail ID")
                return false
            }
        
            if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
                alert("Invalid E-mail ID")
                return false
            }
        
            if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
                alert("Invalid E-mail ID")
                return false
            }
        
            if (str.indexOf(at,(lat+1))!=-1){
                alert("Invalid E-mail ID")
                return false
            }
        
            if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
                alert("Invalid E-mail ID")
                return false
            }
        
            if (str.indexOf(dot,(lat+2))==-1){
                alert("Invalid E-mail ID")
                return false
            }
                
            if (str.indexOf(" ")!=-1){
                alert("Invalid E-mail ID")
                return false
            }
        return true					
        }
    
        function validateForm(form) { 
    
            if (form.fname.value == "") { alert("Please enter your first name."); 
                form.fname.focus( ); 
                return false; 
             }
            if (form.lname.value == "") { alert("Please enter your last name."); 
                form.lname.focus( ); 
                return false; 
            }
            
            if ((form.email.value==null)||(form.email.value=="")){
                alert("Please Enter your Email address")
                form.email.focus()
                return false
            }
            if (echeck(form.email.value)==false){
                form.email.value=""
                form.email.focus()
                return false
            }
        
            if (form.email.value == "") { alert("Please enter your email address."); 
                form.email.focus( ); 
                return false; 
            }
        
            if (form.phone.value == "") { alert("Please enter your phone number."); 
                form.phone.focus( ); 
                return false; 
            }
            if (form.address.value == "") { alert("Please enter your address."); 
                form.address.focus( ); 
                return false; 
            }
            if (form.city.value == "") { alert("Please enter your city."); 

                form.city.focus( ); 
                return false; 
            }   
            if (form.state.value == "") { alert("Please enter your Province."); 
                form.state.focus( ); 
                return false; 
            }
            if (form.zip.value == "") { alert("Please enter your Postal Code."); 
                form.zip.focus( ); 
                return false; 
            }
           
            function trim(s) {
                if (s) {
                return s.replace(/^\s*|\s*$/g,"");
            }
        return null;
        }
    
        //alert("your trying to submit");
            var inputs = $A(form.getElementsByTagName("input"));
            var msg = "";
            var radioChecks = $H();
            inputs.each( function(e) {
                var value = e.value ? trim(e.value) : null;
                if (e.type == "text" && e.title && !value && e.className == "r") {
                    msg += "\n " + e.title;
                }
                if ((e.type == "radio" || e.type == "checkbox") && e.className == "r") {
                    var name = e.name;
                    if (e.type == "checkbox") name = name.substr(0, name.lastIndexOf("-"));
                    if (e.checked == false && ((!radioChecks[name]) || (radioChecks[name] && radioChecks[name] != 1))) {
                        radioChecks[name] = e;
                    } else {
                        radioChecks[name] = 1;
                    }
                }
            });
            radioChecks.each( function(e) {
                if (typeof(e) == "object" && e.value != 1) {
                    msg += "\n " + e.value.title;
                }
            });
            if (msg.length > 0) {
                msg = "The following fields need to be completed before you can submit.\n\n" + msg;
                alert(msg);
                return false;
            }
            return true;     
       
        }
    </SCRIPT>
	<form method="post" action="<?php echo get_option('siteurl');?>/?page_id=<?php echo $event_page_id;?>" onSubmit="return validateForm(this)">
<fieldset style="margin-right:22px;">
<table cellspacing="3" style="background:transparent;border-collapse:separate;border-spacing:3px;">
<col width="100" /><col />
<tr><td><label for="fname"><strong>First Name:</strong></label></td><td><input tabIndex="1" maxLength="40" size="47" name="fname" id="fname" /></td></tr>
<tr><td><label for="lname"><strong>Last Name:</strong></label></td><td><input tabIndex="2" maxLength="40" size="47" name="lname" id="lname" /></td></tr>
<tr><td><label for="email"><strong>Email:*</strong></label></td><td><input tabIndex="3" maxLength="40" size="47" name="email" id="email" /></td></tr>
<tr><td><label for="phone"><strong>Phone:</strong></label></td><td><input tabIndex="4" maxLength="20" size="25" name="phone" id="phone" /></td></tr>
<tr><td><label for="address"><strong>Address:</strong></label></td><td><input tabIndex="5" maxLength="35" size="49" name="address" id="address" /></td></tr>
<tr><td><label for="city"><strong>City:</strong></label></td><td><input tabIndex="6" maxLength="25" size="35" name="city" id="city" /></td></tr>
<tr><td><label form="province"><strong>Province:</strong></label></td><td>
          <select tabindex="7" name="Province" size="1">
            <option value="">Select Province</option>
            <option value="AL">Alberta</option>
       	    <option value="BC">British Columbia</option>
   	    <option value="MN">Manitoba</option>
	    <option value="ON">Ontario</option>  
 	    <option value="PI">Prince Edward Island</option>
	    <option value="QB">Quebec</option>
	    <option value="SK">Saskatchewan</option>
	    <option value="NF">Newfoundland</option>	
	    <option value="NB">Newbrunswick</option>
	    <option value="NS">Nova Scotia</option>
	    <option value="NV">Nunavut</option>
	    <option value="NW">Northwest Territories</option>	
	    <option value="YK">Yukon</option>
          </select>
        </td></tr>
<tr><td><label for="zip"><strong>Postal Code:</strong></label></td><td><input tabIndex="8" maxLength="10" size="15" name="zip" id="zip" /></td></tr>
</table>
</fieldset>
<?php 
		if ($event_cost != ""){ 
			if ($paypal_id != ""){ ?>
				<input type="hidden" name="payment" value="Paypal">
<?php		}
		} else {?>
        <input type="hidden" name="payment" value="free event">
<?php 		}
			
//This is the Form
		$events_question_tbl = get_option('events_question_tbl');
		$questions = $wpdb->get_results("SELECT * from $events_question_tbl where event_id = '$event_id' order by sequence");
		if ($questions){
			foreach($questions as $question) {
				echo "<fieldset class=\"qe\"><p align='left'><strong>".$question->question."<br>";
				event_form_build($question);
				echo "</strong></p></fieldset>";
			 }
		 }
	
if ($allow_multiple == "Y"){?>			
			
<p align="left"><b>	Additional attendees?
      <select name="num_people" style="width:70px;margin-top:4px">
        <option value="1" selected>None</option>
        <option value="2">1</option>
        <option value="3">2</option>
        <option value="4">3</option>
        <option value="5">4</option>
        <option value="6">5</option>
      </select>		
      </b></p>
      
      <?php
	  }
if ($allow_multiple == "N"){?>
<input type="hidden" name="num_people" value="1"> 
<?php
}	
	if ($use_coupon_code == "Y"){ ?>
			<p align="left"><strong>Do you have a promo code?<br />
			<input tabIndex="9" maxLength="25" size="35" name="coupon_code">
			</strong></p>
	<?php 	} ?>
        
        <input type="hidden" name="regevent_action" value="post_attendee">
        <input type="hidden" name="event_id" value="<?php echo $event_id;?>">
        <p style="margin-left:5.5em;text-indent:-5.5em;"><strong>Disclaimer:</strong> Please note that all sales are final and that only in extreme circumstances (if the LAN is rescheduled or cancelled) will reimbursements be considered.</p>
        <p align="left">
		<input type="submit" name="Submit" value="Submit"><br />
		</form>
          <p style="font-size:9px"><a href="http://shoultes.net/wordpress-events-registration-with-paypal-ipn/" title="Events Registration with PayPal IPN" target="_blank">Event Registration</a> Powered by <a href="http://smartwebutah.com/" title="Website Design, Programming and Hosting" target="_blank">Smart Website Solutions</a></p>
<?php 
}
	}}else{
	?>
    <h3 class="expired-event">Sorry, this event has expired or is no longer available.</h3>
    <?php
	}
}
