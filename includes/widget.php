<?php 
add_action( 'widgets_init', 'load_event_regis_widget' );

function load_event_regis_widget() {
	register_widget( 'Event_Regis_Widget' );
}
class Event_Regis_Widget extends WP_Widget {
	
	function Event_Regis_Widget() {
		/* Widget settings. */
		$widget_options = array( 'classname' => 'events', 'description' => __('A widget to display your upcoming events.', 'events') );

		/* Widget control settings. */
		$control_options = array( 'width' => 300, 'height' => 350, 'id_base' => 'events-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'events-widget', __('Event Registration Widget', 'events'), $widget_options, $control_options );
	}


	function widget($args, $instance ) {
		extract( $args );
		global $wpdb;
		
		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );				
		
		/* Before widget (defined by themes). */
		echo $before_widget;
		
		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
				$events_detail_tbl = get_option('events_detail_tbl');
				$curdate = date("Y-m-d");
				
				$org_options = get_option('events_organization_settings');
				$paypal_cur =$org_options['currency_format'];
				$event_page_id =$org_options['event_page_id'];
		
				$sql = "SELECT * FROM ". $events_detail_tbl . " WHERE (is_active='yes' OR is_active='Y') AND start_date >= '".date ( 'Y-m-d' )."' ORDER BY date(start_date)";
				$result = mysql_query ($sql);
?>
				<div id="widget_display_all_events"><ul class="event_items">
<?php
				while ($row = mysql_fetch_assoc ($result))
					{
						$event_id = $row['id'];
						$event_name=$row['event_name'];
						$start_date=$row['start_date'];
						?>
						<li><a href="<?php echo get_option('siteurl')?>/?page_id=<?php echo $event_page_id?>&regevent_action=register&event_id=<?php echo $event_id?>&name_of_event=<?php echo $event_name?>"><?php echo $event_name?> - <?php echo event_date_display($start_date)?></a></li>
				<?php 	}?>
				</ul></div>
<?php
	
		/* After widget (defined by themes). */
		echo $after_widget;
		}
		
	/* Update the widget settings. */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Upcoming Events', 'events') );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'Upcoming Events'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

<?php
	}

}
?>
