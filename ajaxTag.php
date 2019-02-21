<META charset="UTF-8">
<?php
	echo "<select name='tag'>";
	if(isset($_POST["id_tag_type"])){
		require "funct_connex.php";
        $con=new Connex();
        $connex=$con->connection;
		$res = pg_query($connex, "SELECT * FROM tags 
			WHERE id_tag_type=".$_POST["id_tag_type"])or die(pg_last_error($connex));
		while($row = pg_fetch_assoc($res)){
			echo "<option value='".$row["id_tag"]."'>".$row["tag_name"]."</option>";
		}
	}
	echo "</select>";
?>