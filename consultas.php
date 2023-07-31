<?php
include "conexion.php";

// Esta función realiza la comprobación de si las credenciales introducidas son válidas
function tipoUsuario($nombre, $correo)
{
	$conexion = crearConexion();

	// Hacemos uso de la función esSuperAdmin para comprobar rápidamente si es super-admin
	if (esSuperadmin($nombre, $correo)) {
		return 'superadmin';
	}
	// Si no es super-admin realizamos una consulta sql para saber qué nivel de permisos dispone
	else {
		$sql = "SELECT FullName, Email, Enabled FROM user WHERE FullName = '$nombre' and Email = '$correo'";

		$result = mysqli_query($conexion, $sql);
		cerrarConexion($conexion);

		if ($datos = mysqli_fetch_array($result)) {
			// Sólo si $datos es un array válido pasamos a comprobar el campo 'Enabled'
			if ($datos['Enabled'] == 0) {
				return 'registrado';
			} else if ($datos['Enabled'] == 1) {
				return 'autorizado';
			}
		}
		// Si $datos es un array vacío es debido a que la consulta sql no ha encontrado información sobre el usuario introducido.
		else {
			return 'no registrado';
		}
	}
}

// Función que nos permite conocer rápidamente si el usuario introducido es super-admin o no
function esSuperadmin($nombre, $correo)
{
	$conexion = crearConexion();
	$sql = "SELECT user.UserID FROM user INNER JOIN setup ON user.UserID = setup.SuperAdmin WHERE user.FullName = '$nombre' and user.Email = '$correo'";

	$result = mysqli_query($conexion, $sql);

	// El return sólo nos interesa que sea true o false ya que si es true, ya disponemos de los datos y si es false, la consulta sobre los permisos se realiza en 'tipoUsuario()'
	if ($datos = mysqli_fetch_assoc($result)) {
		return true;
	} else {
		return false;
	}
}

// Función que realiza una consulta y que obtiene como resultado una tabla virtual de la cuál obtenemos la primera fila en formato array y devolvemos el primer elemento del mismo.
function getPermisos()
{
	$conexion = crearConexion();
	$sql = "SELECT Autenticación FROM setup";

	$result = mysqli_fetch_assoc(mysqli_query($conexion, $sql));

	cerrarConexion($conexion);

	return $result['Autenticación'];
}

// Esta función realiza una consulta mediante la cuál modifica el campo 'Autenticación' de la tabla setup.
function cambiarPermisos()
{
	$permisos = getPermisos();
	$conexion = crearConexion();

	if ($permisos == 1) {
		$sql = "UPDATE setup SET Autenticación = 0";
	} else if ($permisos == 0) {
		$sql = "UPDATE setup SET Autenticación = 1";
	}

	$result = mysqli_query($conexion, $sql);

	cerrarConexion($conexion);
}

// Función que obtiene el id y el nombre de las categorías de la tabla correspondiente
function getCategorias()
{
	$conexion = crearConexion();
	$sql = "SELECT CategoryID, Name FROM category";

	$result = mysqli_query($conexion, $sql);

	cerrarConexion($conexion);

	return $result;
}

// Función que nos da los registros de todos los usuarios
function getListaUsuarios()
{
	$conexion = crearConexion();
	$sql = "SELECT FullName, Email, Enabled FROM user";

	$result = mysqli_query($conexion, $sql);

	cerrarConexion($conexion);

	return $result;
}

// Función que nos proporciona la información de un producto en concreto
function getProducto($ID)
{
	$conexion = crearConexion();
	$sql = "SELECT * FROM product WHERE ProductID = $ID";

	$result = mysqli_query($conexion, $sql);

	cerrarConexion($conexion);

	return $result;
}

function getProductos($orden)
{
	$conexion = crearConexion();
	$sql = "SELECT product.ProductID, product.Name, product.Cost, product.Price, category.Name AS Categoria FROM product INNER JOIN category WHERE product.CategoryID = category.CategoryID ORDER BY $orden";

	$result = mysqli_query($conexion, $sql);

	cerrarConexion($conexion);

	return $result;
}

function anadirProducto($nombre, $coste, $precio, $categoria)
{
	$conexion = crearConexion();
	$sql = "INSERT INTO product (Name, Cost, Price, CategoryID) VALUES ('$nombre', $coste, $precio, $categoria)";

	$result = mysqli_query($conexion, $sql);

	cerrarConexion($conexion);

	return $result;
}

function borrarProducto($id)
{
	$conexion = crearConexion();
	$sql = "DELETE FROM product WHERE ProductID = $id";

	$result = mysqli_query($conexion, $sql);

	cerrarConexion($conexion);

	return $result;
}

function editarProducto($id, $nombre, $coste, $precio, $categoria)
{
	$conexion = crearConexion();
	$sql = "UPDATE product SET Name = '$nombre', Cost = '$coste', Price = '$precio', CategoryID = '$categoria' WHERE ProductID = '$id'";

	$result = mysqli_query($conexion, $sql);

	cerrarConexion($conexion);

	return $result;
}

?>