<?php
//$connection = pg_connect("host=localhost port=5432 dbname=base_exo2 user=postgres password=postgres")or die ("Connexion impossible");
require "tab_donnees.class.php";
require "funct_connex.php";

$con = new Connex();
$connex = $con->connection;

$result= pg_query($connex, "SELECT * FROM projects");
$tab = new Tab_donnees($result,"PG");

//$tab->affich_simple_tableau_HTML  ();


$tab->creer_liste_option_plus ( "lst_proj", "id_project", "name_project");
?>