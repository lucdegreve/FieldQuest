
<!doctype html>
<!--Page to modify a file. You can download a file, make your own modifications on it, and then you can drag and drop the new file-->
<html lang="en">


<head>

<?php
				session_start();
				include("en_tete.php");
		?>
<!-- Développeurs : JB et Fagniné
			Drag and drop which download file automatically when drop. 
			
			if 2 files are dropped with the same name, the first doc is replaced by the 2nd !!
		-->
		
		

        <link href="css/custom.css" rel="stylesheet" type="text/css">
		<link href="css/boostrap.min.css" rel="stylesheet" type="text/css">
        <script src="US_2_21_dragdrop_jquery-3.0.0.js" type="text/javascript"></script>
        <script src="US_2_21_dragdrop_script.js" type="text/javascript"></script>
	<!-- Java script to create the drag and drop and to send the file to the server in a repertory -->
 <title >Upload the modified file</title>
 
 <?php
// Recuperation of the modified file id. we use a session variable because this variable is used in the next page (insert query)

//$_SESSION["idfile"]=$_GET["id_file"] ;
$_SESSION["idfile"]=4;

?>
 


</head>


<body>
<form id ="formdepot" action="filemodification_confirmation.php" method="get">
	<h1  align="center">Upload the modified file </h1> </br>
	<div class="container" >
		<input type="file" name="file" id="file">
		<!-- Drag and Drop container-->
		<div class="upload-area"  id="uploadfile">
			<h1>Drag and Drop file here<br/>Or<br/>Click to select file</h1>
		</div>
		</div> 
		<input type="submit" value="Send file">
	</form>
 <br/>
 <br/>
 
</body>
 
	  <?php
				 include("pied_de_page.php");
		?>
		</html>
