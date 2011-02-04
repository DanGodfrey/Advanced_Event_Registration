<?php 
	function display_event_regis_categories($event_category_id="null"){
				global $wpdb;
				
				if ($event_category_id != "null"){
					$event_category_id = $event_category_id;
					$sql  = "SELECT * FROM " . get_option('events_category_detail_tbl') . " WHERE category_identifier = '$event_category_id'";
					$result = mysql_query($sql);
					while ($row = mysql_fetch_assoc ($result)){
						$category_id = $row['id'];
						$category_name = $row['category_name'];
					}
				}				
				$sql = "SELECT * FROM ". get_option('events_detail_tbl') . " WHERE category_id LIKE '%\"$category_id\"%' AND (is_active='yes' OR is_active='Y') AND start_date >= '".date ( 'Y-m-d' )."'";
				event_regis_get_event_details($sql);//Called from the file get_event_details.php
					  
	}
?>