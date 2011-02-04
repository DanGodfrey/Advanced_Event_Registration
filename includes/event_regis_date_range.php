<?php 
	function display_event_regis_date_range($date_1="null", $date_2="null"){
				global $wpdb;
				
				if ($date_1 != "null" && $date_2 != "null"){
					$date_1 = $date_1;
					$date_2 = $date_2;
					$sql  = "SELECT * FROM " . EVENTS_DETAIL_TABLE . " WHERE start_date BETWEEN DATE('".$date_1."') AND DATE('".$date_2."')";
					$result = mysql_query($sql);
					while ($row = mysql_fetch_assoc ($result)){
						$event_id = $row['id'];
						$category_name = $row['category_name'];
						$sql = "SELECT * FROM ". get_option('events_detail_tbl') . " WHERE id LIKE '%\"$category_id\"%'";
				event_regis_get_event_details($sql);//Called from the file get_event_details.php
					}
				}				
				
					  
	}
?>