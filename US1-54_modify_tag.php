
<html>
    <!-- Sites LISTES DEROULANTES LIEES
    https://javascript.developpez.com/actu/97523/Apprendre-a-creer-des-listes-deroulantes-liees-entre-elles-sans-utiliser-Ajax-un-article-de-NoSmoking/?fbclid=IwAR2Lzp6TXxnHjc7Lx4lrTR6vGO9FoQCR98c4u7GEJOlZgGAgtjJwQIsPJ7s
    https://siddh.developpez.com/articles/ajax/ 
    -->
    <!--developpers: Camille Bonas et Julien Louet-->
    <!--On accède à cette page en cliquant sur le bouton "modify tag" de la page "gerer tags" -->
    <!-- -->
    <!-- -->
    <!--Avancement: ajout des listes déroulantes pour sélectionner le tag à modifier -->
    
	<head>
        <META charset="UTF-8">
        <script type="text/javascript">
            function valider(){
            
            var al="";
            // si la valeur du champ prenom est non vide
            if(document.formSaisie.code_client.value == "") {
            // sinon on affiche un message
                al="Info manquante: [Code client] <br/>";
                }
            if(document.formSaisie.nom_client.value == "") {
                // sinon on affiche un message
                al=al+"Info manquante: [Nom] <br/>";
                }
            if(document.formSaisie.prenom_client.value == "") {
                // sinon on affiche un message
                al=al+"Info manquante: [Prenom]<br/>";
                }
            if(document.formSaisie.tel_client.value == "") {
                // sinon on affiche un message
                al=al+"Info manquante: [Téléphone]<br/>";
                }
            if (al=="")
                return true;
            else
                {alert(al);
                return false;
                }
            }

        </script>
        <script type='text/javascript'>
        
 
            function getXhr(){
                var xhr = null; 
                    if(window.XMLHttpRequest) // Firefox et autres
                        xhr = new XMLHttpRequest(); 
                    else if(window.ActiveXObject){ // Internet Explorer 
                        try {
                                xhr = new ActiveXObject("Msxml2.XMLHTTP");
                            } catch (e) {
                                    xhr = new ActiveXObject("Microsoft.XMLHTTP");
                            }
                    }
                    else { // XMLHttpRequest non supporté par le navigateur 
                        alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
                        xhr = false; 
                    } 
                    return xhr;
            }

            /**
            * Méthode qui sera appelée sur le click du bouton
            */
            function go(){
                var xhr = getXhr();
                // On défini ce qu'on va faire quand on aura la réponse
                xhr.onreadystatechange = function(){
                    // On ne fait quelque chose que si on a tout reçu et que le serveur est ok
                    if(xhr.readyState == 4 && xhr.status == 200){
                        leselect = xhr.responseText;
                        // On se sert de innerHTML pour rajouter les options a la liste
                        document.getElementById('tag').innerHTML = leselect;
                    }
                }

                // Ici on va voir comment faire du post
                xhr.open("POST","ajaxTag.php",true);
                // ne pas oublier ça pour le post
                xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
                // ne pas oublier de poster les arguments
                // ici, l'id de tag type
                sel = document.getElementById('tag_type');
                idtypetag = sel.options[sel.selectedIndex].value;
                xhr.send("id_tag_type="+idtypetag);
            }
        </script>
	</head>
	<body>
        <?php 
        require "funct_connex.php";
        echo '<form  method="get">';
        echo '<fieldset style="width: 500px">
				<legend>Select the tag to modify</legend>
				<label>Tag type</label>
				<select name="tag_type" id="tag_type" onchange="go()">
					<option value="-1">Aucun</option>';
                    require_once "funct_connex.php";
                    $con=new Connex();
                    $connex=$con->connection;
                    $res = pg_query($connex, "SELECT * FROM tag_type ")or die(pg_last_error($connex));
                    while($row = pg_fetch_assoc($res)){
                        echo '<option';
                        if(isset($_GET['tag_type'])){
                            if($_GET['tag_type']==$row["id_tag_type"]){
                                echo " selected ";
                            }
                        }
                        echo' value='.$row["id_tag_type"].'>'.$row["name_tag_type"].'</option>';
                    }
                echo '</select>
				<label>Tag</label>
				<div id="tag" style="display:inline">
				<select name="tag">';
                    echo '<option value="-1">Choisir un tag</option>';
				echo '</select>
                </div>';
                echo '<div style="display:inline"> <input type="submit" value="Modify"  /></div>';
			echo '</fieldset>';
        echo '</form>';
        

        if (isset($_GET["tag"])){
            session_start(); 
            $id_tag=$_GET["tag"];
            $_SESSION["id_tag"]=$id_tag; //on met l'id_tag en variable de session
            $query3 = 'SELECT * FROM tags where id_tag='.$_GET["tag"];
            $result3 = pg_query($connex, $query3)or die(pg_last_error($connex));
            while($row3 = pg_fetch_assoc($result3)){
                echo '<form method="GET" name="edition_tag" action="modif_tag_db.php">
                Edit the tag name  :
                <input type="text" name="tag_name" value="'.$row3["tag_name"].'" ><br/>
                Edit the new description:
                <input type="text" name="tag_description" value="'.$row3["tag_description"].'" ><br/>
                <div><input type="submit" value="Submit" /></div>
                </form>';
            }
            
        }
        
		?>
	</body>
</html>