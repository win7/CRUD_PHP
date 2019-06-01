<?php
    $actualizar = "";
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $id = $_GET["id"];

        require "require/conexion.php";

        $sql = "SELECT * FROM Amigos WHERE id=$id";
        $resultado = mysqli_query($conn, $sql);
        if ($resultado) {
            $fila = mysqli_fetch_assoc($resultado);
        } else {
            $fila = null;
        }
        mysqli_close($conn);
    } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST["id"];

        $nombre_foto = $_FILES["foto"]["name"];
        $tipo = $_FILES["foto"]["type"];
        $tamaño = $_FILES["foto"]["size"];

        // Directorio root
        $directorio = $_SERVER["DOCUMENT_ROOT"]; # Dar permiso
        
        $dir_foto = "/AgendaFotos/". $nombre_foto;
        // Mover imagen desde directorio temporal a directorio final
        move_uploaded_file($_FILES["foto"]["tmp_name"], $directorio. $dir_foto);

        require "require/conexion.php";
        // actualizando
        $sql = "UPDATE Amigos SET dir_foto='$dir_foto' WHERE id=$id";
        $resultado = mysqli_query($conn, $sql);
        if ($resultado){
            header('location: detalles.php?id='. $id);
        } else {
            $actualizar = "error";
        }
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
        <div class="card mb-3 mt-2">
          <div class="row no-gutters">
            <div class="col-md-4">
              <img src="<?= $fila['dir_foto'] ?>" class="card-img h-100" alt="foto">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title"> Datos de amigo </h5>
                <?php 
                    if ($actualizar == "ok") {
                ?>
                        <div class="alert alert-success" role="alert">
                            Se actualizó exitosamente...
                        </div>
                <?php 
                    }
                ?>
                <dl class="row">
                  <dt class="col-sm-3"> Nombres </dt>
                  <dd class="col-sm-9"> <?= $fila['nombres'] ?> <?= $fila['apellidos'] ?> </dd>

                  <dt class="col-sm-3"> Email </dt>
                  <dd class="col-sm-9">
                    <?= $fila['email'] ?>
                  </dd>

                  <dt class="col-sm-3"> Cumpleaños </dt>
                  <dd class="col-sm-9"> <?= $fila['cumpleanios'] ?> </dd>

                  <dt class="col-sm-3 text-truncate"> Teléfono </dt>
                  <dd class="col-sm-9"> <?= $fila['telefono'] ?> </dd>
                </dl>
                <form class="w-50" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" class="form-control" name="id" value="<?= $fila['id'] ?>" required hidden >
                    </div>
                    <div class="form-group">
                        <label> Foto </label>
                        <input type="file" class="form-control-file" name="foto">
                    </div>
                    <button type="submit" class="btn btn-primary"> Actualizar </button>
                </form>
              </div>
            </div>
          </div>
        </div>
    </div>
    <?php include 'include/js.html' ?>
</body>
</html>