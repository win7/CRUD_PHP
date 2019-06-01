<?php 
	$crear = "";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$nombre_foto = $_FILES["foto"]["name"];
		$tipo = $_FILES["foto"]["type"];
		$tamaño = $_FILES["foto"]["size"];

		// Directorio root
		$directorio = $_SERVER["DOCUMENT_ROOT"]; # Dar permiso
		
		$dir_foto = "/AgendaFotos/". $nombre_foto;
		// Mover imagen desde directorio temporal a directorio final
		move_uploaded_file($_FILES["foto"]["tmp_name"], $directorio. $dir_foto);


		$nombres = $_POST["nombres"];
		$apellidos = $_POST["apellidos"];
		$email = $_POST["email"];
		$cumpleaños = $_POST["cumpleaños"];
		$telefono = $_POST["telefono"];

		require 'require/conexion.php';
		// insertando
        $sql = "INSERT INTO Amigos (nombres, apellidos, email, cumpleanios, telefono, dir_foto)
                VALUES ('$nombres', '$apellidos', '$email', '$cumpleaños', '$telefono', '$dir_foto')";
        $resultado = mysqli_query($conn, $sql);
        if ($resultado){
            $crear = "ok";
        } else {
            $crear = "error";
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

		<div class="card border-primary mb-3 mt-2">
			<div class="card-header"> Agregar amigo </div>
			<div class="card-body text-primary">
				<?php 
					if ($crear == "ok") {
				?>
						<div class="alert alert-success" role="alert">
							Se guardo exitosamente...
						</div>
				<?php 
					}
				?>
				<form class="w-50" method="POST" enctype="multipart/form-data">
					<div class="form-group">
						<label> Nombres </label>
						<input type="text" class="form-control" name="nombres" required>
					</div>
					<div class="form-group">
						<label> Apellidos </label>
						<input type="text" class="form-control" name="apellidos" required>
					</div>
					<div class="form-group">
						<label> Email </label>
						<input type="email" class="form-control" name="email" required>
					</div>
					<div class="form-group">
						<label> Cumpleaños </label>
						<input type="date" class="form-control" name="cumpleaños" required>
					</div>
					<div class="form-group">
						<label> Teléfono </label>
						<input type="tel" class="form-control" name="telefono" required>
					</div>
					<div class="form-group">
						<label> Foto </label>
						<input type="file" class="form-control-file" name="foto">
					</div>
					<button type="submit" class="btn btn-primary"> Agregar </button>
					<button type="reset" class="btn btn-secondary"> Limpiar </button>
				</form> 
			</div>
		</div>
	</div>

	<?php include 'include/js.html' ?>
</body>
</html>