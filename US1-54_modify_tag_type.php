
<html>
    <!-- Sites to do linked lists
    https://javascript.developpez.com/actu/97523/Apprendre-a-creer-des-listes-deroulantes-liees-entre-elles-sans-utiliser-Ajax-un-article-de-NoSmoking/?fbclid=IwAR2Lzp6TXxnHjc7Lx4lrTR6vGO9FoQCR98c4u7GEJOlZgGAgtjJwQIsPJ7s
    https://siddh.developpez.com/articles/ajax/
    -->
    <!--developpers: Camille Bonas et Julien Louet-->
    <!--Access to this page by clicking on the button "Modify tag type" of the page "US1-54_manage_tags.php" -->
    <!-- -->
    <!-- -->
    <!--Avancement: ajout des listes déroulantes pour sélectionner le tag à modifier -->

	<head>
        <META charset="UTF-8">
        <script type="text/javascript">
            //this function will display an alert popup when sending the informations
            //for updating the tag type table
            //and verify the input informations
            function validation(){
                //initiation of the variable "al" with an empty value
                var al="";
                // if the field value is empty, fill the alert
                if(document.edition_tag_type.name_tag_type.value == "") {
                    al="Enter a tag type name";
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

	</head>
	<body>
		<?php
				 include("en_tete.php");

        ?>



        <?php

				require "./tab_donnees/funct_connex.php";


				// if we click on the Validate button of the previous form
				//(to send the informations to modify the tag type table)
				if (isset($_GET["delete"])){
            $id_tag_type=$_GET["tag_type"];
            $name_tag_type=$_GET["name_tag_type"];
            $con=new Connex();
            $connex=$con->connection;
            // Request to update the table "tag_type"
            $query = "DELETE FROM tag_type WHERE id_tag_type='".$id_tag_type."' " ;
            // Request execution
            $result = pg_query($connex, $query)
                or die('Échec de la requête : ' . pg_last_error($connex));
            // displays this message if the modification is a success
            echo '<div class="alert alert-danger">The tag has been deleted</div>';
        }

				// if we click on the Validate button of the previous form
				//(to send the informations to modify the tag type table)
				if (isset($_GET["name_tag_type"])){
						$id_tag_type= $_SESSION["id_tag_type"];
						$name_tag_type=$_GET["name_tag_type"];
						if (isset($_GET["description_tag_type"]))
								{$description_tag_type = $_GET["description_tag_type"];
						}
						else $description_tag_type= " ";
						$con=new Connex();
						$connex=$con->connection;
						$res = pg_query($connex, "SELECT * FROM tag_type ")or die(pg_last_error($connex));

						// Request to update the table "tag_type"
						$sql = "UPDATE tag_type SET name_tag_type='".$name_tag_type."' , description_tag_type='".$description_tag_type."' WHERE id_tag_type='".$id_tag_type."' " ;
						// Request execution
						$res = pg_query($connex, $sql) or die('Échec de la requête : ' . pg_last_error($connex));
						// displays this message if the modification is a success
						echo '<div class="alert alert-success">The tag type  '.$name_tag_type.' has been modified</div>';
				}


				echo '<div class="container">';

				echo'<form action="US1-54_manage_tags.php">
				<button name="return" class="btn btn-outline-info" type="submit">Back</button>
				</form>';
        ?>

        <?php
        echo '<form  method="get">

				<h4>Select the tag type to modify</h4></br>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"> Tag type :</span>
          </div>
        <select class="custom-select" name="tag_type" id="tag_type">
				<option value="-1">-</option>';
                    require_once "tab_donnees/funct_connex.php";
                    $con=new Connex();
                    $connex=$con->connection;
                    $res = pg_query($connex, "SELECT * FROM tag_type ORDER BY name_tag_type ASC ")or die(pg_last_error($connex));
                    //display a list with all the tag type
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
                <div style="display:inline"> <button type="submit" class="btn btn-outline-warning">Modify</button></div>'
				?>
				<button name="delete" class="btn btn-outline-danger" type="submit" onClick="return confirm('Do you really want to delete the tag?')"/>Delete </button>
        <?php
            echo '</fieldset>
        </form></div>';






        //if we click on the previous "modify" button of the form
        //it displays the form to edit the selected tag type
        //which displays the value of the fields to modify it
        if (isset($_GET["tag_type"])){
            $con=new Connex();
            $connex=$con->connection;
            $id_tag_type=$_GET["tag_type"];
            $_SESSION["id_tag_type"]=$id_tag_type; //to use it after, in the update table request
            $query3 = 'SELECT * FROM tag_type where id_tag_type='.$_GET["tag_type"];
            $result3 = pg_query($connex, $query3)or die(pg_last_error($connex));
            while($row3 = pg_fetch_assoc($result3)){
                echo '<div class="container"><form method="GET" name="edition_tag_type" action="US1-54_modify_tag_type.php" onsubmit="return validation()">
                </br>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Edit the tag type :</span>
                    </div>
                    <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="name_tag_type" value="'.$row3["name_tag_type"].'" ><br/>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Edit the tag description :</span>
                    </div>
                    <textarea class="form-control" aria-label="With textarea" aria-describedby="inputGroup-sizing-default" name="description_tag_type" value="'.$row3["description_tag_type"].'"></textarea>
                </div>

                <div><button type="submit" class="btn btn-outline-success">Validate</button></div>
                </form></div>';
            }

        }


		?>
        </div>
	</body>
	<?php
		include("pied_de_page.php");
    ?>
</html>
