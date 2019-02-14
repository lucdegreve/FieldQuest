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


if (isset($_GET['id_project'])){	// Get the id of the project to modify and the informations related to the project
	$id_project = $_GET['id_project'];	

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

<div class="container">
	<div class = "col-md-6">
	<form name='backtomanageproject' method='GET' action='US1_42_Gerer_projets.php'>
		<div class="row">
			<button type='submit' class='btn btn-info' name='back'>Back to projects</button>
		</div>
	</form>
	<div class="row">Fields marked with (*) are mandatory</div><br/>
	
	<form name='new_project' method='POST' onsubmit='return validate_project()' action='US1-41_create_project.php' >
		<div class ="row">	
			<div class= "col-md-1">(*)</div>
			<div class= "col-md-5">Project name </div>
			<div class = "col-lg-6"><input type="text" name="project_name" value="<?php echo $name_project; ?>" placeholder="Project name"></div>
		</div><br/>
		<div class ="row">
			<div class= "col-md-1">(*)</div>
			<div class= "col-md-5">Date of beginning</div>
			<div class="col-md-6"><input type="date" name="begin_date" value="<?php echo $init_date; ?>"></div>
		</div><br/>
		<div class ="row">
			<div class= "col-md-1"> </div>
			<div class= "col-md-5">Date of end </div>
			<div class="col-md-6"><input type="date" name="end_date" value="<?php echo $end_date; ?>"></div>
		</div><br/>
		<div class ="row">	
			<div class= "col-md-1"></div>
			<div class= "col-md-5">Project description </div>
			<div class="col-md-6"><textarea name="project_desc" rows="5"><?php echo $project_desc; ?> </textarea></div>
		</div><br/>
		<div class ="row">
			<div class= "col-md-1">(*)</div>
			<div class= "col-md-5">Status </div>
			<div class="col-md-6"><?php $table_status->creer_liste_option_plus ( "status", "id_status", "label_status",$status); ?></div>
		</div><br/>
		<div class="row">
			<button type='submit' class='btn btn-success' name='validate'>Validate</button>
		</div>
		</form>
	</div>

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
		$result = pg_query($connex, $query_modify_project) or die ('<div class="alert alert-danger">Failed to modify project</div>');
			echo '<div class="alert alert-success">Project modified</div>';
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
		$result = pg_query($connex, $query_add_project) or die ('<div class="alert alert-danger">Failed to add project</div>');
			echo '<div class="alert alert-success">';
				echo 'Project added';
			echo '</div>';
			
	}	
}

?>
</div> <!--container-->

</html>