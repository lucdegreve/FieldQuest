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
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    </head>

    <body>



        <?php
                
                $id_user_account = $_SESSION["id_user_account"];
                
                //For the test
                //$id_user_account=3;
                
                //Query : select all favorite query from connected user
                $query =  "SELECT f.id_favorite_search, f.search_label, f.comment FROM favorite_search f
                            WHERE status_public_private = false AND id_user_account=".$id_user_account;
                            
                $result = pg_query($connex, $query) or die('Echec de la requête :'.pg_last_error($connex));

                echo '<hr>';                        
                while ($row = pg_fetch_array($result))
                {
                        echo '<ul>' ;
                                echo "<H6>  <a class='btn btn-outline-primary btn-sm btn-block'  href=US4-11_Main_page_filter.php?id_favorite_search=".$row[0]." class='lien'>";
                                echo " <i class='fas fa-search' style='float:left; position:relative; '></i> ".$row[1]." </a></H6>";
                                echo $row[2];
                                
                                // ajoute colonne supprimer
                                echo "<br/><a class='btn btn-outline-danger btn-sm btn-block'  href = 'US4-14_Delete_favorite_query.php?id_favorite_search=".$row[0]."' class='lien'> <i class='fas fa-trash-alt'  style='float:left;'></i> Delete</a><hr>";
                        echo '</ul>';
                }
                                
        ?>


    </body>

</html>