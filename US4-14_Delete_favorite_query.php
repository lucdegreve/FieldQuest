<html>
<head>
<!--------------------------------------------------------------------------------

   US4-14 Supprimer une recherche enregistrée

Developped by Diane

Input variables : 	id_favorite_search	

Output variables :								
            
---------------------------------------------------------------------------------->	
<META charset="utf-8">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/custom.css">
</head>
<body>
<?php
	// Include header
	include("en_tete.php");
	// Include files containing connexion to database
	require "tab_donnees/funct_connex.php";

	// Connexion to the database
	$con = new Connex();
	$connex = $con->connection;
        
        // Session
        $id_user = $_SESSION["id_user_account"];
        $id_user=3;

	// Get the id of the query we want to delete
	$id_favorite_search = $_GET['id_favorite_search'];
        
        $query_verif_user = "SELECT f.id_user_account FROM favorite_search f WHERE f.id_favorite_search=".$id_favorite_search;
        $result_verif_user = pg_query($connex,$query_verif_user)
                or die ("<div class = 'alert alert-danger'>This search doesn't exist</div>");
        $id_user_query=pg_fetch_array($result_verif_user)[0];
        
        //if the connected user is the one who made the query, the delete can be done
        if ($id_user_query==$id_user){
		?>
                <!-- Message to check if the user really want to delete a search -->
                <div class="container-fluid">
		
			<br/><br/><br/>
			<div class="row">
				<div class="col-3">
				</div>
				<div class="col-6">
					<div class="card text-center">
					  <div class="card-body">
					    <h5 class="card-title">Do you really want to delete this search <?php echo $id_project; ?> ?</h5>
					    <p class="card-text"> 
					    	<div class="row">
					    		<div class="col-4">
								</div>
						    	<div class="col-2">
						    		<!-- we create a hidden input to keep the value of the id_project once the form is set-->
								    <form name="suppr" action="US4-14_Delete_favorite_query.php" method="GET">
								    	<input type="hidden" name="id_favorite_search" value="<?php echo $id_favorite_search; ?>">
					              		<input type="submit" name="delete" value="Yes">
					         		</form>
					         	</div>
					         	<div class="col-2">
					         	<!-- we create a button to go back to the page "manage the projects" -->
					         		<form name="return" action="US4-11_Main_page_filter.php" method="POST">
					              		<input type="submit" name="return" value="No / Return">
					         		</form>
			         			</div>
			         			<div class="col-4">
								</div>
			         		</div>
					    </p>
					  </div>
					</div>
				</div>
				<div class="col-3">
				</div>
			</div>
		</div>
                
                <?php
                if (isset($_GET['delete'])){
		
		$id_favorite_search= $_GET['id_favorite_search'];
                $query_delete_account = "DELETE FROM favorite_search f WHERE f.id_favorite_search='".$id_favorite_search."'";
                $result_delete_account = pg_query($connex,$query_delete_account)
                    or die ("<div class = 'alert alert-danger'>Failed to delete this search</div>");
                
                echo '<br/><div class="alert alert-success">This search successfully deleted. </div>';
                }
        }
	

	// Include footer
	include("pied_de_page.php");
?>
</body>

</html>
