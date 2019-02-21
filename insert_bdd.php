<html>
<?php
session_start();
$comment=$_GET['txtAreaa'];
echo $comment;
echo $_SESSION['longitude'];
echo '</BR>';
echo $_SESSION['latitude'];
$date=$_GET['daterange'];
echo $date;
require "./tab_donnees/tab_donnees.class.php";
require "./tab_donnees/funct_connex.php";

$con = new Connex();
$connex = $con->connection;
$query = 'INSERT INTO fichiers(id_client,nom_client,prenom_client,adresse_client,cp_client,ville_client,tel_client,site_client,mail_client,photo_client) VALUES ("'.$code.'","'.$nom.'","'.$prenom.'","'.$adresse.'","'.$codepostal.'","'.$ville.'","'.$Tel.'","'.$site.'","'.$mail.'","'.$chill.'")';