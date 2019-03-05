<html>
<body>

<?php
session_start();
$pos = $_GET['i'];
$path = $_SESSION["path[".$pos."]"];


require_once "tab_donnees/tab_donnees.class.php";
require_once "tab_donnees/funct_connex.php";


if(!empty($_GET['file'])){
    $fileName = basename($_GET['file']);
    $filePath = $path.$fileName;

    if(!empty($fileName) && file_exists($filePath)){
        // Define headers
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$fileName");
        header("Content-Type: application/zip");
        header("Content-Transfer-Encoding: binary");

        // Read the file
        readfile($filePath);
        exit;
    }else{
        echo 'The file does not exist.';
    }
}
?>
</body>
</html>
