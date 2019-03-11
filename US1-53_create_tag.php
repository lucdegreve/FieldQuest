
<html>
	<head>
        <META charset="UTF-8">
		<link rel="stylesheet" href="css/bootstrap.min.css">

        <script type="text/javascript">
            function validation(){
                var al="";
				if(document.form_creation.liste_type.value == "Select a new category for your new tag") {
                // enter a tag name
                    al= al+"Choose a tag type \n";
                }
                // if value of surname field is empty
                if(document.form_creation.tag_name.value == "") {
                // enter a tag name
                    al= al+"Enter a tag name";
                }
                if (al=="")
                    return true;
                else{
					alert(al);
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
			echo '<div class="container">
				<form name="coucou" action="US1-54_manage_tags.php">
				<button name="return" class="btn btn-outline-info" type="submit">Back</button>
				</form>';

            $con=new Connex();
            $connex=$con->connection;
            // parameters of request
            $query = "SELECT id_tag_type, name_tag_type  FROM tag_type
                GROUP BY id_tag_type ORDER BY name_tag_type";
            // request execution
            // and recuperation of recordset
            $result = pg_query($connex, $query)
                or die('Échec de la requête : ' . pg_last_error($connex));
				echo '<form name="form_creation" action="US1-53_create_tag.php" onsubmit="return validation()" method="get">';
					echo '<h4 class="card-title">Add a new tag</h4>
					<div class="input-group mb-3">
  				<div class="input-group-prepend">
					<span class="input-group-text"> Choose your tag type :</span></div>
					<select class="custom-select" name="liste_type" >';



						while($row = pg_fetch_array($result)){
							echo '<option value ='.$row["id_tag_type"].'> '.$row["name_tag_type"].' </option>';
						}
					echo '</select></div>

                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default"> Enter the tag name : </span>
                                            </div>
                                            </br>
                                            <input class="form-control" type="text" name="tag_name"><br/></br>
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" > Enter a description :</span>
                                            </div>
                                            <textarea class="form-control" aria-label="With textarea" aria-describedby="inputGroup-sizing-default" name="tag_description">Comment</textarea></br>
										</div>
                                        <div><button type="submit" class="btn btn-outline-success">Validate</button></div>
						</div>

				</form>';
				?>
		</div>
			<?php



            if (isset($_GET["tag_name"])){ //if we click on validate the previous form, we create the tag in the database
                $con=new Connex();
                $connex=$con->connection;
                $query = "SELECT *  FROM tags";
                // request execution
                // and recuperation of recordset
                $result = pg_query($connex, $query)  or die('Échec de la requête : ' . pg_last_error($connex));

                //Creation of table to insert a new unique id in "tags" table
                $tab_id_tag=array() ;
                $a=0;
                while ($row = pg_fetch_array($result)) {
					// The access to a table element can be done thanks to index or field name
                    // We can access here by the index
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

                //Recuperation of data to insert in the database
                $id_tag=$new_id;
                $id_tag_type=$_GET["liste_type"];
                $tag_name=$_GET["tag_name"];
                if (isset($_GET["tag_description"]))
                    {$tag_description = $_GET["tag_description"];
                }
                else $tag_description= " ";
                $sql = "INSERT INTO tags VALUES (".$id_tag.",".$id_tag_type." ,'".$tag_name."', '".$tag_description."')";
                $res = pg_query($connex, $sql)
                or die('Échec de la requête : ' . pg_last_error($connex));

                echo '<div class="container"><p> New tag '.$tag_name.' created</p></div>';

            }

            ?>
			</div>
		</div>
	</body>
	<?php
		include("pied_de_page.php");
	?>
</html>
