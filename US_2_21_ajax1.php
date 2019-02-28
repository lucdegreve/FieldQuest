<?php
session_start();
$coords = $_GET['coords'];
$_SESSION['latitude'] = $coords[0];
echo $coords[0];
?>