<!DOCTYPE html>

<!-- Rédigé par Clément et Liantsoa -->
<!-- Ce code permet d'afficher le menu des utilisateurs administrateurs avec l'ensemble des fonctionnalites accessibles dans un onglet -->
<!-- Il est à insérer en dessous de l'entete et au dessus du corps de la page-->
<!-- Il reste encore à inserer les liens des pages -->

<html>

<head>
    <title>Menu interne</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/Header-Icons.css">
</head>

<body>
  <?php
  require "tab_donnees/tab_donnees.class.php";
  require "tab_donnees/funct_connex.php";
  $con = new Connex();
  $connex = $con->connection;
  $result= pg_query($connex, "SELECT id_file FROM files WHERE id_validation_state = 1");
  $nb_files = pg_num_rows($result);
  ?>
    <nav class="navbar navbar-default" id="colorful-nav">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li class="info"><a href="US1-10_Gerer_comptes.php"><span class="glyphicon glyphicon-user"></span><h5>ACCOUNT MANAGEMENT</h5></a></li>
					<li class="info"><a href="US1_42_Gerer_projets.php"><span class="glyphicon glyphicon-folder-close"></span><h5>PROJECTS MANAGEMENT</h5></a></li>
					<li class="info"><a href="US_2_21_dragdrop_index.php"><span class="glyphicon glyphicon-file"></span><h5>UPLOAD DATA</h5></a></li>
					<li class="info"><a href="US4_22_Main_page_history_with_filters.php"><span class="glyphicon glyphicon-list-alt"></span><h5>MY UPLOADS</h5></a></li>
                    <!-- <li class="info"><a href="US3_11_Visualiser_liste_fichiers.php"><span class="glyphicon glyphicon-list"></span><h5>FILES LIST</h5></a></li> -->
					<li class="info"><a href="US4-11_Main_page_filter.php"><span class="glyphicon glyphicon-tasks"></span><h5>FIND A FILE
            <?php
            if ($nb_files!=0){
            echo'<span class="badge badge-danger">'.$nb_files.'</span>';
            }
            ?>
          </h5></a></li>
					<li class="info"><a href="US1-54_manage_tags.php"><span class="glyphicon glyphicon-tags"></span><h5>TAGS MANAGEMENT</h5></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>