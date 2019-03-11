
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
				 echo "</br>";
        ?>
        <div class="container"> 
        <?php  
            // To add a new client  
            require "./tab_donnees/funct_connex.php";
			echo'<form action="US1-54_manage_tags.php">
				<button name="return" class="btn btn-outline-info" type="submit">Back</button>
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
                echo '<fieldset style="width: 500px">';                  
					echo '</select></br>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-default"> Enter the tag type : </span>
                                            </div>
                                            </br>
                                            <input type="text" name="tag_name"><br/></br>
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" name="description" > Enter a description :</span>
                                            </div>
                                            <textarea class="form-control" aria-label="With textarea" aria-describedby="inputGroup-sizing-default" name="tag_description"></textarea></br>
					</div>
                                        <div><button type="submit" class="btn btn-outline-success" name="Validate_tag_type">Validate</button></div>
				</form>';
				?>
		</div>
				<?php
            if(isset($_GET["Validate_tag_type"])){ //if we click on validate the previous form, we create the tag in the database
				$tag_type_name = $_GET["tag_name"];
				$tag_type_description = $_GET["description"];
                $con=new Connex();
                $connex=$con->connection;
                $query = "INSERT INTO tag_type(name_tag_type, description_tag_type) VALUES ('".$tag_type_name."', '".$tag_type_description."')";
                $result = pg_query($connex, $query)  or die('Échec de la requête : ' . pg_last_error($connex));

        
                echo 'New type tag " <b> '.$tag_type_name.' </b> " created';
				
            }
                
            ?>
	</body>
	<?php
		include("pied_de_page.php");
    ?>
</html>