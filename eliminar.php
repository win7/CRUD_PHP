<?php 
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $id = $_GET["id"];

        require 'require/conexion.php';
        // Eliminar
        $sql = "DELETE FROM Amigos WHERE id=$id";
        $resultado = mysqli_query($conn, $sql);

        if ($resultado){
            $eliminar = "ok";
        } else {
            $eliminar = "error";
        }
        header('location: listar.php?eliminar='. $eliminar);
        mysqli_close($conn);
    }
?>   