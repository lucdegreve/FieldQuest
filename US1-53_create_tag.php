
<html>
	<head>
        <META charset="UTF-8">
        <script type="text/javascript">
            function validation(){
                var al="";
                // si la valeur du champ prenom est non vide
                if(document.form_creation.tag_name.value == "") {
                // sinon on affiche un message
                    al="Enter a tag name";
                }
                if (al=="")
                    return true;
                else
                    {alert(al);
                    return false;
                }
            }

        </script>
	</head>
	<body>
        <?php 
            session_start(); 
            // POUR AJOUTER un nouveau client  
            require "funct_connex.php";
            $con=new Connex();
            $connex=$con->connection;    
            // Paramétrage de la requête 
            $query = "SELECT id_tag_type, name_tag_type  FROM tag_type
                GROUP BY id_tag_type "; 
            // Exécution de la requête  
            // et récupération d'un jeu de résultats (resultset) 
            $result = pg_query($connex, $query)  
                or die('Échec de la requête : ' . pg_error($connex)); 
            echo '<b>Add a new tag</b> <br/> <br/>';
            echo '<form name="form_creation" action="US1-53_create_tag.php" onsubmit="return validation()" method="get">';
                echo 'Choose your tag type :<br/>
                <select name="liste_type" >
                    <option selected="selected">Select a new category for your new tag</option>';
                    while($row = pg_fetch_array($result)){
                        echo '<option value ='.$row["id_tag_type"].'> '.$row["name_tag_type"].' </option>';
                    }
                echo '</select></br>
                Enter the tag title :
                <input type="text" name="tag_name"><br/>
                
                Enter a description :
                <input type="textarea" name="tag_description" rows=4 cols=40><br/>
                <div><input type="submit" value="Validate" /></div>
            </form>';

            
            if (isset($_GET["tag_name"])){ //if we click on validate the previous form, we create the tag in the database
                require_once "funct_connex.php";
                $con=new Connex();
                $connex=$con->connection;
                $query = "SELECT *  FROM tags"; 
                // Exécution de la requête  
                // et récupération d'un jeu de résultats (resultset) 
                $result = pg_query($connex, $query)  or die('Échec de la requête : ' . pg_error($connex));

                //Choix d'un id différent des autres déjà présent dans la table "tags"
                $tab_id_tag=array() ;	
                $a=0;
                while ($row = pg_fetch_array($result)) { 
                    // L'accès à un élément du tableau peut se faire grâce à l'indice ou grâce au nom du champ 
                    // Ici, nous y accédons par l'indice 
                    for ($i=1 ; $i <= pg_num_fields($result)-1; $i++)	 	
                        {$tab_id_tag[$a]=$row[0];
                        $a=$a+1;
                    } 
                }
                $min_id= min($tab_id_tag);
                $new_id=$min_id;
                while (in_array($new_id, $tab_id_tag)){
                    $new_id=$new_id+1;
                }

                //Récupération des données à insérer dans la base de données
                $id_tag=$new_id;
                $id_tag_type=$_GET["liste_type"]; 
                $tag_name=$_GET["tag_name"];
                if (isset($_GET["tag_description"]))
                    {$tag_description = $_GET["tag_description"];
                }
                else $tag_description= " ";
                $sql = "INSERT INTO tags VALUES (".$id_tag.",".$id_tag_type." ,'".$tag_name."', '".$tag_description."')";
                $res = pg_query($connex, $sql)  
                or die('Échec de la requête : ' . pg_error($connex));
            
                echo 'New tag '.$tag_name.' created';

            }
                
            ?>
	</body>
</html>