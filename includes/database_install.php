<?php 
//Install/update data tables in the Wordpress database

function add_column_if_not_exist($db, $column, $column_attr = "VARCHAR( 255 ) NULL" ){
			$exists = false;
			$columns = mysql_query("show columns from $db");
			while($c = mysql_fetch_assoc($columns)){
				if($c['Field'] == $column){
					$exists = true;
					break;
				}
			}
			if(!$exists){
				mysql_query("ALTER TABLE `$db` ADD `$column`  $column_attr");
			}
		}
//Function to install/update data tables in the Wordpress database
function events_data_tables_install () {

		function events_attendee_tbl_install () {
		   global $wpdb;
		   global $events_attendee_tbl_version;

		   $table_name = $wpdb->prefix . "events_attendee";
		   $events_attendee_tbl_version = "2.0.2";

		   if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {

				$sql = "CREATE TABLE " . $table_name . " (
					  id int(10) unsigned NOT NULL AUTO_INCREMENT,
					  lname VARCHAR(45) DEFAULT NULL,
					  fname VARCHAR(45) DEFAULT NULL,
					  address VARCHAR(45) DEFAULT NULL,
					  city VARCHAR(45) DEFAULT NULL,
					  state VARCHAR(45) DEFAULT NULL,
					  zip VARCHAR(45) DEFAULT NULL,
					  email VARCHAR(45) DEFAULT NULL,
					  phone VARCHAR(45) DEFAULT NULL,
					  hear VARCHAR(45) DEFAULT NULL,
					  payment VARCHAR(45) DEFAULT NULL,
					  date timestamp NOT NULL default CURRENT_TIMESTAMP,
					  payment_status VARCHAR(45) DEFAULT NULL,
					  txn_type VARCHAR(45) DEFAULT NULL,
					  txn_id VARCHAR(45) DEFAULT NULL,
					  amount_pd decimal(7,2) DEFAULT NULL,
					  coupon_code VARCHAR(45) DEFAULT NULL,
					  quantity VARCHAR(45) DEFAULT NULL,
					  payment_date VARCHAR(45) DEFAULT NULL,
					  event_id VARCHAR(45) DEFAULT NULL,
					  UNIQUE KEY id (id)
					);";

				require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
				dbDelta($sql);


			//create option for table version
				$option_name = 'events_attendee_tbl_version' ;
				$newvalue = $events_attendee_tbl_version;
				  if ( get_option($option_name) ) {
					    update_option($option_name, $newvalue);
					  } else {
					    $deprecated=' ';
					    $autoload='no';
					    add_option($option_name, $newvalue, $deprecated, $autoload);
				  }
			//create option for table name
				$option_name = 'events_attendee_tbl' ;
				$newvalue = $table_name;
				  if ( get_option($option_name) ) {
					    update_option($option_name, $newvalue);
					  } else {
					    $deprecated=' ';
					    $autoload='no';
					    add_option($option_name, $newvalue, $deprecated, $autoload);
				  }
			
		}
		
	// Code here with new database upgrade info/table Must change version number to work.
		 
		 $installed_ver = get_option( "events_attendee_tbl_version" );
	     if( $installed_ver != $events_attendee_tbl_version ) {

				$sql = "CREATE TABLE " . $table_name . " (
					  id int(10) unsigned NOT NULL AUTO_INCREMENT,
					  lname VARCHAR(45) DEFAULT NULL,
					  fname VARCHAR(45) DEFAULT NULL,
					  address VARCHAR(45) DEFAULT NULL,
					  city VARCHAR(45) DEFAULT NULL,
					  state VARCHAR(45) DEFAULT NULL,
					  zip VARCHAR(45) DEFAULT NULL,
					  email VARCHAR(45) DEFAULT NULL,
					  phone VARCHAR(45) DEFAULT NULL,
					  hear VARCHAR(45) DEFAULT NULL,
					  payment VARCHAR(45) DEFAULT NULL,
					  date timestamp NOT NULL default CURRENT_TIMESTAMP,
					  payment_status VARCHAR(45) DEFAULT NULL,
					  txn_type VARCHAR(45) DEFAULT NULL,
					  txn_id VARCHAR(45) DEFAULT NULL,
					  amount_pd decimal(7,2) DEFAULT NULL,
					  coupon_code VARCHAR(45) DEFAULT NULL,
					  quantity VARCHAR(45) DEFAULT NULL,
					  payment_date VARCHAR(45) DEFAULT NULL,
					  event_id VARCHAR(45) DEFAULT NULL,
					  UNIQUE KEY id (id)
					);";


	      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	      dbDelta($sql);

	      update_option( "events_attendee_tbl_version", $events_attendee_tbl_version );
	      }

	    }
	function events_detail_tbl_install  () {
	   global $wpdb;
	   global $events_detail_tbl_version;
		
	   $table_name = $wpdb->prefix . "events_detail";
	   $events_detail_tbl_version = "2.0.9";

	   if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			   $sql = "CREATE TABLE " . $table_name . " (
				  id int(10) unsigned NOT NULL AUTO_INCREMENT,
				  event_name VARCHAR(100) DEFAULT NULL,
				  event_desc TEXT,
				  display_desc VARCHAR (4) DEFAULT NULL,
				  event_identifier VARCHAR(45) DEFAULT NULL,
				  start_month VARCHAR (15) DEFAULT NULL,
				  start_day VARCHAR (15) DEFAULT NULL,
				  start_year VARCHAR (15) DEFAULT NULL,
				  start_date VARCHAR (15) DEFAULT NULL,
				  start_time VARCHAR (15) DEFAULT NULL,
				  end_month VARCHAR (15) DEFAULT NULL,
				  end_day VARCHAR (15) DEFAULT NULL,
				  end_year VARCHAR (15) DEFAULT NULL,
				  end_date VARCHAR (15) DEFAULT NULL,
				  end_time VARCHAR (15) DEFAULT NULL,
				  reg_limit VARCHAR (15) DEFAULT NULL,
				  allow_multiple VARCHAR (15) DEFAULT NULL,
				  event_cost decimal(7,2) DEFAULT NULL,
				  send_mail VARCHAR (2) DEFAULT NULL,
				  is_active VARCHAR(45) DEFAULT NULL,
				  conf_mail VARCHAR (1000) DEFAULT NULL,
				  use_coupon_code VARCHAR(1) DEFAULT NULL,
				  coupon_code VARCHAR(50) DEFAULT NULL,
				  coupon_code_price decimal(7,2) DEFAULT NULL,
				  use_percentage VARCHAR(1) DEFAULT NULL,
				  category_id TEXT,
				   UNIQUE KEY id (id)
				);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);


		//create option for table version
			$option_name = 'events_detail_tbl_version' ;
			$newvalue = $events_detail_tbl_version;
			  if ( get_option($option_name) ) {
				    update_option($option_name, $newvalue);
				  } else {
				    $deprecated=' ';
				    $autoload='no';
				    add_option($option_name, $newvalue, $deprecated, $autoload);
			  }
		//create option for table name
			$option_name = 'events_detail_tbl' ;
			$newvalue = $table_name;
			  if ( get_option($option_name) ) {
				    update_option($option_name, $newvalue);
				  } else {
				    $deprecated=' ';
				    $autoload='no';
				    add_option($option_name, $newvalue, $deprecated, $autoload);
			  }
			}
	 
     $installed_ver = get_option( "events_detail_tbl_version" );
     if( $installed_ver != $events_detail_tbl_version ) {

 			   $sql = "CREATE TABLE " . $table_name . " (
				  id int(10) unsigned NOT NULL AUTO_INCREMENT,
				  event_name VARCHAR(100) DEFAULT NULL,
				  event_desc TEXT,
				  display_desc VARCHAR (4) DEFAULT NULL,
				  event_identifier VARCHAR(45) DEFAULT NULL,
				  start_month VARCHAR (15) DEFAULT NULL,
				  start_day VARCHAR (15) DEFAULT NULL,
				  start_year VARCHAR (15) DEFAULT NULL,
				  start_date VARCHAR (15) DEFAULT NULL,
				  start_time VARCHAR (15) DEFAULT NULL,
				  end_month VARCHAR (15) DEFAULT NULL,
				  end_day VARCHAR (15) DEFAULT NULL,
				  end_year VARCHAR (15) DEFAULT NULL,
				  end_date VARCHAR (15) DEFAULT NULL,
				  end_time VARCHAR (15) DEFAULT NULL,
				  reg_limit VARCHAR (15) DEFAULT NULL,
				  allow_multiple VARCHAR (15) DEFAULT NULL,
				  event_cost decimal(7,2) DEFAULT NULL,
				  send_mail VARCHAR(2) DEFAULT NULL,
				  is_active VARCHAR(45) DEFAULT NULL,
				  conf_mail VARCHAR(1000) DEFAULT NULL,
				  use_coupon_code VARCHAR(1) DEFAULT NULL,
				  coupon_code VARCHAR(50) DEFAULT NULL,
				  coupon_code_price decimal(7,2) DEFAULT NULL,
				  use_percentage VARCHAR(1) DEFAULT NULL,
				  category_id TEXT,
				  UNIQUE KEY id (id)
				);";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);
	  
	
		
      update_option( "events_detail_tbl_version", $events_detail_tbl_version );
      }

	}


	function events_organization_tbl_install () {
		
		global $wpdb;
		
		
		$table_name = $wpdb->prefix . "events_organization";
		//Check to see if upgrading from an earlier version.
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			
			$payment_subject=("Payment Received for [event_name]");
			$payment_message=("<p>***This Is An Automated Response*** </p><p>Thank You [fname] [lname]</p>  <p>We have just  received a payment in the amount of $[event_price] for your registration to [event_name].</p> <p>PayPal transaction ID: [txn_id]</p>");
					
			$message=("<p>***This is an automated response - Do Not Reply***</p> <p>Thank you [fname] [lname] for registering for [event].</p> <p> We hope that you will find this event both informative and enjoyable. Should have any questions, please contact [contact].</p> <p>If you have not done so already, please submit your payment in the amount of [cost].</p> <p>Click here to reveiw your payment information [payment_url].</p><p>Thank You.</p>");
					
			$new_org_options = array(
					'organization' => get_bloginfo('name'),
					'organization_street1' => '123 West Somewhere',
					'organization_street2' => '',
					'organization_city' => 'Some City',
					'organization_state' => 'AZ',
					'organization_zip' => '84128',
					'contact_email' => get_bloginfo('admin_email'),
					'default_mail' => 'Y',
					'paypal_id' => 'my_email@my_website.com',
					'payment_subject' => htmlentities2($payment_subject),
					'payment_message' => htmlentities2($payment_message),
					'message' => htmlentities2($message)
				);
		
			add_option( 'events_organization_settings', $new_org_options );
		}else if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
		//If an earlier version is found
		 $sql  = "SELECT * FROM ". get_option('events_organization_tbl') ." WHERE id='1'";
	   		$result = mysql_query($sql);
		   	while ($row = mysql_fetch_assoc ($result))
					{
		  			$org_id =$row['id'];
					$Organization =$row['organization'];
					$Organization_street1 =$row['organization_street1'];
					$Organization_street2=$row['organization_street2'];
					$Organization_city =$row['organization_city'];
					$Organization_state=$row['organization_state'];
					$Organization_zip =$row['organization_zip'];
					$contact =$row['contact_email'];
	 				$registrar = $row['contact_email'];
					$paypal_id =$row['paypal_id'];
					$paypal_cur =$row['currency_format'];
					$event_page_id = $row['event_page_id'];
					$return_url = $row['return_url'];
					$cancel_return = $row['cancel_return'];
					$notify_url = $row['notify_url'];
					$use_sandbox = $row['use_sandbox'];
					$image_url = $row['image_url'];
					$events_listing_type =$row['events_listing_type'];
					$default_mail = $row['default_mail'];
					$payment_subject =$row['payment_subject'];
					$payment_message =$row['payment_message'];
					$message =$row['message'];
					}
					
					switch ($paypal_cur){
						case 'USD':
						case 'HKD':
						case 'NZD':
						case 'SGD':
						$currency_symbol = '$';
						break;
										
						case 'AUD':
						$currency_symbol = 'A $';
						break;
										
						case 'GBP':
						$currency_symbol = '&pound;';
						break;
										
						case 'CAD':
						$currency_symbol = 'C $';
						break;
										
						case 'EUR':
						$currency_symbol = '&#8364;';
						break;
										
						case 'JPY':
						$currency_symbol = '&yen;';
						break;
										
						default:
						$currency_symbol = '$';
						break;
					}
	
			$org_options = array(
				'organization' => $Organization,
				'organization_street1' => $Organization_street1,
				'organization_street2' => $Organization_street2,
				'organization_city' => $Organization_city,
				'organization_state' => $Organization_state,
				'organization_zip' => $Organization_zip,
				'contact_email' => $contact,
				'paypal_id' => $paypal_id,
				'currency_format' => $paypal_cur,
				'currency_symbol' => $currency_symbol,
				'events_listing_type' => $events_listing_type,
				'event_page_id' => $event_page_id,
				'return_url' => $return_url,
				'cancel_return' => $cancel_return,
				'notify_url' => $notify_url,
				'use_sandbox' => $use_sandbox,
				'image_url' => $image_url,
				'default_mail' => $default_mail,
				'payment_subject' => $payment_subject,
				'payment_message' => $payment_message,
				'message' => $message	
			);

		add_option( 'events_organization_settings', $org_options );

      }
	}

