<html>

	<head>
		<!-- Coders : Axelle & Elsa -->
		<!-- Projects list, with searching, editing and deleting possibilities -->
		
		<META charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-2.2.4/dt-1.10.13/cr-1.3.2/fc-3.2.2/kt-2.2.0/r-2.1.0/rr-1.2.0/sc-1.4.2/se-1.2.0/datatables.min.css"/>
		<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-2.2.4/dt-1.10.13/cr-1.3.2/fc-3.2.2/kt-2.2.0/r-2.1.0/rr-1.2.0/sc-1.4.2/se-1.2.0/datatables.min.js"></script>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/custom.css" rel="stylesheet">
	</head>
	
	<body>
		
		<?php
				 include("en_tete.php");
		?>
		
		<?php
		include("tab_donnees/tab_donnees.class.php");
		//DB connection
		include("tab_donnees/funct_connex.php");
		$con=new Connex();
		$connex=$con->connection;
		//Query
		$result=pg_query($connex, "SELECT id_project, name_project, project_init_date FROM projects ORDER BY project_init_date DESC") or die('Échec de la requête : ' . pg_last_error());
		?>
		
		<!-- Header creation -->
		
                    </br>
                    <div align="center">
                            <h1>Manage projects</h1>
                    </div>
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
					$tab=new Tab_donnees($result,"PG");
					//Headers names
					$tab_headers[0]='Project name';
					$tab_headers[1]='Start date';
					//Columns
					$tab_display[0]='name_project';
					$tab_display[1]='project_init_date';
					$tab->creer_tableau("display nowrap", "projects", "", "", "id_project", "", "", "US1-41_create_project.php", "us_1_43_supprimer_un_projet.php", $tab_headers, $tab_display, "", "");
					?>
				</div>
			</div>
		</div>
		<?php
				 include("pied_de_page.php");
		?>
	</body>

</html>