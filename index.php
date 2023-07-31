<!--
		Esta es la vista inicial, es la que nos solicita las credenciales de acceso a la aplicación.
-->

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Index.php</title>
</head>

<body>

	<form action="index.php" method="POST">
		<p>
			<label>Usuario:</label>
			<input type="text" name="usuario">
		</p>

		<p>
			<label>Correo: </label>
			<input type="mail" name="correo">
		</p>

		<input type="submit" name="acceso" value="Acceder">
	</form>

	<?php
	include "consultas.php";

	/* Comprobamos la existencia del elemento 'acceso' dentro del array POST. Si el elemento existe significa que hemos intentado acceder por lo que hay valores que comoprobar */
	if (isset($_POST['acceso'])) {
		$nombre = $_POST['usuario'];
		$correo = $_POST['correo'];

		// Con los datos introducidos realizamos una consulta para saber de que permisos dispone el usuario introducido
		$tipoUsuario = tipoUsuario($nombre, $correo);

		// Una vez conocemos el tipo de usuario que se trata mostramos el mensaje personalizado para cada caso: super-admin, usuario autorizado, usuario no autorizado, usuario inexistente.
		switch ($tipoUsuario) {
			case 'superadmin':
				echo 'Bienvenido SUPER-ADMIN ' . $nombre . '<a href="usuarios.php">. Pulsa en este enlace para entrar al panel de usuarios. </a>';
				break;

			case 'autorizado':
				echo 'Bienvenido ' . $nombre . '<a href="articulos.php"> Pulsa en este enlace para entrar al panel de artículos. </a>';
				break;

			case 'registrado':
				echo 'Hola ' . $nombre . ' pero no dipones de los permisos suficientes para acceder.';
				break;

			default:
				echo 'El usuario no está registrado en el sistema';
				break;
		}

		// Creamos la cookie en la que almacenaremos el tipo de usuario que ha iniciado sesión, de esta manera podemos comprobar los permisos disponibles en cualquier momento
		setcookie('tipoUsuario', $tipoUsuario, time() + 1000);
	}
	?>


</body>

</html>