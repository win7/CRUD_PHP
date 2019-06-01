<?php 
    $servidor = "127.0.0.1";
    $usuario = "root";
    $contraseña = "";
    $bd = "BD_Agenda";

    $conn = mysqli_connect($servidor, $usuario, $contraseña, $bd);
    // verificando conexión
    if (!$conn){
        die("Error al conectar..." . mysqli_connect_error());
    }
    // echo "Conexión exitosa... <br>";
?>