<?php
$connection = pg_connect("host=localhost port=5432 dbname=base_exo2 user=postgres password=postgres")or die ("Connexion impossible");
require "tab_donnees.class.php";

$result= pg_query($connection, "SELECT * FROM clients");
$tab = new Tab_donnees($result,"PG");

//$tab->affich_simple_tableau_HTML  ();


$tab->creer_liste_option_plus ( "lst_clients", "societe", "contact", "Alfreds");
?>