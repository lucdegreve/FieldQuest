<html>
		<head>
			<meta charset="utf-8">
			<title></title>
			<link rel="stylesheet" href="css/bootstrap.min.css">
			<link rel="stylesheet" href="css/custom.css">
		</head>

		<body>
			
			<!--  
			Fonction pour importer l'en_tete à mettre dans le début du body de votre page
			<?php
				 include('.../git/FieldQuest/en_tete.php');
			?>
			-->
				<nav class="navbar navbar-expand-lg navbar-dark bg-info">
				<?php
					session_start();
					$id_user_type=$_SESSION['id_user_type'];

					if ($id_user_type==1) 
					{
					?>
					<button class="btn btn-info" onclick="location.href='US0_page_accueil_admin.php'" >
					<img src="picto\back.png" class="img-fluid" alt="Responsive image" width="75px" height ="75px">
					</button>
					<?php
					}
					else if ($id_user_type==2)
					{
					?>
					
					<button class="btn btn-info" onclick="location.href='US0_page_accueil_externes.php'" >
					<img src="picto\back.png" class="img-fluid" alt="Responsive image" width="75px" height ="75px">
					</button>
					<?php
					}
					else if ($id_user_type==3)
					{
					?>
					<button class="btn btn-info" onclick="location.href='US0_page_accueil_internes.php'" >
					<img src="picto\back.png" class="img-fluid" alt="Responsive image" width="75px" height ="75px">
					</button>
					<?php
					}	
					?>

					<img src="picto\geosys_logo.png" class="rounded mx-auto d-block" alt="Responsive image" width="250px" height ="125px">
					<button class="btn btn-info" onclick="location.href='US_1.21_account_monitoring_by_user.php'" >
					<img src="picto\person.png" class="rounded float-right" alt="Responsive image" width="75px" height ="75px">
					</button>
					
				</nav>
		</body>
</html>