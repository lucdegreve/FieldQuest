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
                
                $id_user = $_SESSION["id_user_account"];
                
                //For the test
                //$id_user=3;
                
                //Query : select all favorite query from connected user
                $query =  "SELECT f.id_favorite_search, f.search_label, f.comment FROM favorite_search f
                            WHERE status_public_private = false AND id_user_account=".$id_user;
                            
                $result = pg_query($connex, $query) or die('Echec de la requête :'.pg_last_error($connex));

                                        
                while ($row = pg_fetch_array($result))
                {
                        echo '<ul>' ;
                                echo "<H6>".$row[1]."<a href=US4-11_Main_page_filter.php?id_favorite_search=".$row[0]." class='lien'><img src='picto/search.png' width='30' height='30'></a></H6>";
                                echo $row[2];
                                
                                // ajoute colonne supprimer
                                echo "<br/><a href = 'US4-14_Delete_favorite_query.php?id_favorite_search=".$row[0]."' class='lien'>Delete</a><hr>";
                        echo '</ul>';
                }
                                
        ?>


    </body>

</html>