<?php 
function event_regis_categories_config_mnu(){
	?>
<div id="event_reg_theme" class="wrap">
<div id="icon-options-event" class="icon32"></div><h2>Manage Event Categories</h2>
<?php
	//function to delete category
	if($_POST['delete_category']){
		if (is_array($_POST['checkbox'])){
			while(list($key,$value)=each($_POST['checkbox'])):
				$del_id=$key;
				//Delete customer data
				$sql = "DELETE FROM ".get_option('events_category_detail_tbl')." WHERE id='$del_id'";
				$wpdb->query($wpdb->prepare($sql));
			endwhile;	
		}
		?>
	<div id="message" class="updated fade"><p><strong>Categories have been successfully deleted from the event.</strong></p></div>
<?php
	}


//Updates the Event Database
if (isset($_POST['Submit'])){
	if ( $_REQUEST['action'] == 'update' ){
		$category_id= $_REQUEST['category_id'];
		$category_name= htmlentities2($_REQUEST['category_name']);
		$category_identifier = htmlentities2($_REQUEST['category_identifier']);
		$category_desc= htmlentities2($_REQUEST['category_desc']); 
		$display_category_desc=$_REQUEST['display_desc'];
	global $wpdb;
		/*//Post the new event into the database
		$sql="UPDATE ".get_option('events_category_detail_tbl')." SET category_name='$category_name', category_identifier='$category_identifier', category_desc='$category_desc',   display_desc='$display_category_desc' WHERE id = $category_id";

	if ($wpdb->query($wpdb->prepare($sql))){ ?>*/
	$sql=array('category_name'=>$category_name, 'category_identifier'=>$category_identifier, 'category_desc'=>$category_desc, 'display_desc'=>$display_category_desc); 
		
		$update_id = array('id'=> $category_id);
		
		$sql_data = array('%s','%s','%s','%s');
	
	if ($wpdb->update( get_option('events_category_detail_tbl'), $sql, $update_id, $sql_data, array( '%d' ) )){?>
	<div id="message" class="updated fade"><p><strong>The category <?php echo htmlentities2($_REQUEST['category_name']);?> has been updated.</strong></p></div>
<?php }else { ?>
	<div id="message" class="error"><p><strong>The category <?php echo htmlentities2($_REQUEST['category_name']);?> was not updated. <?php print mysql_error() ?>.</strong></p></div>
<?php
}
	}
}
// Adds an Event or Function to the Event Database
function add_cat_funct_to_db(){
	global $wpdb;
	if (isset($_POST['Submit'])){
	if ( $_REQUEST['action'] == 'add' ){
		$category_name= htmlentities2($_REQUEST['category_name']);
		$category_identifier = htmlentities2($_REQUEST['category_identifier']);
		$category_desc= htmlentities2($_REQUEST['category_desc']); 
		$display_category_desc=$_REQUEST['display_desc'];
	
		/*//Post the new event into the database
		$sql="INSERT INTO ".get_option('events_category_detail_tbl')." (category_name, category_identifier, category_desc, display_desc) VALUES('$category_name', '$category_identifier', '$category_desc', '$display_category_desc')";

	if ($wpdb->query($wpdb->prepare($sql))){ ?>*/
	
	$sql=array('category_name'=>$category_name, 'category_identifier'=>$category_identifier, 'category_desc'=>$category_desc, 'display_desc'=>$display_category_desc); 
		
		$sql_data = array('%s','%s','%s','%s');
	
	if ($wpdb->insert( get_option('events_category_detail_tbl'), $sql, $sql_data )){?>


	<div id="message" class="updated fade"><p><strong>The category <?php echo htmlentities2($_REQUEST['category_name']);?> has been added.</strong></p></div>
<?php }else { ?>
	<div id="message" class="error"><p><strong>The category <?php echo htmlentities2($_REQUEST['category_name']);?> was not saved. <?php print mysql_error() ?>.</strong></p></div>
<?php
}
	}
	}
}
if ( $_REQUEST['action'] == 'add' ){add_cat_funct_to_db();}

?>
  <div style="float:right; margin-right:20px;">
  <form name="form" method="post" action="<?php echo $_SERVER["REQUEST_URI"]?>">
    <input type="hidden" name="action" value="add_new_category">
    <input class="button-primary" type="submit" name="add_new_category" value="Add New Category"/>
  </form>
</div> <div style="clear:both;"></div>
<?php
	
function add_new_event_category(){
	?>
<!--Add event display-->
<div class="metabox-holder">
  <div class="postbox">
<h3>Add a Category</h3>
  <form method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
  <input type="hidden" name="action" value="add">
   <ul>
    <li><label>Category Name</label> <input name="category_name" size="25"></li>
   <li><label>Unique ID For Category</label> <input name="category_identifier"> <a class="ev_reg-fancylink" href="#unique_id_info"><img src="<?php echo EVNT_RGR_PLUGINFULLURL?>/images/question-frame.png" width="16" height="16" /></a></li>
   <li>Do you want to display the event description on the events page?
   <?php if ($display_desc ==""){
			echo "<input type='radio' name='display_desc' checked value='Y'>Yes";
			echo "<input type='radio' name='display_desc' value='N'>No";}
		if ($display_desc =="Y"){
			echo "<input type='radio' name='display_desc' checked value='Y'>Yes";
			echo "<input type='radio' name='display_desc' value='N'>No";}
		if ($display_desc =="N"){
			echo "<input type='radio' name='display_desc' value='Y'>Yes";
			echo "<input type='radio' name='display_desc' checked value='N'>No";
		}
	?>
	</li>
   <li>Category Description<br />
   <textarea rows="5" cols="300" name="category_desc" id="category_desc_new"  class="my_ed"></textarea>
      <br />
      <script>myEdToolbar('category_desc_new'); </script>
   </li>
   <li>
    <p>
            <input class="button-primary" type="submit" name="Submit" value="<?php _e('Add New Category'); ?>" id="add_new_category" />
            </p>
    </li>
   </ul>
     </form>
	</div>
</div>
<?php } 

if ($_REQUEST['action'] == 'add_new_category'){
		add_new_event_category();
	}
	
function edit_event_category(){
	$id=$_REQUEST['id'];
	$sql = "SELECT * FROM ". get_option('events_category_detail_tbl') ." WHERE id =".$id;
		$result = mysql_query ($sql);
		
			while ($row = mysql_fetch_assoc ($result)){
					$category_id= $row['id'];
					$category_name=$row['category_name'];
					$category_identifier=$row['category_identifier'];
					$category_desc=$row['category_desc'];
					$display_category_desc=$row['display_desc'];
			}
	?>
<!--Add event display-->
<div class="metabox-holder">
  <div class="postbox">
<h3>Edit Category: <?php echo $category_name ?></h3>
  <form method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
  <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
  <input type="hidden" name="action" value="update">
   <ul>
    <li><label><strong>Category Name:</strong></label> <input name="category_name" size="25" value="<?php echo $category_name;?>"></li>
   <li><label><strong>Unique Category Identifier:</strong></label> <input name="category_identifier" value="<?php echo $category_identifier;?>"> <a class="ev_reg-fancylink" href="#unique_id_info"><img src="<?php echo EVNT_RGR_PLUGINFULLURL?>/images/question-frame.png" width="16" height="16" /></a></li>
   <li>Do you want to display the event description on the events page?
   <?php if ($display_category_desc ==""){
			echo "<input type='radio' name='display_desc' checked value='Y'>Yes";
			echo "<input type='radio' name='display_desc' value='N'>No";}
		if ($display_category_desc =="Y"){
			echo "<input type='radio' name='display_desc' checked value='Y'>Yes";
			echo "<input type='radio' name='display_desc' value='N'>No";}
		if ($display_category_desc =="N"){
			echo "<input type='radio' name='display_desc' value='Y'>Yes";
			echo "<input type='radio' name='display_desc' checked value='N'>No";
		}
	?>
	</li>
   <li><strong>Category Description:</strong><br />
   <textarea rows="5" cols="300" name="category_desc" id="category_desc_new"  class="my_ed"><?php echo $category_desc; ?></textarea>
      <br />
      <script>myEdToolbar('category_desc_new'); </script>
   </li>
   <li>
    <p>
            <input class="button-primary" type="submit" name="Submit" value="<?php _e('Update Category'); ?>" id="update_category" />
            </p>
    </li>
   </ul>
     </form>
	</div>
</div>
<?php } 

  if ($_REQUEST['action'] == 'edit'){
		edit_event_category();
	}
	
?>
<h3>Current Categories</h3>
<form id="form1" name="form1" method="post" action="<?php echo $_SERVER["REQUEST_URI"]?>">
<table class="widefat">
	  <thead>
		<tr>
		  <th>Delete</th>
          <th>ID</th>
		  <th>Name </th>
		  <th>Identifier</th>
		  <th>Description</th>
		  <th>Display Description</th>
          <th>Shortcode</th>
          <th>Action</th>
	
		</tr>
</thead>
      <tfoot>
    	 <tr> 
          <th>Delete</th>
          <th>ID</th>
		  <th> Name </th>
		  <th>Identifier</th>
		  <th>Description</th>
		  <th>Display Description</th>
          <th>Shortcode</th>
          <th>Action</th>
         </tr>
      </tfoot>
    <tbody>
<?php 

		$sql = "SELECT * FROM ". get_option('events_category_detail_tbl') ." ORDER BY id ASC";
		$result = mysql_query ($sql);
		
		if (mysql_num_rows($result) > 0 ) {

			while ($row = mysql_fetch_assoc ($result)){
					$category_id= $row['id'];
					$category_name=$row['category_name'];
					$category_identifier=$row['category_identifier'];
					$category_desc=$row['category_desc'];
					$display_category_desc=$row['display_desc'];
			?>
			<tr>
	<td><input name="checkbox[<?php echo $category_id?>]" type="checkbox"  title="Delete <?php echo $category_name?>"></td>
			  <td><?php echo $category_id?></td>
			  <td><?php echo $category_name?></td>
			  <td><?php echo $category_identifier?></td>
			  <td><?php echo $category_desc?></td>
			  <td><?php echo $display_category_desc?></td>
              <td>[EVENT_REGIS_CATEGORY event_category_id="<?php echo $category_identifier?>"]</td>
              <td style="background-color:#FFF"><a href="admin.php?page=event_categories&action=edit&id=<?php echo $category_id?>">Edit Category</a></td>
			  </tr>
	<?php } 
		}else { ?>
  <tr>
    <td>No Record Found!</td>
  <tr>
    <?php	}?>
		
          </tbody>
          </table>
          <input type="checkbox" name="sAll" onclick="selectAll(this)" /> <strong>Check All</strong> 
    <input name="delete_category" type="submit" class="button-secondary" id="delete_category" value="Delete Category" style="margin-left:100px;" onclick="return confirmDelete();">
</form>
<?php event_regis_admin_footer();?>
 </div>
</div>
<div id="unique_id_info" style="display:none">
      <h2>Unique Category Identifier</h2>
      <p>This should be a unique identifier for the category. Example: "category1" (without qoutes.)</p>
      <p>The unique ID can also be used in individual pages using the  	[EVENT_REGIS_CATEGORY event_category_id="category_identifier"] shortcode.</p>
    </div>
<?php 


}?>