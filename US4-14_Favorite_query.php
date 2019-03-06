<html>

    <head>
<!--------------------------------------------------------------------------------

   US4-14 Accéder à mes recherches enregistrées

Developped by Diane

Input variables : 		

Output variables :								
            
---------------------------------------------------------------------------------->	

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
        
        //Query : select all favorite query from connected user
        $query =  "SELECT f.id_favorite_search, f.search_label, f.comment FROM favorite_search f
                    WHERE status_public_private = false AND id_user_account=".$id_user;
                    
        $result = pg_query($connex, $query) or die('Echec de la requête :'.pg_last_error($connex));
        $table_saved_search = new Tab_donnees($result,"PG");
        ?>

		<div class="row">
			<div class="col-md-12"> <!-- Table with user accounts  -->
				<?php
				//Headers names
				$tab_headers[0]='id';
				$tab_headers[1]='Search label';
				$tab_headers[2]='Comment';
				//Columns
                                $tab_display[0]='id_favorite_search';
				$tab_display[1]='search_label';
				$tab_display[2]='comment';
				$table_saved_search->creer_tableau("display nowrap", "accounts", "", "", "id_user_account", "", "",
									"US_1.21_account_monitoring.php", "US1-12_Supprimer_compte.php",
									$tab_headers, $tab_display, "", "");
				?>
			</div>
		</div>

    </body>
        
    	<?php
	echo "</br></br></br>";
	include("pied_de_page.php");
	?>	
</html>