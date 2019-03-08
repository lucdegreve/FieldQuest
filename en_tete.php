<html>
		<head>
			<meta charset="utf-8">
			<title></title>
			<link rel="stylesheet" href="css/bootstrap.min.css">
			<link rel="stylesheet" href="css/custom.css">
		</head>

		<body>

			
				<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
				<?php
					class Connex2
						{
							
							public $connection ;

							 public function __construct(){
								 $this->connection = pg_connect("host=localhost port=5432 dbname=fieldquest user=postgres password=postgres")or die ("Connexion impossible");
							 }
							 
						}
					session_start();
					$id_user_type=$_SESSION['id_user_type'];
					if (isset($_SESSION['id_user_account'])){
						$id_user=$_SESSION['id_user_account'];
						$con = new Connex2();
						$connex = $con->connection;
						$result= pg_query($connex, "SELECT last_name FROM user_account where id_user_account=$id_user"); // selects the last name of the user
						while($name=pg_fetch_array($result)){
							$nom_user=$name[0];
						}
					}
					if ($id_user_type==1) 
					{
					?>
					<button class="btn btn-primary" onclick="location.href='US0_page_accueil_admin.php'" >
					<img src="picto\back.png" class="img-fluid" alt="Responsive image" width="75px" height ="75px">
					</button>
					<?php
					}
					else if ($id_user_type==3)
					{
					?>
					
					<button class="btn btn-primary" onclick="location.href='US0_page_accueil_externes.php'" >

					<img src="picto\back.png" class="img-fluid" alt="Responsive image" width="75px" height ="75px">
					</button>
					<?php
					}
					else if ($id_user_type==2)
					{
					?>
					<button class="btn btn-primary" onclick="location.href='US0_page_accueil_internes.php'" >
					<img src="picto\back.png" class="img-fluid" alt="Responsive image" width="75px" height ="75px">
					</button>
					<?php
					}	
					?>

					<img src="picto\geosys_logo.png" class="rounded mx-auto d-block" alt="Responsive image" width="250px" height ="125px">
					<button class="btn btn-primary" onclick="location.href='US_1.21_account_monitoring_by_user.php'" >
					<?php echo '<h2><B>'.$nom_user.'</B></h2>'; ?>
					<img src="picto\person.png" class="rounded float-right" alt="Responsive image" width="75px" height ="75px">
					<a href="US_0_11_login_page .php?disconnect=1"> 
					<button class="btn btn-primary" > 
					<img src="picto\deconnect.png" class="rounded float-right" alt="Responsive image" width="75px" height ="75px">
					</button>
					</a>
					
					</button>
					
				</nav>
		</body>
</html>