function events_question_tbl_install() {
   global $wpdb;
   global $events_question_tbl_version;
   $table_name = $wpdb->prefix . "events_question_tbl";
   $events_question_tbl_version = "2.0.1";

   if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			$sql = "CREATE TABLE " . $table_name . " (
			id int(11) unsigned NOT NULL auto_increment,
			event_id int(11) NOT NULL default '0',
			sequence int(11) NOT NULL default '0',
			question_type enum('TEXT','TEXTAREA','MULTIPLE','SINGLE','DROPDOWN') NOT NULL default 'TEXT',
			question text NOT NULL,
			response text NOT NULL,
			required ENUM( 'Y', 'N' ) NOT NULL DEFAULT 'N',
			PRIMARY KEY  (id)
			);";
			

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);

//create option for table version
	$option_name = 'events_question_tbl_version' ;
	$newvalue = $events_question_tbl_version;
	if ( get_option($option_name) ) {
	update_option($option_name, $newvalue);
	 } else {
	  $deprecated=' ';
	  $autoload='no';
	  add_option($option_name, $newvalue, $deprecated, $autoload);
	 }
//create option for table name
	$option_name = 'events_question_tbl' ;
	$newvalue = $table_name;
 	if ( get_option($option_name) ) {
	   update_option($option_name, $newvalue);
	} else {
	   $deprecated=' ';
	   $autoload='no';
	   add_option($option_name, $newvalue, $deprecated, $autoload);
	} 
 }

	//Upgrade Info Here
    $installed_ver = get_option( "events_question_tbl_version" );
    if( $installed_ver != $events_question_tbl_version ) {
	$sql = "CREATE TABLE " . $table_name . " (
			id int(11) unsigned NOT NULL auto_increment,
			event_id int(11) NOT NULL default '0',
			sequence int(11) NOT NULL default '0',
			question_type enum('TEXT','TEXTAREA','MULTIPLE','SINGLE','DROPDOWN') NOT NULL default 'TEXT',
			question text NOT NULL,
			response text NOT NULL,
			required ENUM( 'Y', 'N' ) NOT NULL DEFAULT 'N',
			PRIMARY KEY  (id)
			);";
			
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    update_option( "events_question_tbl_version", $events_question_tbl_version );
    }
	}


