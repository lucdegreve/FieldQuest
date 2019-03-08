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

    <script type="text/javascript">
            //Ouvrir la page "US3_4_Supprimer_fichiers_deposes"
                    function delete_search(id_favorite_search) { 
                            document.location.href="US4-14_Delete_favorite_query.php?id_favorite_search="+id_favorite_search+"&delete=";
                    }
            //Ouvrir la page "US4-14_Favorite_query.php"
                    function back_to_favorite_search() { 
                            document.location.href="US4-11_Main_page_filter.php";
                    }
    </script>
    
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
        
        //For test
        //$id_user=3;

	// Get the id of the query we want to delete
	$id_favorite_search = $_GET['id_favorite_search'];
        
        $query_verif_user = "SELECT f.id_user_account FROM favorite_search f WHERE f.id_favorite_search=".$id_favorite_search;
        $result_verif_user = pg_query($connex,$query_verif_user)
                or die ("<div class = 'alert alert-danger'>This search doesn't exist</div>");
        $id_user_query=pg_fetch_array($result_verif_user)[0];
        
        //the delete can be done only if the connected user is the one who made the query
        if ($id_user_query==$id_user){
            
		if (isset($_GET['delete'])){
		
                        $id_favorite_search= $_GET['id_favorite_search'];
                        
                        //queries to delete favorite search criteria (format, project, tags, tag groups)
                        $query_format_fs = "DELETE FROM link_format_fs l WHERE l.id_favorite_search='".$id_favorite_search."'";
                        $query_projects_fs = "DELETE FROM link_projects_fs l WHERE l.id_favorite_search='".$id_favorite_search."'";
                        $query_tags_fs = "DELETE FROM link_tags_fs l WHERE l.id_favorite_search='".$id_favorite_search."'";
                        $query_tg_fs = "DELETE FROM link_tg_fs l WHERE l.id_favorite_search='".$id_favorite_search."'";
                        
                        //result of those queries
                        $result_format_fs = pg_query($connex,$query_format_fs)
                            or die ("<div class = 'alert alert-danger'>Failed to delete the formats</div>");
                        $result_projects_fs = pg_query($connex,$query_projects_fs)
                            or die ("<div class = 'alert alert-danger'>Failed to delete the projects</div>");
                        $result_tags_fs = pg_query($connex,$query_tags_fs)
                            or die ("<div class = 'alert alert-danger'>Failed to delete the tags</div>");
                        $result_tg_fs = pg_query($connex,$query_tg_fs)
                            or die ("<div class = 'alert alert-danger'>Failed to delete the tag groups</div>");
                        
                        //query to delete the favorite search
                        $query_favorite_search = "DELETE FROM favorite_search f WHERE f.id_favorite_search='".$id_favorite_search."'";
                        $result_favorite_search = pg_query($connex,$query_favorite_search)
                            or die ("<div class = 'alert alert-danger'>Failed to delete this search</div>");
                        
                        //confirmation of delete + back button
                        echo "<button type='button' id='btnBack' name='back' class='btn btn-sm btn-success' onclick='return back_to_favorite_search()'>Return</button>";
                        echo '<br/><div class="alert alert-success">This search successfully deleted. </div><br/>';
                }
                else {
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
					    <h5 class="card-title">Do you really want to delete this search ?</h5>
					    <p class="card-text"> 
					    	<div class="row">
					    		<div class="col-3">
                                                        </div>
						    	<div class="col-2">
                                                            <button type='button' id='btnDelete' name='delete' class='btn btn-sm btn-success btn-block' onclick='return delete_search("<?php echo $id_favorite_search; ?>")'>Yes</button>
					         	</div>
					         	<div class="col-3">
					         	<!-- we create a button to go back to the page ""filters" -->
                                                            <button type='button' id='btnBack' name='back' class='btn btn-sm btn-danger btn-block' onclick='return back_to_favorite_search()'>No / Return</button>
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
                }
        }
	else {
            //the connected user isn't the one who made the favorite search
            //delete impossible + back button
            echo "<button type='button' id='btnBack' name='back' class='btn btn-sm btn-success' onclick='return back_to_favorite_search()'>Return</button>";
            echo "You are not allowed to delete this favorite search.";

        }

	// Include footer
	include("pied_de_page.php");
?>
</body>

</html>
