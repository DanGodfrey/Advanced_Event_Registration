<?php
//Build the date selections
function displayMonths() {
    ?>
<option value="Jan">January</option>
<option value="Feb">February</option>
<option value="Mar">March</option>
<option value="Apr">April</option>
<option value="May">May</option>
<option value="Jun">June</option>
<option value="Jul">July</option>
<option value="Aug">August</option>
<option value="Sep">September</option>
<option value="Oct">October</option>
<option value="Nov">November</option>
<option value="Dec">December</option>
<?php
}
  

function dateSelectionBox($start_month = '', $start_day = '', $start_year = '', $end_month = '', $end_day = '', $end_year = '') {

	$currentyear = date ( 'Y' );
	
	?>Start Date:
<SELECT NAME="start_month">
    <?php
	if ($start_month != '') {
		echo "<option value=\"$start_month\">$start_month</option>";
	}
	displayMonths ();
	?>
	</SELECT>

<SELECT NAME="start_day">
    <?php
	if ($start_day != '') {
		echo "<option value=\"$start_day\">$start_day</option>";
	}
	for($i = 01; $i <= 31; $i ++) {
		echo "<option value=\"$i\">$i</option>";
	}
	?>
	</SELECT>

<SELECT NAME="start_year">
    <?php
	if ($start_year != '') {
		echo "<option value=\"$start_year\">$start_year</option>";
	}
	for($i = $currentyear; $i <= $currentyear + 5; $i ++) {
		echo "<option value=\"$i\">$i</option>";
	}
	?>
	</SELECT>

- End Date:
<SELECT NAME="end_month">
     <?php
	if ($end_month != '') {
		echo "<option value=\"$end_month\">$end_month</option>";
	}
	displayMonths ();
		?>
</SELECT>

<SELECT NAME="end_day">
    <?php
	if ($end_day != '') {
		echo "<option value=\"$end_day\">$end_day</option>";
	}
	for($i = 01; $i <= 31; $i ++) {
		echo "<option value=\"$i\">$i</option>";
	}
	?>
	</SELECT>

<SELECT NAME="end_year">
    <?php
	if ($end_year != '') {
		echo "<option value=\"$end_year\">$end_year</option>";
	}
	for($i = $currentyear; $i <= $currentyear + 5; $i ++) {
		echo "<option value=\"$i\">$i</option>";
	}
	?>
	</SELECT>
<?php
}

?>