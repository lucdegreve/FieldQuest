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
		include("tab_donnees/tab_donnees.class.php");
		echo "</br>";
		//DB connection
		include("tab_donnees/funct_connex.php");
		$con=new Connex();
		$connex=$con->connection;
		//Query
		$result=pg_query($connex, "SELECT id_project, name_project  , TO_CHAR(project_init_date, 'DD/MM/YYYY')  FROM projects ORDER BY project_init_date DESC") or die('Échec de la requête : ' . pg_last_error());

			// Parcours des résultats ligne par ligne
			// Pour chaque ligne mysqli_fetch_array renvoie un tableau de valeurs


		?>

		<!-- Header creation -->


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
						echo '<table id="example" class="display" border=1 bordercolor="black" bgcolor="white" size = 30>';

					// en tete du tableau

							echo '<thead>';
							echo '<tr>';
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
											echo '<td>';
												echo $row[$i]."  ";
											echo '</td>';
										}
											// ajoute éventuellement la colonne edit
											echo '<td>';
												echo ("<a href = 'US1-41_create_project.php?id_project=".$row[0]."' class='lien'>Edit</A>");
											echo '</td>';
											// ajoute éventuellement la colonne supprimer
											echo '<td>';

												echo ("<a href = 'us_1_43_supprimer_un_projet.php?id_project=".$row[0]."' class='lien'>Delete</A>");
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
