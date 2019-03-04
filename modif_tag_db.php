<html>
    <head>
        <META charset="UTF-8">
        <!-- Affichage sur la barre de titre du navigateur -->
        <title>Ajout réussi!!!</title>
    </head>
    <body>
        <?php // Ouverture de la balise php
            /* récupération des infos
            transmises par le formulaire */
            session_start();
            $id_tag=$_SESSION["id_tag"];
            $tag_name=$_GET["tag_name"];
            $tag_description=$_GET["tag_description"];
            if (isset($_GET["tag_name"]))
                {$tag_name = $_GET["tag_name"];
            }
            else $adresse_client= " ";
            if (isset($_GET["tag_description"]))
                {$tag_description = $_GET["tag_description"];
            } 
            require_once "funct_connex.php";
            $con=new Connex();
            $connex=$con->connection;
            $res = pg_query($connex, "SELECT * FROM tag_type ")or die(pg_last_error($connex));
            
            // Paramétrage de la requête 
            $query = "UPDATE tags SET tag_name='".$tag_name."' , tag_description='".$tag_description."' WHERE id_tag='".$id_tag."' " ;       
            // Exécution de la requête  
            // et récupération d'un jeu de résultats (resultset) 
            $result = pg_query($connex, $query)  
                or die('Échec de la requête : ' . pg_error($connex)); 
            
            echo 'La modification a bien été prise en compte'
        ?> <!-- Fermeture de la balise PHP -->
        
    </body>
</html>