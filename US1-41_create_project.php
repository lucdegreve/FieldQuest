<html>

<head>
<!-----------------------------------------------------------
       US1-41 Create a project
Developped by Diane, Ophélie and Aurélie
This page contains the form to create a new project or to modify a project.
Display : yes
Needed/called pages : 	tab_donnees.class.php, funct_connex.php,
						userprop.php, update_list_1.php,
						removeuser.php, update_list_2.php,
						userdelete.php, update_list_3.php

Input variables : 		$id_project, $_SESSION["id_user_list"]

Output variables :
		name of the form : new_project
		variables submitted in the form : project_name, project_desc, begin_date,
			end_date, status, users_associated
------------------------------------------------------------->

<META charset="utf-8">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/custom.css">

<script language= "javascript" src="validate.js" type="text/javascript"></script>

</head>

<?php
				 include("en_tete.php");
				 
				//In the case the page is just updated, we need to empty the session variable not to keep users in memory
				if (!isset($_POST['validate'])){
					if(isset($_SESSION["id_user_list"])){
						unset($_SESSION["id_user_list"]);}} ?>


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
		$.ajax({
			type: 'get',
			dataType: 'html',
			url: 'update_list_1.php',
			timeout: 1000,
			data: {
				id_user_erase: document.new_project.users_na.value
				},
			success: function (response) {
				document.getElementById("list_users_a").innerHTML=response;
				},
			error: function () {
				alert('Query has failed');
			}
		});
	}

	function removeuser1(str){
		$.ajax({
			type: 'get',
			dataType: 'html',
			url: 'removeuser.php',
			timeout: 1000,
			data: {
				id_user_value:str
				},
			success: function (response) {
				document.getElementById("associated_users").innerHTML=response;
				},
			error: function () {
				alert('Query has failed');
			}
		});
		$.ajax({
			type: 'get',
			dataType: 'html',
			url: 'update_list_2.php',
			timeout: 1000,
			data: {
				id_user_add: str
				},
			success: function (response) {
				document.getElementById("list_users_a").innerHTML=response;
				},
			error: function () {
				alert('Query has failed');
			}
		});
	}

	function deleteuser1(str){
		$.ajax({
			type: 'get',
			dataType: 'html',
			url: 'userdelete.php',
			timeout: 1000,
			data: {
				id_user_to_delete:str
				},
			success : function(response){
                document.getElementById("associated_users_before").innerHTML=response;
				},
			error: function () {
				alert('Query has failed');
			}
		});
		$.ajax({
			type: 'get',
			dataType: 'html',
			url: 'update_list_3.php',
			timeout: 1000,
			data: {
				id_user_add2: str
				},
			success: function (response) {
				document.getElementById("list_users_a").innerHTML=response;
				},
			error: function () {
				alert('Query has failed');
			}
		});
	}

</script>

<?php
// Include the file with all the functions and variables
require_once "tab_donnees/tab_donnees.class.php";
require_once "tab_donnees/funct_connex.php";



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

	<form method="GET"  action="US1_42_Gerer_projets.php">

			<button type="submit" class="btn btn-outline-info btn-md">Back</button>

	</form>


	<h4 align="center">Please fill all the information</h4>
</br>
<div class="row"><strong>NB : Fields marked with (*) are mandatory</strong></div><br/>


