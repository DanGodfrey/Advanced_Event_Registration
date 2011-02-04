<?php 
function event_admin_reports(){
	if ($_REQUEST['event_admin_reports'] == 'list_attendee_payments'){
		list_attendee_payments();
	}else if ($_REQUEST['event_admin_reports'] == 'event_list_attendees'){
		event_list_attendees();
	}else if ($_REQUEST['event_admin_reports'] == 'edit_attendee_record'){
		edit_attendee_record();
	}else if ($_REQUEST['event_admin_reports'] == 'enter_attendee_payments'){
		enter_attendee_payments();
	}else {
		event_process_payments();	
	}

	event_regis_admin_footer();
}
?>