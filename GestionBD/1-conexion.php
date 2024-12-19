<?php
$servername = "localhost";
$username = "root";
$database = "coaching";
$password = "";

/*
$servername = "localhost";
$username = "sea";
$database = "coaching";
$password = "Pr0j3cts3@";
*/

// Creamos la conexion y seleccionamos la base de datos
$conn = mysqli_connect($servername, $username, $password,$database);
// Check connection
if (!$conn) {
    die("Conexion fallida: " . mysqli_connect_error());
}

?>
