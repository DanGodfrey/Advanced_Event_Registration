<?php 
//Events Listing - Shows the events on your page. Used with the {EVENTREGIS} tag
function display_all_events(){

				
				$sql = "SELECT * FROM ". get_option('events_detail_tbl') . " WHERE (is_active='yes' OR is_active='Y') AND start_date >= '".date ( 'Y-m-d' )."' ORDER BY date(start_date)";
				event_regis_get_event_details($sql);//Called from the file get_event_details.php
					   
	}
?>