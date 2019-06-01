<?php
	$actualizar = "";
	$eliminar = "";
	$registros_pagina = 5;
	if ($_SERVER["REQUEST_METHOD"] == "GET") {
		if (isset($_GET["actualizar"])) {
			$actualizar = $_GET["actualizar"];
		}
		if (isset($_GET["eliminar"])) {
			$eliminar = $_GET["eliminar"];
		}

		if (isset($_GET["pagina"])) {
			$pagina = $_GET["pagina"];
		} else {
			$pagina = 1;
		}
		
		require 'require/conexion.php';

		$sql = "SELECT id FROM Amigos";
		$resultado = mysqli_query($conn, $sql);
		$total = mysqli_num_rows($resultado);
		$num_paginas = ceil($total / $registros_pagina);
		
		// Listar
		$inicio = ($pagina - 1) * $registros_pagina;  // 0, 5, 10
		$sql = "SELECT * FROM Amigos ORDER BY nombres ASC LIMIT $inicio, $registros_pagina";
		$resultado = mysqli_query($conn, $sql);
		mysqli_close($conn);
	} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
		$atributo = $_POST["atributo"];
		$valor = $_POST["valor"];

		require 'require/conexion.php';
		// Buscar
		$sql = "SELECT * FROM Amigos where $atributo like '%$valor%' ORDER BY nombres ASC";
		$resultado = mysqli_query($conn, $sql);

		$total = mysqli_num_rows($resultado);
		$num_paginas = ceil($total / $registros_pagina);
		$pagina = 1;
		
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
			<div class="card-header"> Listar amigos </div>
			<div class="card-body text-primary">
				<?php 
					if ($actualizar == "ok") {
				?>
						<div class="alert alert-success" role="alert">
							Se actualizó exitosamente...
						</div>
				<?php 
					}
				?>
				<?php 
					if ($eliminar == "ok") {
				?>
						<div class="alert alert-success" role="alert">
							Se eliminó exitosamente...
						</div>
				<?php 
					}
				?>
				<form class="form-inline" role= "form" method="POST">
					<label class="my-1 mr-2"> Buscar por: </label>
					<select class="custom-select my-1 mr-sm-2" name="atributo">
						<option value="nombres"> Nombres </option>
						<option value="apellidos"> Apellidos </option>
						<option value="email"> Email </option>
						<option value="cumpleanios"> Cumpleaños </option>
						<option value="telefono"> Teléfono </option>
					</select>
					<input type="text" class="form-control mr-sm-2" placeholder="Escribir aqui.." name="valor" required>
					<button type="submit" class="btn btn-primary my-1"> Buscar </button>
					<a class="pl-2" href="listar.php"> Todos </a>
				</form>

				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th scope="col"> # </th>
								<th scope="col"> Nombres </th>
								<th scope="col"> Apellidos </th>
								<th scope="col"> Email </th>
								<th scope="col"> Cumpleaños </th>
								<th scope="col"> Teléfono </th>
								<th scope="col"> Foto </th>
								<th scope="col"> Acciones </th>
							</tr>
						</thead>
						<tbody>
						<?php
							$numeracion = ($pagina - 1) * $registros_pagina;
							foreach ($resultado as $fila) {
								$numeracion++;
						?>
							<tr>
								<th scope="row"> <?= $numeracion ?> </th>
								<td> <?= $fila["nombres"] ?> </td>
								<td> <?= $fila["apellidos"] ?> </td>
								<td> <?= $fila["email"] ?> </td>
								<td> <?= $fila["cumpleanios"] ?> </td>
								<td> <?= $fila["telefono"] ?> </td>
								<td> <img  class="rounded-circle" src="<?= $fila['dir_foto'] ?>" width="30" height="30" alt="foto"> </td>
								<td>
									<a href="editar.php?id=<?= $fila['id'] ?>" data-toggle="tooltip" title="Editar">
										<i class="fas fa-edit text-primary"></i>
									</a>
									<a href="eliminar.php?id=<?= $fila['id'] ?>" 
										onClick="return confirm('Estas seguro?');" data-toggle="tooltip" title="Eliminar">
										<i class="far fa-trash-alt text-danger"></i>
									</a>
									<a href="detalles.php?id=<?= $fila['id'] ?>" 
										data-toggle="tooltip" title="Ver detalle">
										<i class="fas fa-eye text-info"></i>
									</a>
								</td>
							</tr>
						<?php 
							}
						?>
						</tbody>
					</table>
					<nav aria-label="Page navigation example">
					  	<ul class="pagination justify-content-center">
					    	<li class="page-item <?= $pagina <= 1 ? 'disabled' : '' ?>">
					      		<a class="page-link" href="listar.php?pagina=<?= $pagina -1 ?>" tabindex="-1" aria-disabled="true"> Anterior </a>
					    	</li>
					    	<?php 
					    		for ($i = 1; $i <= $num_paginas ; $i++) {
					    	?>
					    		<li class="page-item <?= $i == $pagina ? 'active': '' ?>"><a class="page-link" href="listar.php?pagina=<?= $i ?>"> <?= $i ?> </a></li>
					    	<?php 
					    		}
					    	?>
					    	<li class="page-item <?= $pagina >= $num_paginas ? 'disabled' : '' ?>">
					      		<a class="page-link" href="listar.php?pagina=<?= $pagina + 1 ?>"> Siguiente </a>
					    	</li>
					  	</ul>
					</nav>
				</did>
			</div>
		</div>
	</div>
	
	<?php include 'include/js.html' ?>
	<script type="text/javascript">
		$('[data-toggle="tooltip"]').tooltip(); 
	</script>
</body>
</html>