<?php 
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $id = $_GET["id"];
        require 'require/conexion.php';
        $sql = "SELECT * FROM Amigos WHERE id=$id";
        $resultado = mysqli_query($conn, $sql);
        if ($resultado) {
            $fila = mysqli_fetch_assoc($resultado);
        } else {
            $fila = null;
        }
        mysqli_close($conn);
    }elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST["id"];
        $nombres = $_POST["nombres"];
        $apellidos = $_POST["apellidos"];
        $email = $_POST["email"];
        $cumpleaños = $_POST["cumpleaños"];
        $telefono = $_POST["telefono"];

        require 'require/conexion.php';
        // actualizando
        $sql = "UPDATE Amigos SET nombres='$nombres', apellidos='$apellidos', email='$email', cumpleanios='$cumpleaños', telefono='$telefono' WHERE id=$id";
        $resultado = mysqli_query($conn, $sql);
        if ($resultado){
            $actualizar = "ok";
        } else {
            $actualizar = "error";
        }
        header('location: listar.php?actualizar='. $actualizar);
        mysqli_close($conn);
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title> Agenda </title>
    <?php include 'include/meta.html' ?>
    <?php include 'include/css.html' ?>
</head>
<body>
    <div class="container">
        <!-- Menu principal -->
        <?php include 'include/menu.html' ?>
        <!-- Fin Menu principal -->
        <div class="card border-primary mb-3 mt-2">
            <div class="card-header"> Editar amigo </div>
            <div class="card-body text-primary">
                <form class="w-50" method="POST">
                    <div class="form-group">
                        <input type="text" class="form-control" name="id" value="<?= $fila['id'] ?>" required hidden >
                    </div>
                    <div class="form-group">
                        <label> Nombres </label>
                        <input type="text" class="form-control" name="nombres" value="<?= $fila['nombres'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label> Apellidos </label>
                        <input type="text" class="form-control" name="apellidos" value="<?= $fila['apellidos'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label> Email </label>
                        <input type="email" class="form-control" name="email" value="<?= $fila['email'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label> Cumpleaños </label>
                        <input type="date" class="form-control" name="cumpleaños" value="<?= $fila['cumpleanios'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label> Teléfono </label>
                        <input type="tel" class="form-control" name="telefono" value="<?= $fila['telefono'] ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary"> Actualizar </button>
                    <a href="listar.php" class="btn btn-secondary"> Cancelar </a>
                </form>
            </div>
        </div>
    </div>

    <?php include 'include/js.html' ?>
</body>
</html>