function events_answer_tbl_install() {
   global $wpdb;
   global $events_answer_tbl_version;
   $table_name = $wpdb->prefix . "events_answer_tbl";
   $events_answer_tbl_version = "2.0.1";

   if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			$sql = "CREATE TABLE " . $table_name . " (
			registration_id int(11) NOT NULL default '0',
			question_id int(11) NOT NULL default '0',
			answer text NOT NULL,
			PRIMARY KEY  (registration_id, question_id)
			);";
			

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);

//create option for table version
	$option_name = 'events_answer_tbl_version' ;
	$newvalue = $events_question_tbl_version;
	if ( get_option($option_name) ) {
	update_option($option_name, $newvalue);
	 } else {
	  $deprecated=' ';
	  $autoload='no';
	  add_option($option_name, $newvalue, $deprecated, $autoload);
	 }
//create option for table name
	$option_name = 'events_answer_tbl' ;
	$newvalue = $table_name;
 	if ( get_option($option_name) ) {
	   update_option($option_name, $newvalue);
	} else {
	   $deprecated=' ';
	   $autoload='no';
	   add_option($option_name, $newvalue, $deprecated, $autoload);
	} 
 }

	//Upgrade Info Here
    $installed_ver = get_option( "events_answer_tbl_version" );
    if( $installed_ver != $events_answer_tbl_version ) {
	$sql = "CREATE TABLE " . $table_name . " (
			registration_id int(11) NOT NULL default '0',
			question_id int(11) NOT NULL default '0',
			answer text NOT NULL,
			PRIMARY KEY  (registration_id, question_id)
			);";
			
		
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    update_option( "events_answer_tbl_version", $events_answer_tbl_version );
    }
}

