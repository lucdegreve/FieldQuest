
<html>
	<head>
        <META charset="UTF-8">
        <script type="text/javascript">
            function validation(){
                var al="";
                // if value of surname field is empty
                if(document.form_creation.name_tag_type.value == "") {
                // enter a tag name
                    al="Enter a tag type name";
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
				 include("en_tete.php");
				 
        ?>

        <?php
            // To add a new client
            require "./tab_donnees/funct_connex.php";
			echo'<form action="US1-54_manage_tags.php">
				<button name="return" class="btn btn-outline-info" type="submit">Back</button>
				<div class="container">
				</form><h4>Add a new tag type</h4>';


            $con=new Connex();
            $connex=$con->connection;
            // parameters of request
            $query = "SELECT id_tag_type, name_tag_type  FROM tag_type
                GROUP BY id_tag_type ORDER BY name_tag_type ";
            // request execution
            // and recuperation of recordset
            $result = pg_query($connex, $query)
                or die('Échec de la requête : ' . pg_last_error($connex));
				echo '<form name="form_creation" action="US1-51_create_tag_type.php" onsubmit="return validation()" method="get">';

					echo '</select></br>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default"> Enter the tag type : </span>
                                            </div>
                                            </br>
                                            <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="name_tag_type"><br/></br>
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" > Enter a description :</span>
                                            </div>
                                            <textarea class="form-control" aria-label="With textarea" aria-describedby="inputGroup-sizing-default" name="description_tag_type"></textarea></br>
					</div>
                                        <div><button type="submit" class="btn btn-outline-success">Validate</button></div>
				</form>';
				?>
		</div>
				<?php


            if (isset($_GET["name_tag_type"])){ //if we click on validate the previous form, we create the tag in the database
                require_once "tab_donnees/funct_connex.php";
                $con=new Connex();
                $connex=$con->connection;
                $query = "SELECT *  FROM tag_type";
                // request execution
				// and recuperation of recordset
                $result = pg_query($connex, $query)  or die('Échec de la requête : ' . pg_last_error($connex));

                //Creation of table to insert a new unique id in "tags" table
                $tab_id_tag_type=array() ;
                $a=0;
                while ($row = pg_fetch_array($result)) {
                    // The access to a table element can be done thanks to index or field name
                    // We can access here by the index
                    for ($i=1 ; $i <= pg_num_fields($result)-1; $i++)
                        {$tab_id_tag_type[$a]=$row[0];
                        $a=$a+1;
                    }
                }
                $min_id_type= min($tab_id_tag_type);
                $new_id_type=$min_id_type;
                while (in_array($new_id_type, $tab_id_tag_type)){
                    $new_id_type=$new_id_type+1;
                }

                //Recuperation of data to insert in the database
                $id_tag_type=$new_id_type;
                $name_tag_type=$_GET["name_tag_type"];
                if (isset($_GET["description_tag_type"]))
                    {$description_tag_type = $_GET["description_tag_type"];
                }
                else $description_tag_type= " ";
                $sql = "INSERT INTO tag_type VALUES (".$id_tag_type." ,'".$name_tag_type."', '".$description_tag_type."')";
                $res = pg_query($connex, $sql)
                or die('Échec de la requête : ' . pg_last_error($connex));

                echo '<div class="container"> <p style="strong">New type tag '.$name_tag_type.' created	</p> </div>';

            }

            ?>
	</body>
	<?php
		include("pied_de_page.php");
    ?>
</html>
