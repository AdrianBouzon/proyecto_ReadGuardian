<?php

$dbhost="localhost:3308";
$dbuser="root";
$dbpass="";
$dbname="bibliotecaprueba";

$conn = mysqli_connect($dbhost, $dbuser,$dbpass, $dbname);
if(!$conn){
    die("No hay conexion: ".mysqli_connect_error());
}

?>
