<html>
<?php session_start(); ?>
<head>
<!-----------------------------------------------------------
       US4-22 - Filter for user history of upload- Query 
	   
Developped by Ophélie			      
This page contains the query to search for files (validated or not) in the user's history using filters. 

It should be used in the page displaying the result of the filtered search. 

Input variables : 		

Output variables :		
		
------------------------------------------------------------->	

<META charset="utf-8"> 
</head>
<body>
<?php
// Include funct_connex file in super page containing the display of the result of the filtered search (see Liantsoa?) 

$id_user = $_SESSION['id_user'];
//Query : filtered search
	$query="SELECT f.id_original_file, MIN(f.upload_date)
			FROM files f
				LEFT JOIN version v on f.id_version = v.id_version
				LEFT JOIN link_file_project lfp ON lfp.id_file=f.id_file
				LEFT JOIN projects p ON lfp.id_file=p.id_project
				LEFT JOIN format fr ON fr.id_format=f.id_format
				LEFT JOIN user_account u ON u.id_user_account=f.id_user_account
				LEFT JOIN link_tag_project ltp ON ltp.id_file=f.id_file
				LEFT JOIN tags t ON t.id_tag=ltp.id_tag
			WHERE f.id_user_account = '".$id_user."' AND ";
	// Selected start date 
	if (isset($_POST['start'])){
			if ($_POST['start']!=''){
					$start_date = $_POST['start'];

					$query .= " f.upload_date >'".$start_date."' AND ";
			}
	}
	// Selected end date
	if (isset($_POST['end'])){
			if ($_POST['end']!=''){
					$end_date = $_POST['end'];
					$query .= " f.upload_date <'".$end_date."' AND ";
			}
	}

	// List of selected format
	if (isset($_POST['format'])){
			$query .= " f.id_format IN (";
			foreach ($_POST['format'] AS $i){
					$query .= $i.", ";
			}
			$query = substr($query, 0, strlen($query) -2);
			$query .= ")";
			$query .= " AND ";
	}

	// list of selected projects
	if (isset($_POST['projet'])){
		
			$query .= " lfp.id_project IN (";
			foreach ($_POST['projet'] AS $i){
					$query .= $i.", ";
			}
			$query = substr($query, 0, strlen($query) -2);
			$query .= ")";
			$query .= " AND ";
			
	}
	//TAG_SLD = list of tag selected (units included)
	$TAG_SLD='(';

	if (isset($_POST['unit'])){
			foreach ($_POST['unit'] AS $i){
					$TAG_SLD .= $i.", ";
			}
			echo '</br>';
	}

	if (isset($_POST['tag'])){
			foreach ($_POST['tag'] AS $i){
					$TAG_SLD .= $i.", ";
			}
			echo '</br>';
	}
	// add condition on tag in query if list of tags not empty
	if ($TAG_SLD!='('){
			$query .= " ltp.id_tag IN ".$TAG_SLD;
			$query = substr($query, 0, strlen($query) -2);
			$query .= ")";
	}

	//Cut end of query (unecessary WHERE or AND)
	if (substr($query, -6)=='WHERE '){
		$query = substr($query, 0, strlen($query) -6);
	}

	if (substr($query, -4)=='AND '){
		$query = substr($query, 0, strlen($query) -4);
	}
	
	$query .= " GROUP BY f.id_original_file ORDER BY MIN(f.upload_date) DESC";


//Query : list of distinct file names

$result_files_id=pg_query($connex, $query) or die('Query failed : ' . pg_last_error());
$nbrows=pg_num_rows($result_files_id);
                
?>
</body>
</html>