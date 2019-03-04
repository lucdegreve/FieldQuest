<!doctype html> 

<!-- Développeurs: JB-Fagniné
Page to update data of the modified file in the database and to confirm it to the user -->
<html lang="en">

<head>

<?php
				 session_start();
				 include("en_tete.php");
		?>

		

        <link href="css/custom.css" rel="stylesheet" type="text/css">
		<link href="css/boostrap.min.css" rel="stylesheet" type="text/css">
        <script src="US_2_21_dragdrop_jquery-3.0.0.js" type="text/javascript"></script>
        <script src="US_2_21_dragdrop_script.js" type="text/javascript"></script>
 <title >Your modification was considered</title>
 
 		
  
 


</head>

<body>
<br/><br/>
<h1  align="center">Your modification was considered </h1> </br>
<?php

require "./tab_donnees/funct_connex.php";
$con = new Connex();
$connex = $con->connection;
//On met une valeur en dur pour l'id_user_account pour l'instant
$id_user_account=1;

//Tous les écho ci dessous ne seront pas présent plus tard mais ils aident pour travailler sur la page!
echo "File name: ".$_SESSION["upload_filename"]."<br/>";
echo "File location: ".$_SESSION["upload_location"]."<br/>";
echo "File modification date: ".$_SESSION["upload_date"]."<br/>";
echo "File new size (octet): ".$_SESSION["upload_file_size"]."<br/>";
echo "Id of the original file: ".$_SESSION["idfile"];
echo "<br/>Id of the user account: ".$id_user_account;
//Recuperation of the max of the id_file in the table files to attribute an id_file to the modified file
$query1="SELECT MAX(id_file) from files";
$query1_result=pg_query($connex,$query1) or die (pg_last_error() );
$maxid=pg_fetch_array($query1_result)[0];
$maxid=$maxid+1;
echo "<br/>id_file of the modified file :". $maxid;
//Recuperation of the last version of the file
$query2="SELECT MAX(id_version) from files where id_original_file=".$_SESSION["idfile"];
$query2_result=pg_query($connex,$query2) or die (pg_last_error() );
$maxversion=pg_fetch_array($query2_result)[0];
$maxversion=$maxversion+1;
echo "<br/>Dernière version du fichier (en comptant celle ci):".$maxversion;
//recuperation of the id_validation_state of the file
$query3="SELECT MAX(id_validation_state) from files where id_original_file=".$_SESSION["idfile"];
$query3_result=pg_query($connex,$query3) or die (pg_last_error() );
$maxvs=pg_fetch_array($query3_result)[0];
echo "<br/>Etat de validation du fichier:".$maxvs;
//It will be an insert and not an update finally. We recuperate some metadata of the modified data and we create an insertion with the new file, indicating the id of the original file"
//Insertion of the data for the modified file which has been upladed previously
$query="INSERT INTO files (id_file, id_user_account, id_format, id_validation_state, id_version, upload_date, file_name, file_place, file_size, id_original_file) VALUES (".$maxid .",".$id_user_account.",1,".$maxvs.",".$maxversion .",'".$_SESSION["upload_date"]."','".$_SESSION["upload_filename"]."','".$_SESSION["upload_location"]."',".$_SESSION["upload_file_size"].",".$_SESSION["idfile"].")"; 
$query_result = pg_query($connex,$query) or die (pg_last_error() );


?>

<form id ="formretour" action="US_3_21_Modifyfile_DragDrop.php" method="get">
	<input type="submit" value="Retour">
</form>
<br/><br/><br/><br/><br/>
</body>

 
	  <?php
				 include("pied_de_page.php");
		?>
		</html>


</html>
