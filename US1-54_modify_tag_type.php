
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

    <script language="Javascript">
    <!--
    function OnButton1()
    {
        document.filters.action = "US1-54_modify_tag_type.php"
        //document.filters.target = "_blank";    // Open in a new window
        document.filters.submit();             // Submit the page
        return true;
    }

    function OnButton2()
    {
        document.filters.action = "US1-54_modify_tag_type.php"
        //document.filters.target = "_blank";    // Open in a new window
        document.filters.submit();             // Submit the page
        return true;
    }
    -->
    </script>

		<?php
				 include("en_tete.php");
				 echo "</br>";
        ?>
        <div class="container">
        <?php
        require "./tab_donnees/funct_connex.php";
		echo'<form action="US1-54_manage_tags.php">
				<button name="return" class="btn btn-outline-info" type="submit">Back</button>
				</form>';
        ?>

        <?php
  echo '<form  method="get">
            <fieldset style="width: 500px">
				<h4>Select the tag type to modify</h4>
				<label>Tag type</label>
				<select name="id_tag_type" id="tag_type">
					<option value="-1">-</option>';
                    require_once "tab_donnees/funct_connex.php";
                    $con=new Connex();
                    $connex=$con->connection;
                    $res = pg_query($connex, "SELECT * FROM tag_type ORDER BY name_tag_type ASC ")or die(pg_last_error($connex));
                    //display a list with all the tag type
                    while($row = pg_fetch_assoc($res)){
                        echo '<option';
                        if(isset($_GET['id_tag_type'])){
                            if($_GET['id_tag_type']==$row["id_tag_type"]){
                                echo " selected ";
                            }
                        }
                        echo' value='.$row["id_tag_type"].'>'.$row["name_tag_type"].'</option>';
                    }
                echo '</select>';
                echo'<div style="display:inline"><button type="submit" class="btn btn-outline-warning" value="modify" onclick="return OnButton1();">Modify</button></div>';
                echo'<div style="display:inline"><button type="submit" class="btn btn-outline-warning" name="delete" value="delete" onclick="return OnButton2();">Delete</button></div>';
            echo '</fieldset>
        </form>';

        if (isset($_GET["delete"])){
            $con=new Connex();
            $connex=$con->connection;
            echo'<META HTTP-EQUIV="Refresh" CONTENT="5; URL=US1-54_modify_tag_type.php';

            $id_tag_type=$_GET["id_tag_type"];
            $result = pg_query($connex, "SELECT id_tag FROM tags WHERE id_tag_type=".$id_tag_type." ")or die(pg_last_error($connex));

            while($row9 = pg_fetch_assoc($result)){
              // Request to update the table "tag_type"
              $query_link_fs = "DELETE FROM link_tags_fs  WHERE id_tag='".$row9["id_tag"]."' " ;
              $query_link_project = "DELETE FROM link_tag_project  WHERE id_tag='".$row9["id_tag"]."' " ;
              $query_link_tag_groups = "DELETE FROM link_tag_tag_groups  WHERE id_tag='".$row9["id_tag"]."' " ;

              // Request execution
              $result_link_fs = pg_query($connex, $query_link_fs)
                  or die('Échec de la requête : ' . pg_last_error($connex));
              $result_link_project = pg_query($connex, $query_link_project)
                  or die('Échec de la requête : ' . pg_last_error($connex));
              $result_link_tag_groups = pg_query($connex, $query_link_tag_groups)
                  or die('Échec de la requête : ' . pg_last_error($connex));
            }

            // Request to update the table "tag_type"
            $query_tag = "DELETE FROM tags WHERE id_tag_type='".$id_tag_type."' " ;
            $query = "DELETE FROM tag_type WHERE id_tag_type='".$id_tag_type."' " ;

            // Request execution
            $result_tag = pg_query($connex, $query_tag)
                or die('Échec de la requête : ' . pg_last_error($connex));
            $result = pg_query($connex, $query)
                or die('Échec de la requête : ' . pg_last_error($connex));

            // displays this message if the modification is a success
            echo 'The tag type has been deleted';
        }
        echo '</form>';

        //if we click on the previous "modify" button of the form
        //it displays the form to edit the selected tag type
        //which displays the value of the fields to modify it
        if (isset($_GET["id_tag_type"])){
            $con=new Connex();
            $connex=$con->connection;
            $id_tag_type=$_GET["id_tag_type"];
            $_SESSION["id_tag_type"]=$id_tag_type; //to use it after, in the update table request
            $query3 = 'SELECT * FROM tag_type where id_tag_type='.$_GET["id_tag_type"];
            $result3 = pg_query($connex, $query3)or die(pg_last_error($connex));
            while($row3 = pg_fetch_assoc($result3)){
                echo '<form method="GET" name="edition_tag_type" action="US1-54_modify_tag_type.php" onsubmit="return validation()">

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Edit the tag type </span>
                    </div>
                    <input type="text" class="col-md-6 col-md-offset-6" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="name_tag_type" value="'.$row3["name_tag_type"].'" ><br/>
                </div>
                </br>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Edit the description</span>
                    </div>
                    <input type="text" class="col-md-6 col-md-offset-6" class="form-control" aria-label="With textarea" aria-describedby="inputGroup-sizing-default" name="description_tag_type" value="'.$row3["description_tag_type"].'">
                </div>

                <div><button type="submit" class="btn btn-outline-success">Validate</button></div>
                </form>';
            }

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
            echo 'The tag type  '.$name_tag_type.' has been modified';
        }

		?>
        </div>
	</body>
	<?php
		include("pied_de_page.php");
    ?>
</html>
