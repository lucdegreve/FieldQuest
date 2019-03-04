<?php
session_start();
$coords = $_GET['coords'];
echo $coords[1];
$_SESSION['longitude'] = $coords[1];
?>