<form name='new_project' method='POST' onsubmit='return validate_project()' action='US1_42_Gerer_projets.php'>
	<div class="input-group mb-3">
			<div class="input-group-prepend">
					<span class="input-group-text"> (*) Project name : </span>
			</div>
			</br>
			<input type="text" name="project_name" value="<?php echo $name_project; ?>" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
	</div>
	<div class="input-group mb-3">
			<div class="input-group-prepend">
					<span class="input-group-text"> (*) Date of beginning : </span>
			</div>
			</br>
			<input type="date" name="begin_date" value="<?php echo $init_date; ?>" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
	</div>
	<div class="input-group mb-3">
			<div class="input-group-prepend">
					<span class="input-group-text"> (*) Date of end : </span>
			</div>
			</br>
			<input type="date" name="end_date" value="<?php echo $end_date; ?>" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
	</div>
	<div class="input-group mb-3">
			<div class="input-group-prepend">
					<span class="input-group-text"> (*) Project description : </span>
			</div>
			</br>
			<textarea class="form-control" aria-label="With textarea" aria-describedby="inputGroup-sizing-default" name="project_desc" rows="3"><?php echo $project_desc; ?></textarea>
	</div>
	<div class="input-group mb-3">
			<div class="input-group-prepend">
					<span class="input-group-text"> Tag type :</span>
			</div>
			<?php $table_status->creer_liste_option_plus ( "status", "id_status", "label_status",$status); ?>
	</div>


			<?php
				//Associate users to a project
				echo '<div class ="row">';
				if (isset($_GET['id_project'])){
					$id_project = $_GET['id_project'];
					$result_users_associated = pg_query($connex, "select id_user_account,last_name, first_name
															from user_account
															where id_user_account IN (select id_user_account from link_project_users where id_project=$id_project)")
															or die ('Failed to fetch status');
					$table_user_a = new Tab_donnees($result_users_associated,"PG");
					$table_users_a1 = $table_user_a->t_enr;

					$_SESSION["users_asso_before"]=$table_users_a1; //for ajax dynamic part in userdelete.php
					echo 'Users associated to that project :';
					$users=[]; //variable with id of all the users affected to that project
					// table of users affected to that project for now
					echo'<div id="associated_users_before">';
						echo'<table>';
						if ( $table_user_a->nb_enr !=0){
							for ($i=0;$i<count($table_users_a1);$i++){
								$users[]=$table_users_a1[$i][0];
								echo'<tr id='.$i.'>';
									echo'<td>'.$table_users_a1[$i][1].' '.$table_users_a1[$i][2].'</td>';
									echo'<td><button type="button" name="delete_user" class="btn btn-outline-danger" onclick=deleteuser1('.$table_users_a1[$i][0].')>Delete </button>';
								echo'</tr>';
							}
						}
						echo '</table>';
					echo'</div>';
					//$users_all_details=$_SESSION["users_asso_before"];
					//$users=array_column($users_all_details,0);
					if ($users[0]==""){
						$result_users_not_associated = pg_query($connex, "select id_user_account,last_name, first_name
															from user_account
															ORDER BY last_name")
															or die ('Failed to fetch status');
					}
					else{
						$users=implode(",",$users); //transforms table to list
						$result_users_not_associated = pg_query($connex, "select id_user_account,last_name, first_name
															from user_account
															where id_user_account NOT IN ($users)
															ORDER BY last_name")
															or die ('Failed to fetch status');
					}
					$table_user_na = new Tab_donnees($result_users_not_associated,"PG");
					$table_users_na1 = $table_user_na->t_enr;
					$_SESSION["users_not_asso_before"]=$table_users_na1; //for ajax dynamic part in update_list.php

					//datalist with the users not associated

					echo'Choose users to associate to the project :';
					echo'<div id="list_users_a">';
					echo'<input list="users" type="text" id="users_na" autocomplete="off">';
						echo'<datalist id="users">';
								for($i=0; $i<count($table_users_na1); $i++){
									echo'<option value="'.$table_users_na1[$i][1].'">'.$table_users_na1[$i][1].' '.$table_users_na1[$i][2].'</option>';
								}
						echo'</datalist>';

					// button to add the selected user to the project
					echo'<button name="addu" type="button" class= "btn btn-outline-warning" onclick="add_user1()">Add a user </button>';
					echo'</div>';
					echo'<p> Associated user(s) : <span id="associated_users"></span></p>';

				}else{

					// Query to get users not yet associated to the project
					$result_users_not_associated = pg_query($connex, "select id_user_account,last_name, first_name
																from user_account
																ORDER BY last_name")
																or die ('Failed to fetch status');

					$table_user_na = new Tab_donnees($result_users_not_associated,"PG");
					$table_users_na1 = $table_user_na->t_enr;
					$_SESSION["users_not_asso_before"]=$table_users_na1; //for ajax dynamic part in update_list.php

					//datalist with the users not associated


					echo '<fieldset style="width: 335px">
					<input class="form-control" type="text" placeholder="Choose users to associate to the project :" readonly>
					</fieldset>';

					echo'<div id="list_users_a" class="col-md-6">';
					echo'<input list="users" type="text" id="users_na" autocomplete="off">';
						echo'<datalist id="users">';
								for($i=0; $i<count($table_users_na1); $i++){
									echo'<option value="'.$table_users_na1[$i][1].'" >'.$table_users_na1[$i][1].' '.$table_users_na1[$i][2].'</option>';
								}
						echo'</datalist>';

					// button to add the selected user to the project
					echo'<button type="button" name="addu" class="btn btn-md btn-outline-warning" onclick="add_user1()">Add a user</button>';
					echo'</div></br>';
					echo'<div class="container" align="center">';
					echo '<fieldset style="width: 170px">
					<input class="form-control" type="text" placeholder="Associated user(s) :" readonly>
					</fieldset>';
					echo '<span id="associated_users"></span></div>';
				}

			echo'</div>';
			?>
		<br/>

		<div align="center">
			<button type='submit' class='btn btn-lg btn-outline-success' name='validate'>Validate and add users</button>
			<input type='hidden' name='id_project' value='<?php echo $id_project; ?>'>
		</div>

	</form>
	</div>
</div> <!-- container->
		<?php
				 include("pied_de_page.php");
		?>

</html>
