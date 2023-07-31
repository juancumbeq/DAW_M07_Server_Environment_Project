<!--
	Cuando deseamos añadir, modificar o eliminar un producto de la lista, este es el formulario que se nos muestra por pantalla
-->

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Formulario de artículos</title>
</head>
<body>

	<?php 
		include "funciones.php";

		// Comprobamos los permisos correpondientes
		if (!isset($_COOKIE['tipoUsuario']) || ($_COOKIE['tipoUsuario']) != 'autorizado') {
			echo 'No tienes permiso para estar aquí';
		} 
		else {
			// Si hemos hecho click en Editar o en Borrar necesitamos extrar la información del producto correspondiente para mostrarlo por pantalla
			if (isset($_GET['Editar'])) {
				$datosProducto = mysqli_fetch_assoc(getProducto($_GET['Editar']));
			}
			else if (isset($_GET['Borrar'])) {
				$datosProducto = mysqli_fetch_assoc(getProducto($_GET['Borrar']));
			}
			// Si hemos hecho click en añadir se nos muestra un formulario rellenado con valores por defecto, esto lo hacemos rellenando el array datosProducto con valores vacios.
			else {
				$datosProducto = ["ProductID" => "",
													"Name" => "",
													"Cost" => 0,
													"Price" => 0,
													"categoria" => "PANTALÓN"];
			}
		}
	?>

	<form action="formArticulos.php" method="POST">
		<p>
			<label>ID: </label> 
			<input type="text" value="<?php echo $datosProducto['ProductID'];?>" disabled>
			<input type="hidden" name="id" value="<?php echo $datosProducto['ProductID'];?>">
		</p>
		<p>
			<label>Nombre: </label>
			<input type="text" name="nombre" value="<?php echo $datosProducto['Name'];?>">
		</p>
		<p>
			<label>Coste: </label>
			<input type="text" name="coste" value="<?php echo $datosProducto['Cost'];?>">
		</p>
		<p>
			<label>Precio: </label>
			<input type="text" name="nombre" value="<?php echo $datosProducto['Price'];?>">
		</p>
		<p>
			<label>Categoría: </label>
			<select name="categoria">
				<?php
					pintaCategorias($datosProducto['CategoryID']);
				?>
			</select>
		</p>

		<?php
			// En funciónde lo que se pretenda hacer con el producto mostramos el botón correspondiente a la acción
			if (isset($_GET['Editar'])) {
				echo "<input type='submit' name='Accion' value='Editar'>";
			}
			else if (isset($_GET['Borrar'])) {
				echo "<input type='submit' name='Accion' value='Borrar'>";
			}
			else {
				echo "<input type='submit' name='Accion' value='Añadir'>";
			}
		?>

		<?php
			// En función de donde hayamos hecho click ejecutaremos la función correspondiente para añadir, borrar o eliminar un produccto
			if (isset($_GET['Accion'])) {
				switch ($_GET['Accion']) {
					case 'Editar':
						if (editarProducto($_GET['id'], 
															$_GET['nombre'], 
															$_GET['coste'], 
															$_GET['precio'], 
															$_GET['categoria'])) {
							echo 'Se ha editado el producto';
						}
						else {
							echo 'No se ha editado el producto';
						}
						break;
					
					case 'Borrar':
						if (borrarProducto($_GET['id'])) {
							echo 'Se ha borrado el producto';
						}
						else {
							echo 'No se ha borrado el producto';
						}
						break;

					case 'Añadir':
						if (añadirProducto($_GET['nombre'], 
															$_GET['coste'], 
															$_GET['precio'], 
															$_GET['categoria'])) {
							echo 'Se ha añadido el producto';
						}
						else {
							echo 'No se ha añadido el producto';
						}
						break;
				}
			}
		?>
		<a href="articulos.php">Volver</a>

	</form>

	
</body>
</html>