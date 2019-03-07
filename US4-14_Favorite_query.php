<html>

    <head>
<!--------------------------------------------------------------------------------

   US4-14 Accéder à mes recherches enregistrées

Developped by Diane

Input variables : 		

Output variables :	id_favorite_search							
            
---------------------------------------------------------------------------------->	

<META charset="utf-8">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/custom.css">

    </head>

    <body>



        <?php
        //Header
        include("en_tete.php");
        echo "</br>";
        //DB connection
        require "./tab_donnees/funct_connex.php";
        require "./tab_donnees/tab_donnees.class.php";
        $con=new Connex();
        $connex=$con->connection;
        $id_user = $_SESSION["id_user_account"];
        $id_user=3;
        
        echo "<H3>Your favorite searches</H3>";
        
        //Query : select all favorite query from connected user
        $query =  "SELECT f.id_favorite_search, f.search_label, f.comment FROM favorite_search f
                    WHERE status_public_private = false AND id_user_account=".$id_user;
                    
        $result = pg_query($connex, $query) or die('Echec de la requête :'.pg_last_error($connex));
        ?>

		<div class="row">
			<div class="col-md-3"> <!-- List of favorite searches  -->
				<?php
                                
                                    while ($row = pg_fetch_array($result))
                                    {
                                            echo '<ul>' ;
                                                    echo "<H6>".$row[1]."<a href=US4-11_Main_page_filter.php?id_favorite_search=$row[0] class='lien'><img src='picto/search.png' width='30' height='30'></a></H6>";
                                                    echo $row[2];
                                                    
                                                    // ajoute éventuellement la colonne supprimer
                                                    //echo "<br/><a href = 'us_1_43_supprimer_un_projet.?id_project=".$row[0]."' class='lien'>Delete</a><hr>";
                                            echo '</ul>';
                                    }
                                
				?>
			</div>
		</div>

    </body>
        
    	<?php
	echo "</br></br></br>";
	include("pied_de_page.php");
	?>	
</html>