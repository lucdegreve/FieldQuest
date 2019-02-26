
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
        require "funct_connex.php";
        echo '<form  method="get">';
        echo '<fieldset style="width: 500px">
				<legend>Select the tag to modify</legend>
                <label>Tag type</label>';
                //display a list with all the tag type 
                //when we select a tag type it calls the go() js function to update the second list
				echo ' <select name="tag_type" id="tag_type" onchange="go()"> 
					<option value="-1">Choose a tag type</option>';
                    require_once "funct_connex.php";
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
				<label>Tag</label>
				<div id="tag" style="display:inline">
				<select name="tag">';
                    echo '<option value="-1">Choose a tag</option>';
				echo '</select>
                </div>';
                echo '<div style="display:inline"> <input type="submit" value="Modify"  /></div>';
			echo '</fieldset>';
        echo '</form>';
        
        //if we click on previous "modify" it displays a new form 
        //to modify the fields of the selected tag
        //which displays the value of the fields to modify it
        if (isset($_GET["tag"])){
            session_start(); 
            $id_tag=$_GET["tag"];
            $_SESSION["id_tag"]=$id_tag; 
            $query3 = 'SELECT * FROM tags where id_tag='.$_GET["tag"];
            $result3 = pg_query($connex, $query3)or die(pg_last_error($connex));
            while($row3 = pg_fetch_assoc($result3)){
                echo '<form method="GET" name="edition_tag" action="US1-54_modify_tag.php">
                Edit the tag name  :
                <input type="text" name="tag_name" value="'.$row3["tag_name"].'" ><br/>
                Edit the new description:
                <input type="text" name="tag_description" value="'.$row3["tag_description"].'" ><br/>
                <div><input type="submit" value="Submit" /></div>
                </form>';
            }
            
        }
        // if we click on the Validate button of the previous form 
        //(to send the informations to modify the tag type table)
        if (isset($_GET["tag_name"])){
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
            
            // Request to update the table "tag_type"
            $query = "UPDATE tags SET tag_name='".$tag_name."' , tag_description='".$tag_description."' WHERE id_tag='".$id_tag."' " ;       
            // Request execution
            $result = pg_query($connex, $query)  
                or die('Échec de la requête : ' . pg_error($connex)); 
            // displays this message if the modification is a success
            echo 'The tag  '.$tag_name.' has been modified';
        }
        
		?>
	</body>
</html>