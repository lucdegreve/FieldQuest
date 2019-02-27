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


//echo "id_file :".$_SESSION['id_file']."<br/>";
echo "File name: ".$_SESSION["upload_filename"]."<br/>";
echo "File location: ".$_SESSION["upload_location"]."<br/>";
echo "File modification date: ".$_SESSION["upload_date"]."<br/>";
echo "File new size (octet): ".$_SESSION["upload_file_size"];
$query="UPDATE files SET id_version=id_version+1, upload_date='".$_SESSION['upload_date']."', file_name='".$_SESSION['upload_filename']."', file_place='".$_SESSION['upload_location']."', file_size=".$_SESSION['upload_file_size']." where id_file=3";
//It will be an insert and not an update finally. We recuperate some metadata of the modified data and we create an insertion with the new file, indicating the id of the original file"
//$query ="INSERT INTO files(id_file,id_user_account,use_id_user_account,id_format, id_validation_state,id_version,upload_date, file_name,file_place) VALUES (10, 3, 7,2,3,1,'2018-12-31', '".$_SESSION['upload_filename']."', '".$_SESSION['upload_location']."')";
//$query ="INSERT INTO files VALUES (...)";
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
