<?php 


/* This function takes in input a list and the name of the dropdown list */
function dropdown_list($list, $name){
	echo "<select name='".$name."'>";

foreach ($list as $element){
	echo "<option value='".array_search($element,$list)."'>".$element."</option>";
}
	echo "</select>";
}

?>