<html>
<head>
<!-----------------------------------------------------------
       US1-41 Create a project 
Developped by Diane and Ophélie			      
This page contains the form to create a new project or to modify a project.


Input variables : 		$id_project

Output variables :										
		name of the form : new_project
		variables submitted in the form : project_name, project_desc, begin_date, 
			end_date, status
------------------------------------------------------------->	

<META charset="utf-8"> 
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/custom.css">

<script language= "javascript" src="validate.js" type="text/javascript"></script>

</head>
<?php
// Include the file with all the functions 
require "tab_donnees/tab_donnees.class.php";
require "tab_donnees/funct_connex.php";


// Connexion with the database
$con = new Connex();
$connex = $con->connection;

// Query to get the list of project status
$query_status = "SELECT id_status, label_status FROM project_status";
$result_status = pg_query($connex, "SELECT id_status as stat, id_status, label_status FROM project_status") or die ('Failed to fetch status');
$table_status = new Tab_donnees($result_status,"PG");


if (!isset($_POST['id_project'])){	// Get the id of the project to modify and the informations related to the project
	//$id_project = $_POST['id_project'];	
	$id_project = 1;
	// Query to get the informations of the project to modify
	$query_modify_project = "SELECT id_status, name_project, project_description, project_init_date, project_end_date 
		FROM projects WHERE id_project = '".$id_project."'";
	$result_modify_project = pg_query($connex, $query_modify_project) or die ('Failed to get project');
	$row= pg_fetch_array($result_modify_project);
	$status = $row[0];
	$name_project = $row[1];
	$project_desc = $row[2];
	$init_date = $row[3];
	$end_date=$row[4];

	} else {		// If a new project is added
		$status = '';
		$name_project = '';
		$project_desc = '';
		$init_date ='';
		$end_date='';
}
?>

<h1> New project </h1>
Fields marked with (*) are mandatory
</br></br>
<form name='new_project' method='POST' onsubmit='return validate_project()' action='US1-41_create_project.php' >

<table>
    <tr><td>(*)</td><td>Project name </td>  	<td><input type="text" name="project_name" value="<?php echo $name_project; ?>"></td></tr>
    <tr><td>(*)</td><td>Date of beginning</td>  <td><input type="date" name="begin_date" value="<?php echo $init_date; ?>"></td></tr>
    <tr><td>   </td><td>Date of end</td>        <td><input type="date" name="end_date" value="<?php echo $end_date; ?>"></td></tr>
    <tr><td>   </td><td>Project description</td><td><textarea name="project_desc" rows="3"><?php echo $project_desc; ?></textarea></td></tr>    
	<tr><td>(*)</td><td>Status</td>             <td><?php $table_status->creer_liste_option_plus ( "status", "id_status", "label_status",$status); ?></td></tr>
</table>

<input type='submit' name='validate' value='Validate'>

</form>

<?php	// Validate and add or modify the project 
if(isset($_POST['validate'])){
	if ($id_project!=''){
		$project_name = $_POST['project_name'];
		$project_status = $_POST['status'];
		$project_desc = $_POST['project_desc'];
		$project_start = $_POST['begin_date'];
		if ($_POST['end_date']!=""){
			$project_end = $_POST['end_date'];
			
			$query_modify_project = "UPDATE projects SET id_status='".$project_status."', name_project='".$project_name."', project_description='".$project_desc."', 
			project_init_date='".$project_start."', project_end_date='".$project_end."' WHERE id_project = '".$id_project."'";
			
		}else{
			$query_modify_project = "UPDATE projects SET id_status='".$project_status."', name_project='".$project_name."', project_description='".$project_desc."', 
			project_init_date='".$project_start."',project_end_date=NULL WHERE id_project = '".$id_project."'";
		}
		$result = pg_query($connex, $query_modify_project) or die ('Failed to modify project');
			echo 'Project modified';
	} else {
		$project_name = $_POST['project_name'];
		$project_status = $_POST['status'];
		$project_desc = $_POST['project_desc'];
		$project_start = $_POST['begin_date'];
		
		if ($_POST['end_date']!=""){
			$project_end = $_POST['end_date'];
			
			$query_add_project = "INSERT INTO projects (id_status, name_project, project_description, project_init_date, project_end_date)
				VALUES ('".$project_status."', '".$project_name."', '".$project_desc."', '".$project_start."', '".$project_end."')";
		}else{
			$query_add_project = "INSERT INTO projects (id_status, name_project, project_description, project_init_date)
			VALUES ('".$project_status."', '".$project_name."', '".$project_desc."', '".$project_start."')";
		}
		$result = pg_query($connex, $query_add_project) or die ('Failed to add project');
			echo 'Project added';
	}	
}

?>
</html>