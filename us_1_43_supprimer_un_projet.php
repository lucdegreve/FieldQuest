<html>
	<head>
	<!-- Page developed by Aurélie Jambon -->
	<!-- Verifying that there is no files in a project before to delete it -->
	<!-- recuperation de la variable id_project -->
	<META charset="UTF-8">
	</head>
		<body>
		<?php
				 include("en_tete.php");
		?>
		
		<?php
				$id_project= $_GET["id_project"];
				if (isset($_GET['delete'])){
		
		$id_project= $_GET['id_proj'];
		require "tab_donnees/tab_donnees.class.php";
		require "tab_donnees/funct_connex.php";
		$con = new Connex();
		$connex = $con->connection;
		$result= pg_query($connex, "SELECT id_file FROM link_file_project where id_project=$id_project"); // selects the files of a project

		$nb_files = pg_num_rows($result);
		if($nb_files ==0){
			$sql = pg_query($connex,'Delete from projects where id_project='.$id_project.'');  // if the project is empty we can delete it
			$sql2 = pg_query($connex,'Delete from link_project_users where id_project='.$id_project.'');  // if the project is empty all the we can delete it
			echo'The project has been deleted';
			echo "</br></br></br></br>";
			echo '<form name="return" action="US1_42_Gerer_projets.php" method="POST">
					              		<input type="submit" name="return" value="Return to data management page">
					         		</form>';
			echo "</br></br></br></br></br></br></br>";
			}
		else {
			echo"The project isn't empty and cannot be deleted";
			echo "</br></br></br></br>";
			echo '<form name="return" action="US1_42_Gerer_projets.php" method="POST">
					              		<input type="submit" name="return" value="Return to data management page">
					         		</form>';
			echo "</br></br></br></br></br></br></br>";
			}

		}
else {
		?>
		
		<!-- Message to check if the user really want to delete a project -->
		<div class="container-fluid">
		
			<br/><br/><br/>
			<div class="row">
				<div class="col-3">
				</div>
				<div class="col-6">
					<div class="card text-center">
					  <div class="card-body">
					    <h5 class="card-title">Do you really want to delete this project <?php echo $id_project; ?> ?</h5>
					    <p class="card-text"> 
					    	<div class="row">
					    		<div class="col-4">
								</div>
						    	<div class="col-2">
						    		<!-- we create a hidden input to keep the value of the id_project once the form is set-->
								    <form name="suppr" action="us_1_43_supprimer_un_projet.php" method="GET">
								    	<input type="hidden" name="id_proj" value="<?php echo $id_project; ?>">
					              		<input type="submit" name="delete" value="Yes">
					         		</form>
					         	</div>
					         	<div class="col-2">
					         	<!-- we create a button to go back to the page "manage the projects" -->
					         		<form name="return" action="US1_42_Gerer_projets.php" method="POST">
					              		<input type="submit" name="return" value="No / Return">
					         		</form>
			         			</div>
			         			<div class="col-4">
								</div>
			         		</div>
					    </p>
					  </div>
					</div>
				</div>
				<div class="col-3">
				</div>
			</div>
		</div>
		

		<!-- If the user click on YES -->


		
		<?php
}
				 include("pied_de_page.php");
		?>
		
	</body>
</html>
