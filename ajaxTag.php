<!--developpers: Camille Bonas et Julien Louet-->
<!--Page liée à la page "modifier un tag" -->
<!--Elle permet de lier la liste "tag type" à la liste "tag" -->
<!-- -->
<head>
    <META charset="UTF-8">
</head>
<?php
	echo "<select name='tag'>";
	if(isset($_POST["id_tag_type"])){
		require_once "funct_connex.php";
        $con=new Connex();
        $connex=$con->connection;
        $res = pg_query($connex, "SELECT * FROM tags WHERE id_tag_type=".$_POST["id_tag_type"]." ORDER BY tag_name")
        or die(pg_last_error($connex));
        while($row = pg_fetch_assoc($res)){
            echo "<option value='".$row["id_tag"]."'>".$row["tag_name"]."</option>";
        }
	}
	echo "</select>";
?>