<?php

/* Getting file name */
$filename = $_FILES['file']['name'];
//echo $filename;

/* Getting File size */
$filesize = $_FILES['file']['size'];

/* Location */
$location = "US_2_21_dragdrop_upload/".$filename;

$return_arr = array();

/* Upload file */
if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
    $src = "US_2_21_dragdrop_default.png";

    // checking file is image or not
    if(is_array(getimagesize($location))){
        $src = $location;
    }
    $return_arr = array("name" => $filename,"size" => $filesize, "src"=> $src);
}

echo json_encode($return_arr);
