<?php session_start();
//In the case the page is just updated, we need to empty the session variable not to keep users in memory
if (!isset($_POST['validate'])){
	if(isset($_SESSION["id_user_list"])){
		unset($_SESSION["id_user_list"]);}} ?>

<html>

<head>
<!-----------------------------------------------------------
       US1-41 Create a project
Developped by Diane and Ophélie
This page contains the form to create a new project or to modify a project.
Needed pages : userprop.php, tab_donnees.class.php, funct_connex.php

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
				 include("en_tete.php");
?>

<!-- Function add_user for datalist -->
<script  src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script type="text/javascript">
	function add_user1(){
		$.ajax({
			type: 'get',
			dataType: 'html',
			url: 'userprop.php',
			timeout: 1000,
			data: {
				id_user_value: document.new_project.users_na.value
				},
			success: function (response) {
				document.getElementById("associated_users").innerHTML=response;
				},
			error: function () {
				alert('Query has failed');
			}
		});
	}
	function removeuser(){

	}

</script>

<?php
// Include the file with all the functions and variables
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
	<div class = "col-md-6"> <!-- column to create a project -->
	<form name='backtomanageproject' method='GET' action='US1_42_Gerer_projets.php'>
		<div class="row">
			<button type='submit' class='btn btn-info' name='back'>Back to projects</button>
		</div>
	</form>
	<div class="row">Fields marked with (*) are mandatory</div><br/>

	<form name='new_project' method='POST' onsubmit='return validate_project()' action='create_project.php' >
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
		</div></br>
		<div class ="row">
			<?php
				//Associate users to a project
				if (isset($_GET['id_project'])){
					$id_project = $_GET['id_project'];
					$result_users_associated = pg_query($connex, "select id_user_account,last_name, first_name
															from user_account
															where id_user_account IN (select id_user_account from link_project_users where id_project=$id_project)")
															or die ('Failed to fetch status');
					$table_user_a = new Tab_donnees($result_users_not_associated,"PG");
					$table_users_a1 = $table_user_a->t_enr;
					echo'<div class= "col-md-1"></div>';
					echo'<div class= "col-md-5"> Users associated to that project :</div>';
					$users=""; //variable with id of all the users affected to that project
					// table of users affected to that project for now
					for ($i=0;$i<count($table_users_a1);$i++){
						$users=$users+$table_users_a1[$i][0]+",";
						echo'<tr>';
							echo'<td>'.$table_users_a1[$i][1].' '.$table_users_a1[$i][2].'</td>';
							echo'<td><a href="#" onclick=removeuser()>Delete</a>';
						echo'</tr>';
					}
					$users=substr($users,-1);
				}else{
				// Query to get a table with all the users
					$result_users = pg_query($connex, "select id_user_account
														from user_account")
														or die ('Failed to fetch status');

					$users=0;
				}
				// Query to get users not yet associated to the project
				$result_users_not_associated = pg_query($connex, "select id_user_account,last_name, first_name
															from user_account
															where id_user_account NOT IN ($users)
															ORDER BY last_name")
															or die ('Failed to fetch status');

				$table_user_na = new Tab_donnees($result_users_not_associated,"PG");
				$table_users_na1 = $table_user_na->t_enr;

				//datalist with the users not associated
				echo'<div class= "col-md-1"></div>';
				echo'<div class= "col-md-5"><label for="Users"> Choose users to associate to the project :</label></div>';
				echo'<div class="col-md-6">';
				echo'<input list="users" type="text" id="users_na" autocomplete="off">';
					echo'<datalist id="users">';
							for($i=0; $i<count($table_users_na1); $i++){
								echo'<option value="'.$table_users_na1[$i][0].'" label="'.$table_users_na1[$i][1].' '.$table_users_na1[$i][2].'">'.$table_users_na1[$i][1].' '.$table_users_na1[$i][2].'</option>';
							}
					echo'</datalist>';
				$users_asso="";// Id of users affected to the project
				// button to add the selected user to the project
				echo'<input type="button" name="addu" value="Add a user" onclick="add_user1()">';
				echo'</div>';
				echo'<p> Associated user(s) : <span id="associated_users"></span></p>';

				/*// Query to get users associated to the current project
				$result_users_associated = pg_query($connex, "select last_name, first_name
															from user_account
															where id_user_account IN (select id_user_account from link_project_users where id_project=$id_project)")
															or die ('Failed to fetch status');
				$table_user_asso = new Tab_donnees($result_users_associated,"PG");
				$table_users_asso_1 = $table_user_asso->t_enr;

				// Cross the table to make a new one with first name and last name in the same column
				$nb1=count($table_users_asso_1);
				$table_users_asso_2=[];
				for ($n=0;$n<$nb1;$n++){
					$table_users_asso_2[$n]=$table_users_asso_1[$n][0]." ".$table_users_asso_1[$n][1];
				}
				echo '<div class="dropper">'; // div to create grey box where users associated to the project appear
				$nb2=count($table_users_asso_2);
				echo '<form name="users_not_project" method="GET" action="user_suggestion.php">';
				for ($j=0;$j<$nb2;$j++){
						echo '<button type="submit" class="btn btn-success" name="'.$j.'">'.$table_users_asso_2[$j].'</button>'; //buttons with users' names
				}*/
				echo'</div>';
			?>
		</div><br/>
		<div class="row">
			<button type='submit' class='btn btn-success' name='validate'>Validate and add users</button>
			<input type='hidden' name='id_project' value='<?php $id_project; ?>'>
		</div>
	</form>
	</div>


<?php	// Validate and add or modify the project
if(isset($_POST['validate'])){
	$id_users_asso=$_SESSION["id_user_list"];//to get users associated to the current project
	if (($_POST['id_project'])!=""){
		$id_project=$_POST['id_project'];
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

		//to add users to current project
		// a changer , faire nouvelle variable à remplir avec des for et des if pour avoir la bonne liste des users (cas d'une suppression)

		for ($i=0;$i<count($id_users_asso);$i++){
			$result_add_users = pg_query($connex, "INSERT INTO link_project_users(id_project, id_user_account)
													VALUES ('".$id_project."','".$id_users_update[$i]."')")
			 or die ('<div class="alert alert-danger">Failed to add project</div>');
		}
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

		// to have id_project of the project being created
		$result_id_project = pg_query($connex, "SELECT max(id_project) from projects")
				 or die ('<div class="alert alert-danger">Query failed</div>');
		$id_pro = new Tab_donnees($result_id_project,"PG");
		$id_project1 = $id_pro->t_enr;
		$id_new_project="";
		$id_new_project=$id_project1[0][0];

		//to add users to current project
		for ($i=0;$i<count($id_users_asso);$i++){
			$result_add_users = pg_query($connex, "INSERT INTO link_project_users(id_project, id_user_account)
													VALUES ('".$id_new_project."','".$id_users_asso[$i]."')")
			or die ('<div class="alert alert-danger">Failed to add project</div>');
		}
		echo '<div class="alert alert-success">';
			echo 'Project added';
		echo '</div>';

	}
echo'</div>'; //container

	}
?>

		<?php
				 include("pied_de_page.php");
		?>

</html>
