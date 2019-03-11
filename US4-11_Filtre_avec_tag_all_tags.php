<html>
<head>
<!-----------------------------------------------------------
       US4-11 Filtrer avec des tags - File format  
Developped by OphÃƒÆ’Ã‚Â©lie	& Diane		      
This page contains code to display the filter labels:
- US4-11_Filtrer_avec_tag_project.php
- US4-11_Filtrer_avec_tag_format.php
- US4-11_Filtrer_avec_tag_unit.php
- US_4_11_filtre_avec_tag_data_type.php

Modified by Eva to add the "save a query" page

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
	if ($_SESSION['id_user_type']!=3){
	//Include page with filter for validation state 
		include "US4-11_Filtrer_avec_validation_state.php"; 
	}
	// Include page with collapse button & content for project names
	include "US4-11_Filtrer_avec_tag_project.php"; 
	?>
	<!-- Collapse button for date (start and end)-->
	<p>
		<button class="btn btn-primary btn-sm btn-block" type="button" data-toggle="collapse" data-target="#collapseDate" aria-expanded="true" aria-controls="collapseDate">
			Date
		</button>
	</p>
	<?php
	echo '<div class="collapse" id="collapseDate">';
	echo	'<div class="card card-body">';
	echo		'<label for ="start_date">from</label>';
	//If a favorite search has been launched, we complete the filter "date"(begin and end) with the dates required in the favorite search
	if (isset($begin_date_fs)){
		echo	'<input type = "date" name ="start" id="start_date" value='.$begin_date_fs.'>';
	}
	else {
		echo '<input type = "date" name ="start" id="start_date">';
	}		
	echo		'<label for ="end_date">to</label>';
	if (isset($end_date_fs)){
		echo		"<input type='date' name ='end' id='end_date' value=".$end_date_fs.">";
	}
	else {
		echo		"<input type='date' name ='end' id='end_date' >";
	}
	echo	"</div>";
	echo "</div>";
	?>
	
	<?php
	// Include page with collapse button & content for file format 
	include "US4-11_Filtrer_avec_tag_format.php"; 
	// Include page with collapse button & content for unit 
	include "US4-11_Filtrer_avec_tag_unit.php";
	// Include page with source bar search 
	if ($_SESSION['id_user_type']!=3){
	include "US4_11_Requete_source_final.php";
	}
	// Include page with collapse button & content for data type 
	include "US_4_11_filtre_avec_tag_data_type.php";
	
	?>
	
			<div class="row mx-auto">
					<!-- Search button -->
					<button type='submit' class='btn btn_lg btn-success' name='search' value="Button1" onclick="return OnButton1();">Search</button>
					<!-- Save button -->
					<button type='submit' class='btn btn_lg btn-success' name='save' value="Button2" onclick="return OnButton2();">Save filters</button>
					
					<?php 
				
				// If the user saved a favorite search in the "Save filter" page 
				// We show a message "A new favorite search has been saved" and we add the data in the database
				if (isset($_POST['Save_in_favorite'])) { 
					
				echo '</br> <p><font color="red"> A new favorite search has been saved </font></p>';
				
						
						$startdate = NULL;
						$enddate = NULL;
						
						if (isset($_POST['start'])){
							$startdate = $_POST['start'];
						}
						
						if (isset($_POST['end'])){
							$enddate = $_POST['end'];
						}
						
						$queryid = "SELECT MAX(id_favorite_search) FROM favorite_search";
						$result=pg_query($connex, $queryid) or die('Query failed : ' . pg_last_error());
						$rowid=pg_fetch_array($result);
						$idsearch=$rowid[0]+1;
						
						$queryinsert ="INSERT INTO favorite_search (id_favorite_search, id_user_account, search_label, comment, status_public_private, status_on_off, begin_date, end_date) VALUES ('".$idsearch."', '".$_SESSION['id_user_account']."', '".$_POST['name']."', '".$_POST['comment']."', true, true, '".$startdate."', '".$enddate."')";
						$result=pg_query($connex, $queryinsert) or die('Query failed : ' . pg_last_error());	
						
						// a ajouter dans BD dès que la table est créée
						/*if (isset($_POST['valid'])){
							foreach ($_POST['valid'] AS $i){
                    		$queryinsert ="INSERT INTO link_validation_fs (id_validation_state, id_favorite_search) VALUES ('".$i."', '".$idsearch."');
                    		$result=pg_query($connex, $queryinsert) or die('Query failed : ' . pg_last_error());
                    		}
						}*/
						
						if (isset($_POST['format'])){
                    		foreach ($_POST['format'] AS $i){
                    		$queryinsert ="INSERT INTO link_format_fs (id_format, id_favorite_search) VALUES ('".$i."', '".$idsearch."')";
                    		$result=pg_query($connex, $queryinsert) or die('Query failed : ' . pg_last_error());
                    		}
                    	}
                    	
                    	if (isset($_POST['project'])){
                    		foreach ($_POST['project'] AS $i){
                    		$queryinsert ="INSERT INTO link_projects_fs (id_project, id_favorite_search) VALUES ('".$i."', '".$idsearch."')";
                    		$result=pg_query($connex, $queryinsert) or die('Query failed : ' . pg_last_error());
                    		}
                    	}
                    	
                    	// a ajouter dans BD dès que la table est créée
						/*if (isset($_POST['sources'])){
                    		foreach ($_POST['sources'] AS $i){
                    		$queryinsert ="INSERT INTO link_sources_fs (id_source, id_favorite_search) VALUES ('".$i."', '".$idsearch."');
                    		$result=pg_query($connex, $queryinsert) or die('Query failed : ' . pg_last_error());
                    		}
                    	}*/
                    	
                    	if (isset($_POST['unit'])){
                    		foreach ($_POST['unit'] AS $i){
                    		$queryinsert ="INSERT INTO link_tags_fs (id_tag, id_favorite_search) VALUES ('".$i."', '".$idsearch."')";
                    		$result=pg_query($connex, $queryinsert) or die('Query failed : ' . pg_last_error());
                    		}
                    	}
                    	
						if (isset($_POST['tag'])){
                    		foreach ($_POST['tag'] AS $i){
                    		$queryinsert ="INSERT INTO link_tags_fs (id_tag, id_favorite_search) VALUES ('".$i."', '".$idsearch."')";
                    		$result=pg_query($connex, $queryinsert) or die('Query failed : ' . pg_last_error());
                    		}
                    	}
                    							
					} 
						
					?>


                        </div>

</form>

<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover(); 
});
</script>

</body>

</html>