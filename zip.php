<?php
require_once "Zip_classes/src/zip.php";
    $zip = new Zip();
    $zip->zip_start("zip_map_file.zip");
    $zip->zip_add("dot.png");
	$zip->zip_add("pinpoint2.png");	// adding a file
    //$zip->zip_add(array("pinpoint2.png","dot.png")); // adding two files as an array
    $zip->zip_end();
?>