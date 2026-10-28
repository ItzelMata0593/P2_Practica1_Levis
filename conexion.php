<?php
$host = "localhost";#Dice donde esta la base de datos
$user = "root";#Nombre de usiario para entrar predeterminado
$password = "";#Contraseña para entrar vacia
$dbname = "levis";#Nombre de la base de datos

$conexion = new mysqli($host, $user, $password, $dbname);#Crea la conexion

if ($conexion->connect_error) {#Si la conexxion falla
    die("Error de conexión: " . $conexion->connect_error);#Aparece este mensaje
}
?>
