<html>
<head>
<!-----------------------------------------------------------
       US1-10 Gerer les comptes
Developped by Ophélie
This page contains the table of all the user accounts.


Input variables :

Output variables :		id_user_account

Not done yet : Link with modify account page
------------------------------------------------------------->

<META charset="utf-8">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/custom.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-2.2.4/dt-1.10.13/cr-1.3.2/fc-3.2.2/kt-2.2.0/r-2.1.0/rr-1.2.0/sc-1.4.2/se-1.2.0/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-2.2.4/dt-1.10.13/cr-1.3.2/fc-3.2.2/kt-2.2.0/r-2.1.0/rr-1.2.0/sc-1.4.2/se-1.2.0/datatables.min.js"></script>


</head>
<body>
<?php
	// Include header
	include("en_tete.php");
	// Include files containing connexion to database & tab_donnees class
	require "tab_donnees/tab_donnees.class.php";
	require "tab_donnees/funct_connex.php";

	// Connexion to the database
	$con = new Connex();
	$connex = $con->connection;

	// Query for the list of user account
	$query_user_account = "SELECT acnt.id_user_account, acnt.last_name, acnt.first_name, acnt.company, type.name_user_type
		FROM user_account acnt JOIN user_type as type ON acnt.id_user_type = type.id_user_type";
	$result_user_account = pg_query($connex, $query_user_account) or die ("Failed to fetch user accounts");
	$table_user_account = new Tab_donnees($result_user_account,"PG");

?>

	<div class="container">
		<div class="row">
			<div class="col-md-9">			</div>
			<div class="col-md-3">
				<form name="add_account" action="US_1.11_create_user_account.php" method="GET">
					<button type='submit' class='btn btn-success btn-block'><B>Add an account</B></button>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12"> <!-- Table with user accounts  -->
				<?php
				//Headers names
				$tab_headers[0]='Last name';
				$tab_headers[1]='First name';
				$tab_headers[2]='Company';
				$tab_headers[3]='User type';
				//Columns
				$tab_display[0]='last_name';
				$tab_display[1]='first_name';
				$tab_display[2]='company';
				$tab_display[3]='name_user_type';
				$table_user_account->creer_tableau("display nowrap", "accounts", "", "", "id_user_account", "", "",
									"US_1.21_account_monitoring.php", "US1-12_Supprimer_compte.php",
									$tab_headers, $tab_display, "", "");
				?>
			</div>
		</div>
	<div class="row"></div>
	
	</div>
<br/><br/><br/><br/>
	<?php
	// Include footer
	include("pied_de_page.php");
	?>
</body>


</html>
