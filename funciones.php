<?php 

	include "consultas.php";

	// Función que nos muestra la categoría a la que pertenece el producto sobre el que vamos a Editar, Añadir o Eliminar
	function pintaCategorias($defecto) {
		$categorias = getCategorias();

		while ($fila = mysqli_fetch_assoc($categorias)) {
			if ($fila['CategoryID'] == $defecto) {
				echo "<option value='" .$fila["CategoryID"]."'selected>" . $fila['Name'] . "</option>";
			}
			else {
				echo "<option value='" .$fila["CategoryID"]."'>" . $fila['Name'] . "</option>";
			}
			
		}
	}
	
	// Función que nos muestra los usuarios por pantalla
	function pintaTablaUsuarios(){
		$listaUsuarios = getListaUsuarios();

		// Construimos el encabezado de la tabla
		echo "<table>\n
						<tr>\n
							<th>Nombre</th>\n
							<th>Email</th>\n
							<th>Autorizado</th>\n
						</tr>\n";
		
		// Creamos un fila por cada usuario
		while ($fila = mysqli_fetch_assoc($listaUsuarios)) {
			echo "<tr>\n
							<td>".$fila['FullName']."</td>\n
							<td>".$fila['Email']."</td>\n";
			
			// Pintamos de rojo el campo permisos de aquellos usuarios con un 1
			if ($fila['Enabled'] == 1) {
				echo "<td class='rojo'>".$fila['Enabled']."</td>\n";
			} else {
				echo "<td>".$fila['Enabled']."</td>\n";
			}
			echo "</tr>\n";
		}
		echo "</table>\n";
	}

	// Función que nos muestra los productos por pantalla
	function pintaProductos($orden) {
		$productos = getProductos($orden);

		// Construimos el encabezado de la tabla haciéndo uso de los links para ordenar la tabla en base al campo en el que se hace click
		echo "<table>\n
						<tr>\n
							<th><a href='articulos.php?orden=ProductID'>ID</a></th>\n
							<th><a href='articulos.php?orden=Name'>Nombre</a></th>\n
							<th><a href='articulos.php?orden=Cost'>Coste</a></th>\n
							<th><a href='articulos.php?orden=Price'>Price</a></th>\n
							<th><a href='articulos.php?orden=categoria'>Categoría</a></th>\n
							<th>Acciones</th>\n
						</tr>";
		
		// Creamos una fila por cada uno de los productos obtenido en el array
		while ($fila = mysqli_fetch_assoc($productos)) {
			echo "<tr>\n
							<td>".$fila['ProductID']."</td>\n
							<td>".$fila['Name']."</td>\n
							<td>".$fila['Cost']."</td>\n
							<td>".$fila['Price']."</td>\n
							<td>".$fila['Categoria']."</td>\n";

			// Si en el momento en que accedemos a esta vista el usuario con que el entramos a la aplicación cuenta con los permisos de editar, añadir y borrar productos, mostramos los botones correspondientes
			if (getPermisos() == 1) {
				echo "<td>
								<a href='formArticulos.php?Editar=".$fila['ProductID']."'>Editar</a> - 
								<a href='formArticulos.php?Borrar=".$fila['ProductID']."'>Borrar
							</td>\n
							</tr>\n";
			}
		}
		echo "</table>\n";
	}

?>