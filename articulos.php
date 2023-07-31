<!--
	Vista donde se muestran todos los astículos de la base de datos
-->

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Articulos</title>
</head>
<body>
	<h1>Lista de artículos</h1>

	<?php
		include "funciones.php";
		// Al igual que en usuarios.php, comprobamos a través de la cookie que las credenciales mediante las que accedemos a esta vista son válidas
		if (!isset($_COOKIE['tipoUsuario']) || ($_COOKIE['tipoUsuario'] != 'autorizado')) {
			echo 'No tienes permiso para estar aquí';
		}
		else {
			// Si los permisos del usuario es 1, significa que puede añadir, borrar y editar elmentos, si no es 1 no se muestra el botón de añadir.
			if (getPermisos() == 1) {
			echo "<a href='formArticulos.php?Añadir'>Añadir producto</a>";
			}

			// Si dentro del array GET no disponemos de un elemento con nombre 'orden', ordenaremos los productos en base al ID del mismo.
			if (!isset($_GET['orden'])) {
				$orden = 'ProductID';
			}
			else{
				$orden = $_GET['orden'];
			}

			// Mostramos los productos por pantalla según el orden seleccionado
			pintaProductos($orden);
		}
	?>
	<a href="index.php">Volver al inicio</a>

</body>
</html>