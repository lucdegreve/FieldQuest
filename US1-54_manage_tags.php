<head>
    <!--developpers: Camille Bonas et Julien Louet-->
    <!--This page will make it possible to visualize the different categories as well as the tags and the possibility to create new ones-->
    <!--Avancement: on a changé de vision et créé un menu "accordéon" pour rendre l'arborescence des tags dynamique-->
    <!--Avancement(2): tuto https://www.alsacreations.com/tuto/lire/602-Creer-un-menu-accordeon-avec-jQuery.html -->
    <META charset="UTF-8">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

    <script type="text/javascript"> // allows to make a tree structure dynamic

        $(document).ready( function () {
            // We hide the sub-menus except the one with the class "open_at_load" :
            $(".navigation ul.subMenu:not('.open_at_load')").hide();
            // We select all list items with the class "toggleSubMenu" and replace the span element they contain with a link :
            $(".navigation li.toggleSubMenu span").each( function () {
                // We stock the span content :
                var TexteSpan = $(this).text();
                $(this).replaceWith('<a href="" title="Afficher le sous-menu">' + TexteSpan + '<\/a>') ;
            } ) ;
            // We modify the "click" event on the links in the list items that have the class "toggleSubMenu" :
            $(".navigation li.toggleSubMenu > a").click( function () {
                // If the sub-menu was open, we close it :
                if ($(this).next("ul.subMenu:visible").length != 0) {
                    $(this).next("ul.subMenu").slideUp("normal", function () { $(this).parent().removeClass("open") } );
                }
                // If the sub-menu is hidden, we close the others and display it :
                else {
                    $(".navigation ul.subMenu").slideUp("normal", function () { $(this).parent().removeClass("open") });
                    $(this).next("ul.subMenu").slideDown("normal", function () { $(this).parent().addClass("open") } );
                }
                return false; // Prevent the browser to follow the link
            });

        } ) ;
    </script>
</head>
<body> 
	<?php
		include("en_tete.php");
    ?>
    Create
    <a href="US1-51_create_tag_type.php"><button type="button" class='btn btn-outline-primary'>New tag category</button></a>
    <a href="US1-53_create_tag.php"><button type="button" class='btn btn-outline-primary'>New tag</button> </a>
    Modify
    <a href="US1-54_modify_tag_type.php"><button type="button" class='btn btn-outline-warning'  >Modify tag category</button> </a>
    <a href="US1-54_modify_tag.php"><button type="button" class='btn btn-outline-warning'>Modify tag</button></a>

    <?php
        require "./tab_donnees/funct_connex.php";
        //connection to server + choice of database
		$con = new Connex();
        $connex = $con->connection;
		//request parameters
		$query = "SELECT tt.id_tag_type, name_tag_type FROM  tag_type tt  ";
		//request execution
        $result = pg_query($connex, $query) or die(pg_last_error());
		// Results browsing line by line
		// For each line pg_fetch_array return a value table  
		while ($row = pg_fetch_array($result)) { 
			// The access to a table element can be do thanks to index or field name
            // Here we are using field name
            $id_cat= $row["id_tag_type"];
            //Beginning of the dynamic menu
			echo '<ul class="navigation">';
                //echo '<li><a href="#" title='.$row["name_tag_type"].'>'.$row["name_tag_type"].'</a></li>';
                echo '<li class="toggleSubMenu"><span>'.$row["name_tag_type"].' </span>';
                    echo '<ul class="subMenu">';
                    $query2 = "SELECT id_tag_type, tag_name,  tag_description FROM tags where id_tag_type=".$id_cat." ORDER BY tag_name"; //it gives the name of the tag within the category
                    $result2 = pg_query($connex, $query2)  or die('Échec de la requête : ' . pg_error($connex)); 
                    while ($row2 = pg_fetch_array($result2))
                        echo '<li> <a href="#" title="'.$row2["tag_name"].'" value="'.$row2["id_tag_type"].'">'.$row2["tag_name"].'</a></li>';
                        $_SESSION["id_tag_type"]=$row2["id_tag_type"]; //on garde l'id de la catégorie en variable de session
                        $_SESSION["tag_name"]=$row2["tag_name"]; //on garde le nom du tag en variable de session
                        $_SESSION["tag_description"]=$row2["tag_description"];
                        echo '</ul>';
                echo '</li>';
            echo '</ul>';	
		}
    ?>
    
</body>  
	<?php
		include("pied_de_page.php");
	?>