function events_paypal_transactions_tbl_install  () {
	   global $wpdb;
	   global $events_paypal_transactions_tbl_version;

	   $table_name = $wpdb->prefix . "events_paypal_transactions";
	   $events_paypal_transactions_tbl_version = "0.1";

	   if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			   $sql = "CREATE TABLE " . $table_name . " (
				  id int(10) NOT NULL AUTO_INCREMENT,
				  payer_id varchar(15) NOT NULL,
				  payment_date varchar(30) DEFAULT NULL,
				  txn_id varchar(20) NOT NULL,
				  first_name varchar(50) NOT NULL,
				  last_name varchar(50) NOT NULL,
				  payer_email varchar(100) NOT NULL,
				  payer_status varchar(10) NOT NULL,
				  payment_type varchar(7) NOT NULL,
				  memo text NOT NULL,
				  item_name text NOT NULL,
				  item_number varchar(50) NOT NULL,
				  quantity int(3) NOT NULL,
				  mc_gross decimal(7,2) NOT NULL,
				  mc_currency varchar(3) NOT NULL,
				  address_name varchar(32) DEFAULT NULL,
				  address_street varchar(64) DEFAULT NULL,
				  address_city varchar(32) DEFAULT NULL,
				  address_state varchar(32) DEFAULT NULL,
				  address_zip varchar(10) DEFAULT NULL,
				  address_country varchar(64) DEFAULT NULL,
				  address_status varchar(11) DEFAULT NULL,
				  payer_business_name varchar(64) DEFAULT NULL,
				  payment_status varchar(17) NOT NULL,
				  pending_reason varchar(14) DEFAULT NULL,
				  reason_code varchar(15) DEFAULT NULL,
				  txn_type varchar(10) NOT NULL,
				  PRIMARY KEY (id)
				);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);


		//create option for table version
			$option_name = 'events_paypal_transactions_tbl_version' ;
			$newvalue = $events_paypal_transactions_tbl_version;
			  if ( get_option($option_name) ) {
				    update_option($option_name, $newvalue);
				  } else {
				    $deprecated=' ';
				    $autoload='no';
				    add_option($option_name, $newvalue, $deprecated, $autoload);
			  }
		//create option for table name
			$option_name = 'events_paypal_transactions_tbl' ;
			$newvalue = $table_name;
			  if ( get_option($option_name) ) {
				    update_option($option_name, $newvalue);
				  } else {
				    $deprecated=' ';
				    $autoload='no';
				    add_option($option_name, $newvalue, $deprecated, $autoload);
			  }
		}
	 
     $installed_ver = get_option( "$events_paypal_transactions_tbl_version" );
     if( $installed_ver != $events_paypal_transactions_tbl_version ) {

 			   $sql = "CREATE TABLE " . $table_name . " (
				  id int(10) NOT NULL AUTO_INCREMENT,
				  payer_id varchar(15) NOT NULL,
				  payment_date varchar(30) DEFAULT NULL,
				  txn_id varchar(20) NOT NULL,
				  first_name varchar(50) NOT NULL,
				  last_name varchar(50) NOT NULL,
				  payer_email varchar(100) NOT NULL,
				  payer_status varchar(10) NOT NULL,
				  payment_type varchar(7) NOT NULL,
				  memo text NOT NULL,
				  item_name text NOT NULL,
				  item_number varchar(50) NOT NULL,
				  quantity int(3) NOT NULL,
				  mc_gross decimal(7,2) NOT NULL,
				  mc_currency varchar(3) NOT NULL,
				  address_name varchar(32) DEFAULT NULL,
				  address_street varchar(64) DEFAULT NULL,
				  address_city varchar(32) DEFAULT NULL,
				  address_state varchar(32) DEFAULT NULL,
				  address_zip varchar(10) DEFAULT NULL,
				  address_country varchar(64) DEFAULT NULL,
				  address_status varchar(11) DEFAULT NULL,
				  payer_business_name varchar(64) DEFAULT NULL,
				  payment_status varchar(17) NOT NULL,
				  pending_reason varchar(14) DEFAULT NULL,
				  reason_code varchar(15) DEFAULT NULL,
				  txn_type varchar(10) NOT NULL,
				  PRIMARY KEY (id)
				);";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);


      update_option( "events_paypal_transactions_tbl_version", $events_paypal_transactions_tbl_version );
      }

	}
