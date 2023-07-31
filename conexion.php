<?php 
	function crearConexion() {
		// Cambiar en el caso en que se monte la base de datos en otro lugar
		$host = "localhost";
		$user = "root";
		$pass = "";
		$baseDatos = "pac3_daw";

		// Establecemos conexión con la base de datos
		$conexion = mysqli_connect($host, $user, $pass, $baseDatos);

		// Si hay un error en la conexión mostramos dicho error y detenemos cualquier ejecución
		if (!$conexion) {
			die("<br> Error de conexión con la base de datos: " . mysqli_connect_error());
		}
		// Si todo está correcto mostramos un mensaje por pantalla y retornamos $conexión
		else {
			// echo "<br> Conexión correcta con la base de datos: " . $baseDatos . "<br>";
		}
		return $conexion;
	}

	function cerrarConexion($conexion) {
		mysqli_close($conexion);
	}
?>