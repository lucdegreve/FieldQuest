
<html>
    <!-- Sites to do linked lists
    https://javascript.developpez.com/actu/97523/Apprendre-a-creer-des-listes-deroulantes-liees-entre-elles-sans-utiliser-Ajax-un-article-de-NoSmoking/?fbclid=IwAR2Lzp6TXxnHjc7Lx4lrTR6vGO9FoQCR98c4u7GEJOlZgGAgtjJwQIsPJ7s
    https://siddh.developpez.com/articles/ajax/
    -->
    <!--developpers: Camille Bonas et Julien Louet-->
    <!--Access to this page by clicking on the button "Modify tag " of the page "US1-54_manage_tags.php" -->
    <!-- -->
    <!-- -->
    <!--Avancement: ajout des listes déroulantes pour sélectionner le tag à modifier -->

	<head>
        <META charset="UTF-8">
        <script type="text/javascript">
            //this function will display an alert popup when sending the informations
            //for updating the tag type table
            //and verify the input informations
            function valider(){
                //initiation of the variable "al" with an empty value
                var al="";
                // if the field value is empty, fill the alert
                if(document.edition_tag.tag_name.value == "") {
                    al="Enter a tag name";
                }
                //if the alert is empty, run the form sending
                if (al=="")
                    return true;
                else // open a pop up with the alert and don't send the form
                    {alert(al);
                    return false;
                }
            }
        </script>

        <script type='text/javascript'>
            function getXhr(){
                var xhr = null;
                    if(window.XMLHttpRequest) // Firefox and others
                        xhr = new XMLHttpRequest();
                    else if(window.ActiveXObject){ // Internet Explorer
                        try {
                                xhr = new ActiveXObject("Msxml2.XMLHTTP");
                            } catch (e) {
                                    xhr = new ActiveXObject("Microsoft.XMLHTTP");
                            }
                    }
                    else { // if XMLHttpRequest non supported by the browser
                        alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");
                        xhr = false;
                    }
                    return xhr;
            }

            //function called by the selection change on the first list
            function go(){
                var xhr = getXhr();
                // We define what we are going to do when we get the response
                xhr.onreadystatechange = function(){
                    // We continue only if server is ok and if we receive all the information
                    if(xhr.readyState == 4 && xhr.status == 200){
                        leselect = xhr.responseText;
                        // We use the innerHTML to add options to the second list
                        document.getElementById('tag').innerHTML = leselect;
                    }
                }

                // Here we will see how to "do" post
                xhr.open("POST","ajaxTag.php",true);
                // don't forget this for the post
                xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
                // and don't forget to post the argument
                // here, the id of tag_type
                sel = document.getElementById('tag_type');
                idtypetag = sel.options[sel.selectedIndex].value;
                xhr.send("id_tag_type="+idtypetag);
            }
        </script>

	</head>
	<body>
        <?php
				 include("en_tete.php");

        ?>
        <div class="container">
        <?php
        require "./tab_donnees/funct_connex.php";
		echo'<form action="US1-54_manage_tags.php">
				<button name="return" class="btn btn-outline-info" type="submit">Back</button>
				</form>';
        echo '<form  method="get">';
        echo '
				<h4>Select the tag to modify</h4></br>


					<div class="input-group mb-3">
				   	<div class="input-group-prepend">
				       <span class="input-group-text"> Tag type :</span>
				    </div>';
									//display a list with all the tag type
									//when we select a tag type it calls the go() js function to update the second list
				echo ' <select class="custom-select" name="tag_type" id="tag_type" onchange="go()">
					<option value="-1"></option>';
                    require_once "./tab_donnees/funct_connex.php";
                    $con=new Connex();
                    $connex=$con->connection;
                    $res = pg_query($connex, "SELECT * FROM tag_type ORDER BY name_tag_type asc ")or die(pg_last_error($connex));
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
								</div>
                </div><div class="container">

				<div class="input-group mb-3">
					<div class="input-group-prepend">
						 <span class="input-group-text"> Tag </span>
					</div>

				<select class="custom-select" id="tag" name="tag" style="display:inline">';
        echo '<option value="-1"></option>';
				echo '</select>
        </div>';
                echo '<div style="display:inline"> <button name="modify" type="submit" class="btn btn-outline-warning">Modify</button></div>';
                ?>

        <div style="display:inline"> <button name="delete" type="submit" class="btn btn-outline-danger" onClick="return confirm('Do you really want to delete the tag?')">Delete</button></div>
        </div>
        <div class="container">
                        <?php echo '</fieldset>';
        echo '</form>';

        // if we click on the Validate button of the previous form
        //(to send the informations to modify the tag type table)
        if (isset($_GET["delete"])){
            $id_tag=$_GET["tag"];
            require_once "tab_donnees/funct_connex.php";
            $con=new Connex();
            $connex=$con->connection;
            // Request to update the table "tag_type" and all the link tables
            $query_link_fs = "DELETE FROM link_tags_fs  WHERE id_tag='".$id_tag."' " ;
            $query_link_project = "DELETE FROM link_tag_project  WHERE id_tag='".$id_tag."' " ;
            $query_link_tag_groups = "DELETE FROM link_tag_tag_groups  WHERE id_tag='".$id_tag."' " ;
            $query = "DELETE FROM tags  WHERE id_tag='".$id_tag."' " ;
            // Request execution
            $result_link_fs = pg_query($connex, $query_link_fs)
                or die('Échec de la requête : ' . pg_error($connex));
            $result_link_project = pg_query($connex, $query_link_project)
                or die('Échec de la requête : ' . pg_error($connex));
            $result_link_tag_groups = pg_query($connex, $query_link_tag_groups)
                or die('Échec de la requête : ' . pg_error($connex));
            $result = pg_query($connex, $query)
                or die('Échec de la requête : ' . pg_error($connex));
            // displays this message if the modification is a success
            echo '<p>The tag has been deleted</p>';
        }

        //if we click on previous "modify" it displays a new form
        //to modify the fields of the selected tag
        //which displays the value of the fields to modify it
        if (isset($_GET["modify"])){

            $id_tag=$_GET["tag"];
            $_SESSION["id_tag"]=$id_tag;
            $query3 = 'SELECT * FROM tags where id_tag='.$_GET["tag"];
            $result3 = pg_query($connex, $query3)or die(pg_last_error($connex));
            while($row3 = pg_fetch_assoc($result3)){
                echo '</br><form method="GET" name="edition_tag" action="US1-54_modify_tag.php">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Edit the tag name :</span> </br>
                    </div>
                    <input type="text" class="form-control" aria-label="With textarea" aria-describedby="inputGroup-sizing-default" name="tag_name" value="'.$row3["tag_name"].'" ><br/>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default"> Edit the tag description :</span>
                    </div>
                    <textarea class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="tag_description"  >'.$row3["tag_description"].'</textarea><br/>
                </div>
                <div><button type="submit" class="btn btn-outline-success">Submit</button></div>
                </form>';
            }


        }
        // if we click on the Validate button of the previous form
        //(to send the informations to modify the tag type table)
        if (isset($_GET["tag_name"])){
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
            require_once "tab_donnees/funct_connex.php";
            $con=new Connex();
            $connex=$con->connection;
            $res = pg_query($connex, "SELECT * FROM tag_type ")or die(pg_last_error($connex));

            // Request to update the table "tag_type"
            $query = "UPDATE tags SET tag_name='".$tag_name."' , tag_description='".$tag_description."' WHERE id_tag='".$id_tag."' " ;
            // Request execution
            $result = pg_query($connex, $query)
                or die('Échec de la requête : ' . pg_error($connex));
            // displays this message if the modification is a success
            echo ' <p>The tag  '.$tag_name.' has been modified</p>';
        }

		?>
        </div>
	</body>
    <?php
			 include("pied_de_page.php");
    ?>
</html>
</html>