function events_category_detail_tbl_install() {
		   global $wpdb;
		   global $events_category_detail_tbl_version;
			
		   $table_name = $wpdb->prefix . "events_category_detail";
		   $events_category_detail_tbl_version = "2.0.1";
	
		   if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
				   $sql = "CREATE TABLE " . $table_name . " (
					  id int(10) unsigned NOT NULL AUTO_INCREMENT,
					  category_name VARCHAR(100) DEFAULT NULL,
					  category_identifier VARCHAR(45) DEFAULT NULL,
					  category_desc TEXT,
					  display_desc VARCHAR (4) DEFAULT NULL,
					   UNIQUE KEY id (id)
					);";
	
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
				dbDelta($sql);
	
	
			//create option for table version
				$option_name = 'events_category_detail_tbl_version' ;
				$newvalue = $events_category_detail_tbl_version;
				  if ( get_option($option_name) ) {
						update_option($option_name, $newvalue);
					  } else {
						$deprecated=' ';
						$autoload='no';
						add_option($option_name, $newvalue, $deprecated, $autoload);
				  }
			//create option for table name
				$option_name = 'events_category_detail_tbl' ;
				$newvalue = $table_name;
				  if ( get_option($option_name) ) {
						update_option($option_name, $newvalue);
					  } else {
						$deprecated=' ';
						$autoload='no';
						add_option($option_name, $newvalue, $deprecated, $autoload);
				  }
				}
		 
		 $installed_ver = get_option( "events_category_detail_tbl_version" );
		 if( $installed_ver != $events_category_detail_tbl_version ) {
	
				   $sql = "CREATE TABLE " . $table_name . " (
					  id int(10) unsigned NOT NULL AUTO_INCREMENT,
					  category_name VARCHAR(100) DEFAULT NULL,
					  category_identifier VARCHAR(45) DEFAULT NULL,
					  category_desc TEXT,
					  display_desc VARCHAR (4) DEFAULT NULL,
					   UNIQUE KEY id (id)
					);";
	
		  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		  dbDelta($sql);
		  
		  update_option( "events_category_detail_tbl_version", $events_category_detail_tbl_version );
		  }
		
		
	}	
add_column_if_not_exist(get_option('events_attendee_tbl'), 'coupon_code', $column_attr = "VARCHAR(45) DEFAULT NULL" );
add_column_if_not_exist(get_option('events_detail_tbl'), 'category_id', $column_attr = "TEXT" );
add_column_if_not_exist(get_option('events_detail_tbl'), 'use_percentage', $column_attr = "VARCHAR(1) DEFAULT NULL" ); 

events_category_detail_tbl_install();
events_attendee_tbl_install();
events_detail_tbl_install();
events_organization_tbl_install();
events_question_tbl_install();
events_answer_tbl_install();
events_paypal_transactions_tbl_install();
}
//register_activation_hook(__FILE__,'events_data_tables_install');
?>
