<?php
function event_regis_get_event_details($sql){ 

				$org_options = get_option('events_organization_settings');
						$event_page_id =$org_options['event_page_id'];
						
						$result = mysql_query ($sql);
					       		while ($row = mysql_fetch_assoc ($result))
					       		{
					       			    $event_id = $row['id'];
										$event_name=$row['event_name'];
					       			    $event_identifier=$row['event_identifier'];
					       			    $event_cost=$row['event_cost'];
					       			    $active=$row['is_active'];
										$start_date=$row['start_date'];
										$reg_limit=$row['reg_limit'];

										$sql2= "SELECT SUM(quantity) FROM " . get_option('events_attendee_tbl') . " WHERE event_id='$event_id'";
										$result2 = mysql_query($sql2);
								
										while($row = mysql_fetch_array($result2)){
											$num_attendees =  $row['SUM(quantity)'];
										}
										
										if ($reg_limit != ""){
											
											if ($reg_limit > $num_attendees){
												$available_spaces = $reg_limit - $num_attendees;
											}else if ($reg_limit <= $num_attendees){
												$available_spaces = '<span style="color: #F00; font-weight:bold;">EVENT FULL</span>';
											}
										}
										
										if ($reg_limit == "" || $reg_limit == " " || $reg_limit == "999"){$available_spaces = "Unlimited";}
		
		?>

                                        <div id="event-<?php echo $event_id?>">
                                          <h3 class="event_title"><a href="<?php echo get_option('siteurl')?>/?page_id=<?php echo $event_page_id?>&amp;regevent_action=register&amp;event_id=<?php echo $event_id?>&name_of_event=<?php echo stripslashes($event_name)?>">
                                            <?php echo stripslashes($event_name)?>
                                            </a></h3>
                                          Date:
                                          <?php echo event_date_display($start_date)?>
                                          <br />
                                          <?php if ($event_cost == '' || $event_cost == ' '){ ?>
                                          Free Event
                                          <?php }else{?>
                                          Cost: <?php echo $org_options['currency_symbol']?><?php echo $event_cost?>
                                          <?php }?>
                                          <br />
                                          Spaces Available:
                                          <?php echo $available_spaces?>
                                          <br />
                                          <a style="font-size:14px;" href="<?php echo get_option('siteurl')?>/?page_id=<?php echo $event_page_id?>&regevent_action=register&amp;event_id=<?php echo $event_id?>&amp;name_of_event=<?php echo stripslashes($event_name)?>">Register Online</a>
                                          </p>
                                        </div>
<?php
								}
					  }
?>
