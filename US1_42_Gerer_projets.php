<html>

	<head>
		<!-- Coders : Axelle & Elsa -->
		<!-- Projects list, with searching, editing and deleting possibilities -->
		
		<META charset="UTF-8">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/custom.css" rel="stylesheet">
	</head>
	
	<body>

		<?php
		//DB connection
		$connection=pg_connect("host=localhost port=5432 dbname=FieldQuest user=postgres password=mdppostgresql")or die ("Connexion impossible");
		//Query
		$result=pg_query($connection, "SELECT id_project, name_project FROM projects ORDER BY name_project") or die('Échec de la requête : ' . pg_last_error());
		while ($row=pg_fetch_row($result)) {
		   $id_project=$row[0];
		   $name_project=$row[1];
		}
		$nbrows=pg_num_rows($result);
		?>
		
		<!-- Header creation -->
		<div class="jumbotron jumbotron-fluid">
			<h1>Header</h1>
		</div>
		
		<?php
		//Modify the query in case you typed something in the research bar : à modifier !
		if(isset($_GET['search']) AND $_GET['search']!=""){
			$search=$_GET['search'];
			$result=pg_query($connection, "SELECT id_project, name_project FROM projects WHERE name_project LIKE '%".$search."%' ORDER BY name_project") or die('Échec de la requête : ' . pg_last_error());
			while ($row=pg_fetch_row($result)) {
			   $id_project=$row[0];
			   $name_project=$row[1];
			}
			$nbrows=pg_num_rows($result);
		}
		?>
		
		<div class="container">
			<div class="row">
				<!-- Create a search bar to look for a project -->
				<div class="col-md-8">
					<form name="research_bar" method="GET">
						<input type="search" name="search" size="50" placeholder="Search a project...">
						<input type="submit" value="Submit">
					</form>
				</div>
				<!-- Create a button to add a new project -->
				<div class="col-md-4">
					<form name="add_project" action="#" method="GET">
						<button type='submit' class='btn btn-success btn-block'><B>Add a project</B></button>
					</form>
				</div>
			</div>
			</br>
			<div class="row">
				<!-- Create the table returning the name of each project and two buttons: "edit" and "delete" -->
				<table class="table table-striped">
					<tr>
						<th scope="col" width=80%>Nom du projet</th>
						<td width=10%></td>
						<td width=10%></td>
					</tr>
					<?php
					for ($i=0;$i<$nbrows;$i++){
						echo "<tr>";
							echo "<td>".$tab[$i][1]."</td>";
							echo '<form name="edit_project" action="#" method="GET">';
								echo "<td><button type='submit' class='btn btn-primary' name='#' value='#'>Edit</button></td>";
							echo "</form>";
							echo '<form name="delete_project" action="us_1_43_supprimer_un_projet.php" method="GET">';
								echo "<td><button type='submit' class='btn btn-danger' name='id_project' value='".$tab[$i][0]."'>Delete</button></td>";
							echo "</form>";
						echo "</tr>";
					}
					?>
				</table>
			</div>
		</div>
		
	</body>

</html>