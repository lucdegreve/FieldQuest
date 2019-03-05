<html>
<head>
<!-----------------------------------------------------------
       US4-11 Filtrer avec des tags - File format  
Developped by OphÃ©lie	& Diane		      
This page contains code to display the filter labels:
- US4-11_Filtrer_avec_tag_project.php
- US4-11_Filtrer_avec_tag_format.php
- US4-11_Filtrer_avec_tag_unit.php
- US_4_11_filtre_avec_tag_data_type.php

Input variables : 		

Output variables :		id of selected tags		

Modified by Eva : add javascript section because we've got 2 button in the same form that have different action (Save filter button and Search button)					
		
------------------------------------------------------------->	


<script type= 'text/javascript' src = 'manage_checkbox_button_bt4.js'></script>


</head>

<body>

<script language="Javascript">
<!--
function OnButton1()
{
    document.filters.action = "US4-11_Main_page_filter.php"
    //document.filters.target = "_blank";    // Open in a new window
    document.filters.submit();             // Submit the page
    return true;
}

function OnButton2()
{
    document.filters.action = "US4-11_Save_filters.php"
    //document.filters.target = "_blank";    // Open in a new window
    document.filters.submit();             // Submit the page
    return true;
}
-->
</script>

<!-- Form to get selected filters  -->
<form name='filters' method = 'POST'>

	
	<?php 
	// Include page with collapse button & content for project names
	include "US4-11_Filtrer_avec_tag_project.php"; 
	?>
	<!-- Collapse button for date (start and end)-->
	<p>
		<button class="btn btn-primary btn-sm btn-block" type="button" data-toggle="collapse" data-target="#collapseDate" aria-expanded="true" aria-controls="collapseDate">
			Date
		</button>
	</p>
	<div class="collapse" id="collapseDate">
		<div class="card card-body">
			<label for ='start_date'>from</label>
			<input type = 'date' name ='start' id='start_date' >
			<label for ='end_date'>to</label>
			<input type='date' name ='end' id='end_date'>
		</div>
	</div>
	<?php
	// Include page with collapse button & content for file format 
	include "US4-11_Filtrer_avec_tag_format.php"; 
	// Include page with collapse button & content for unit 
	include "US4-11_Filtrer_avec_tag_unit.php";
	// Include page with source bar search 
	include "US4_11_Requete_source_final.php";
	// Include page with collapse button & content for data type 
	include "US_4_11_filtre_avec_tag_data_type.php";
	
	?>
	
			<div class="row">
					<!-- Search button -->
					<button type='submit' class='btn btn_lg btn-success' name='search' value="Button1" onclick="return OnButton1();">Search</button>
					<!-- Save button -->
					<button type='submit' class='btn btn_lg btn-success' name='save' value="Button2" onclick="return OnButton2();">Save filters</button>
			</div>

</form>

<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover(); 
});
</script>

</body>

</html>