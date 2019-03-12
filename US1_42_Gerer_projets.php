<html>

	<head>
		<!-- Coders : LIANTSOA -->
		<!-- Projects list, with searching, editing and deleting possibilities -->

		<META charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-2.2.4/dt-1.10.13/cr-1.3.2/fc-3.2.2/kt-2.2.0/r-2.1.0/rr-1.2.0/sc-1.4.2/se-1.2.0/datatables.min.css"/>
		<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-2.2.4/dt-1.10.13/cr-1.3.2/fc-3.2.2/kt-2.2.0/r-2.1.0/rr-1.2.0/sc-1.4.2/se-1.2.0/datatables.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			$('#example').DataTable();
		} );
		</script>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/custom.css" rel="stylesheet">
	</head>

	<body>

		<?php
				 include("en_tete.php");
		?>

		<?php
		include_once("tab_donnees/tab_donnees.class.php");
		//DB connection
		include_once("tab_donnees/funct_connex.php");
		$con=new Connex();
		$connex=$con->connection;
		?>
		
		<!-- Modify/add project sends back to this page and executes the query to change the database-->
<?php	// Validate and add or modify the project
if(isset($_POST['validate'])){
	$id_users_asso_after=$_SESSION["id_user_list"];//to get users associated to the current project
	if (($_POST['id_project'])!=""){
		$id_project=$_POST['id_project'];
		$project_name = $_POST['project_name'];
		$project_status = $_POST['status'];
		$project_desc = $_POST['project_desc'];
		$project_start = $_POST['begin_date'];
		// variable to get users associated to the project before modification and kept during modification
		$users_kept=$_SESSION["users_asso_before"];
		//to have users already associated before modif and the new ones in same variable
		if ($users_kept[0]!=""){
			for($i=0;$i<count($users_kept);$i++){
				$id_users_asso_after[]=$users_kept[$i][0];
			}
		}
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

		//to delete former users associated to the project
		$result_delete_users = pg_query($connex, "DELETE FROM link_project_users where id_project=$id_project")
			 or die ('<div class="alert alert-danger">Failed to add project</div>');


		//to add users to current project
		if ($id_users_asso_after[0]!=""){
			for ($i=0;$i<count($id_users_asso_after);$i++){
				$result_add_users = pg_query($connex, "INSERT INTO link_project_users(id_project, id_user_account)
														VALUES ('".$id_project."','".$id_users_asso_after[$i]."')")
				 or die ('<div class="alert alert-danger">Failed to add project</div>');
			}
		}
	} else {
		$query_new_id_project = "SELECT MAX(id_project) from projects";
		$result_new_id_project = pg_query($connex, $query_new_id_project) or die ('<div class="alert alert-danger">Failed to find new id for project</div>');
		$new_id_project = pg_fetch_row($result_new_id_project)[0]+1;
		$project_name = $_POST['project_name'];
		$project_status = $_POST['status'];
		$project_desc = $_POST['project_desc'];
		$project_start = $_POST['begin_date'];

		if ($_POST['end_date']!=""){
			$project_end = $_POST['end_date'];

			$query_add_project = "INSERT INTO projects (id_project, id_status, name_project, project_description, project_init_date, project_end_date)
				VALUES ('".$new_id_project."','".$project_status."', '".$project_name."', '".$project_desc."', '".$project_start."', '".$project_end."')";

		}else{
			$query_add_project = "INSERT INTO projects (id_project, id_status, name_project, project_description, project_init_date)
			VALUES ('".$new_id_project."','".$project_status."', '".$project_name."', '".$project_desc."', '".$project_start."')";
		}
		$result = pg_query($connex, $query_add_project) or die ('<div class="alert alert-danger">Failed to add project</div>');

		// to have id_project of the project being created
		$result_id_project = pg_query($connex, "SELECT max(id_project) from projects")
				 or die ('<div class="alert alert-danger">Query failed</div>');
		$id_pro = new Tab_donnees($result_id_project,"PG");
		$id_project1 = $id_pro->t_enr;
		$id_new_project="";
		$id_new_project=$id_project1[0][0];

		//to add users to current project being created
		if($id_users_asso_after!=NULL){
			for ($i=0;$i<count($id_users_asso_after);$i++){
				$result_add_users = pg_query($connex, "INSERT INTO link_project_users(id_project, id_user_account)
														VALUES ('".$id_new_project."','".$id_users_asso_after[$i]."')")
														or die ('<div class="alert alert-danger">Failed to add project</div>');
				}
			}
		echo '<div class="alert alert-success">';
			echo 'Project added';
		echo '</div>';

	}
}
?>
		
		
		<?php 
		//Query
		$result=pg_query($connex, "SELECT id_project, id_status, name_project  , TO_CHAR(project_init_date, 'DD/MM/YYYY')  FROM projects ORDER BY project_init_date DESC") or die('Échec de la requête : ' . pg_last_error());

			// Parcours des résultats ligne par ligne
			// Pour chaque ligne mysqli_fetch_array renvoie un tableau de valeurs

		?>


		</br>
		<div class="container">

			<div class="row">
				<div class="col-md-9"></div>
				<div class="col-md-3">
					<form name="add_project" action="US1-41_create_project.php" method="GET">
						<button type='submit' class='btn btn-success btn-block'><B>Add a project</B></button>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<?php
					//creation du tableau
						echo '<table id="example" class="display" border=0 bordercolor="black" bgcolor="white" size = 20>';

					// en tete du tableau

							echo '<thead>';
							echo '<tr>';
							echo '<th>' ;
							echo  'State';
							echo '</th>';
							echo '<th>' ;
							echo  'Project name';
							echo '</th>';
							echo '<th>' ;
							echo  'Date start';
							echo '</th>';
							echo '<th>' ;
							echo  'Edit';
							echo '</th>';
							echo '<th>' ;
							echo  'Delete';
							echo '</th>';
							echo '</tr>';
							echo '</thead>';

					//corps du tableau

							echo '<tbody>';
							while ($row = pg_fetch_array($result))
								{
									echo '<tr>' ;
										for($i=1; $i<  pg_num_fields($result); $i++)
										{
											
											if($i==1){
												echo '<td width="20">';
												if($row[$i]==2){
													echo "Finished";
													}
												else if($row[$i]==1){
													echo "On going";

													}
												else if($row[$i]==3){
													echo "Upcomming";
													}
												}
											else{
												echo '<td>';
												echo $row[$i]."  ";
												}
											echo '</td>';
										}
											// ajoute éventuellement la colonne edit
											echo '<td>';
												echo ("<a href = 'US1-41_create_project.php?id_project=".$row[0]."' class='btn btn-outline-warning btn-sm'>Edit</A>");
											echo '</td>';
											// ajoute éventuellement la colonne supprimer
											echo '<td>';

												echo ("<a href = 'us_1_43_supprimer_un_projet.php?id_project=".$row[0]."' class='btn btn-outline-danger btn-sm'>Delete</A>");
											echo '</td>';
									echo '</tr>';
								}
							echo '</tbody>';
						echo '</table>'

					?>
				</div>
			</div>
		</div></br></br>
		<?php
				 include("pied_de_page.php");
		?>
	</body>

</html>
