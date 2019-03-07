<?php


$brochure = $_POST['brochure'] ;

$send = true;

if($send) {
    $zip = new ZipArchive();
    $res = $zip->open('download.zip', ZipArchive::CREATE);
    if ($res === TRUE) {
        foreach ($brochure as $filename) {

            $zip->addFile($filename);
        }
        $zip->close();

        header('Content-type: application/zip');
        header('Content-Disposition: attachment; filename="download.zip"');
        readfile('download.zip');

    }else {
        echo 'failed';
    }
  }
?>
