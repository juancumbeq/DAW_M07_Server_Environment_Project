<!--
	Cuando accedemos mediante super-admin, esta es la vista del panel de usuarios, donde podemos ver los permisos que estos tiene y cambiarlos.
-->

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="estilo.css">
	<title>Usuarios</title>
</head>
<body>

	<?php 
		include "funciones.php";

		// Es ncesario comprobar que hemos accedido a esta vista gracias a las credenciales de super-admin, es por eso que si la cookie no está definida o si la cookie contiene un dato que no es 'superadmin' la vista nos muestra un mensaje por pantalla
		if (!isset($_COOKIE['tipoUsuario']) || ($_COOKIE['tipoUsuario'] != 'superadmin')) {
			echo 'No tienes permisos suficientes para estar aquí';
		}
		else {
			// Como este documento se 'llama' a si mismo tras hacer click sobre el botón 'cambiar permisos', verificamos la existencia del elemento 'Cambiar' dentro del array GET antes de realizar el proceso mediante la función correspondiente.
			if (isset($_GET['Cambiar'])) {
				cambiarPermisos();
			}
		}
		// Mostramos la lista de usuarios por pantalla
		pintaTablaUsuarios();
	?>

	<p>Los permisos de los que dispones son: 
		<span>
			<?php
				echo getPermisos();
			?>
		</span>
	</p>

	<form action="usuarios.php" method="GET">
		<p>
			<input type="submit" name="Cambiar" value="Cambiar permisos">
		</p>
	</form>

	<a href="index.php">Volver al inicio</a>

</body>
</html>