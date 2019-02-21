<?php

/* Getting file name */
$filename = $_FILES['file']['name'];
$date = new DateTime();
$new_filename = $date->getTimestamp() . $filename;

/* Getting File size */
$filesize = $_FILES['file']['size'];

/* Location */
$location = "US_2_21_dragdrop_upload/".$new_filename;

$return_arr = array();

/* Upload file */
if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
    $src = "US_2_21_dragdrop_default.png";

    // checking file is image or not
    if(is_array(getimagesize($location))){
        $src = $location;
    }
    $return_arr = array("name" => $new_filename,"size" => $filesize, "src"=> $src);
}

echo json_encode($return_arr);