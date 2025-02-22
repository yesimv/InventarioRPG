<?php
	require '../php/conexionbd.php';
	$alert = '';
	session_start();
	if (empty($_SESSION['active'])) {
		header('location: ../');
	}

?>
<!DOCTYPE html>
<html>
<head> 
	<meta charset="utf-8"> 
	<title>Inventario</title>
	<link rel="icon" href="../images/runa-icon.png">
	<!-- <link rel="stylesheet" href="../styles/style.css"> -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;700;800&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/fda02b8f12.js" crossorigin="anonymous"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<style>
		
	body {
		font-family: 'Montserrat', sans-serif;
		background-color: #141414; 
		color: #7fddea;
		/* Agregar un degradado oscuro */
		background-image: 
		url('../images/marco.png'),
        linear-gradient(rgba(0, 0, 0, .9), rgba(0, 0, 0, 1)),  
        url('../images/centro-marco.webp');
        

    background-repeat: no-repeat, no-repeat, no-repeat;
    background-attachment: fixed, fixed, fixed;
    background-position: 50% 0%, center bottom, center center;
    background-size:120vh, cover, cover;
		
	}
	
	/* Ejemplo de uso con variables */
	h1, h2, h3, p {
		font-family: 'Montserrat', sans-serif;
		font-weight: 200; /* Usar peso de 700 (negrita) */
		margin-bottom: 20px;
		color: white;
	}
	
	td{
		color:white;
	}
	th{
		padding: 10px;
	}
	p {
		font-family: 'Montserrat', sans-serif;
		font-weight: 400; /* Usar peso normal */
	}
	input{
		background-color: #1a1b1c;
		margin-bottom:10px; 
	}
	i{
		width: 50px;
	}
	.navbar{
		
	}
	.alert{
		padding: 0px;
		margin: 0px;

	}
	.input{
		background-color: #1a1b1c; 
	}
	.cuadro-oscuro{
		padding:30px;
		background-color: rgb(30,30,30,0.8);
		height: fit-content;
		
	}

	.boton{
		
		background-color: #7fddea ;
	}
	.boton:hover{
		color: #7fddea;
		background-color: #25252b ;
	}
	.boton-s{
		color: #7fddea;
		background-color: inherit;
	}
	.boton-s:hover{
		color: black;
		background-color: #7fddea ;
	}
	.custom-input {
        background-color: #1a1b1c; /* Fondo oscuro */
        color: #fff; /* Texto blanco */
        border: 1px solid #3a3a3f; /* Borde amarillo */
        border-radius: 5px; /* Opcional: bordes redondeados */
        padding: 10px; /* Espaciado interno */
        transition: border-color 0.3s ease-in-out; /* Transición suave para cambios de color */
    }

    .custom-input:focus {
		background-color: #1a1b1c; /* Fondo oscuro */
        color: #fff; /* Texto blanco */
        border-color: white; /* Color del borde al hacer foco */
        outline: none; /* Remover el contorno predeterminado */
        box-shadow: 0 0 8px rgba(127, 222, 234, 0.2); /* Efecto de sombra opcional */
    }
	.custom-input::placeholder {
        color: #fff; /* Placeholder en blanco */
        opacity: 0.5; /* Ajusta la opacidad para mejor visibilidad */
    }
	.modal{
		width: fit-content;
		height:fit-content;
		position: fixed;
		bottom: 0;
		right: 0;
		
		
	}
	.modal-content{
		box-shadow: 0 0 8px rgba(127, 222, 234, 0.2); /* Efecto de sombra opcional */
		background-color: rgb(26,27,28,0.9);
	}
	.modal > div{
		width: fit-content;
		height:fit-content;
		position: fixed;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		padding: 20px;
	}
	.close{
		display: flex;
		justify-content:right;
		font-size: 2em;
		line-height:1;
		cursor: pointer;
	}
	
	
	</style>

</head>
<body > 
	<div class="cuadro-oscuro p-3 sticky-top ">
		<div class="row">
			<div class="col-8">
				<button type="button" class="btn boton-s active" onclick="window.location.href='index.php'" aria-pressed="true">Inventario</button>
				<button type="button" class="btn boton-s" onclick="window.location.href='crear_venta.php'">Transacción</button>
				
			</div>
			<div class="col-4 text-end">
				<button type="button" class="btn btn-outline-dark boton" onclick="window.location.href='../php/salir.php'">Cerrar sesión</button>
			</div>
		</div>
	</div>


	<div class="container text-center py-4">
		<div class="row row-cols-auto justify-content-evenly">
			<div class="col  cuadro-oscuro shadow rounded my-4">
				<!-- Formulario de búsqueda -->
				<div style="text-align: center; " class="">
					<u><p>BUSCAR</p></u>
				</div>
				<div class="d-flex justify-content-evenly" style="text-align: center; margin: 20px 0;">
					<form method="GET" action="">
						<input class="form-control custom-input" 
							type="text" 
							name="buscar" 
							placeholder="Buscar por ID o Nombre del Producto" 
							value="<?php echo isset($_GET['buscar']) ? $_GET['buscar'] : ''; ?>" 
							style="padding: 5px; width: 300px;"
						>
						<button class="btn boton-s" type="submit" style="padding: 5px 10px;">Buscar</button>
					</form>
				</div>
				<?php if ($_SESSION['rolus'] == 1): ?>
					<u><p>REGISTRAR PRODUCTO</p></u>
					<div>
						<form action="procesar_agregar.php" method="POST">
							<div class="login">
								<div class="textbox d-flex align-items-center">
									<i class="fas fa-clipboard"></i>
									<input type="text" class="form-control custom-input" placeholder="Nombre del producto" id="nombre_producto" name="nombre_producto" autocomplete="off" required>
								</div>
								
								<div class="textbox d-flex align-items-center">
									<i class="fa-solid fa-boxes-stacked"></i>
									<input type="number" class="form-control custom-input" placeholder="Cantidad en stock" id="stock" name="stock" autocomplete="off" required>
								</div>
								
								<div class="textbox d-flex align-items-center">
									<i class="fas fa-dollar-sign"></i>
									<input type="text" class="form-control custom-input" placeholder="Precio de venta unitario" id="precio_venta" name="precio_venta" autocomplete="off" required>
								</div>

								<div class="textbox d-flex align-items-center">
									<i class="fas fa-box"></i>
									<select class="form-control custom-input" id="tipo" name="tipo" required>
										<option value="">Selecciona Tipo</option>
										<option value="Cabeza">Cabeza</option>
										<option value="Pies">Pies</option>
										<option value="Torso">Torso</option>
										<option value="ArmaPrimaria">Arma Primaria</option>
										<option value="ArmaSecundaria">Arma Secundaria</option>
									</select>
								</div>

								<div class="textbox d-flex align-items-center">
									<i class="fas fa-star"></i>
									<select class="form-control custom-input" id="rareza" name="rareza" required>
										<option value="">Selecciona Rareza</option>
										<option value="Comun">Común</option>
										<option value="Rara">Rara</option>
										<option value="Epica">Épica</option>
										<option value="Legendaria">Legendaria</option>
									</select>
								</div>

								<div class="textbox d-flex align-items-center">
									<i class="fas fa-image"></i>
									<input type="text" class="form-control custom-input" placeholder="URL de la imagen" id="image" name="image">
								</div>

								<div class="textbox d-flex align-items-center">
									<i class="fas fa-align-left"></i>
									<textarea class="form-control custom-input" placeholder="Descripción" id="descripcion" name="descripcion"></textarea>
								</div>

								<input class="btn boton-s" type="submit" value="Registrar">
							</div>
						</form>
					</div>


					<?php if ($_SESSION['rolus'] == 1): ?>
						<u><p>ELIMINAR PRODUCTO</p></u>
						<?php
							$mensajee = isset($_GET['mensajee']) ? $_GET['mensajee'] : '';
						?>
						<div>
							<form action="procesar_eliminar.php" method="POST">
								<div class="login">
									<div class="textbox d-flex align-items-center ">
										<i class="fas fa-barcode"></i>
										<input class="form-control custom-input"  type="text" placeholder="Id del producto" name="idreg" autocomplete="off" required>
									</div>
									
									<input class="btn boton-s" type="submit" value="Eliminar">
									<div class="alert" align-te>
										<?php if (!empty($mensajee)) : ?>
											<p><?php echo htmlspecialchars($mensajee); ?></p>
										<?php endif; ?>
									</div>
								</div>
							</form>
						</div>
					<?php endif; ?>
				</div>
				<?php endif; ?>
			</div>
			
			<div class="col cuadro-oscuro shadow rounded">
				<div style="text-align: center;">
					<u><p>INVENTARIO</p></u>
				</div>

				

				<!-- Tabla de productos -->
				<div>
					<table style="width:100%; text-align: center;">
						<thead>
							<tr>
								<th>ID Producto</th>
								<th>Nombre del Producto</th>
								<th>Tipo</th>
								<th>Rareza</th>
								<th>Stock</th>
								<th>Precio</th>
								<th></th>
							</tr>
						</thead>
						<?php
						// Obtener el término de búsqueda (si existe)
						$buscar = isset($_GET['buscar']) ? $_GET['buscar'] : '';

						// Ajustar la consulta SQL con el filtro
						$sql = "SELECT * FROM inventario";
						if (!empty($buscar)) {
							$sql .= " WHERE id LIKE '%$buscar%' OR nombre_producto LIKE '%$buscar%'";
						}
						
						

						// Ejecutar la consulta
						$result = mysqli_query($conn, $sql);
						?>
						<tbody>
							<?php
							while ($inventario = mysqli_fetch_array($result)) {
							?>
								<tr>
									<td><?php echo $inventario['id']; ?></td>
									<td><?php echo $inventario['nombre_producto']; ?></td>
									<td><?php echo $inventario['tipo']; ?></td>
									<td><?php echo $inventario['rareza']; ?></td>
									<td><?php echo $inventario['stock']; ?></td>
									<td><?php echo $inventario['precio_venta']; ?></td>
									
									<td><img src="<?php echo $inventario['image']; ?>" width="50"></td>
									<td>
										<?php if ($_SESSION['rolus'] == 1): ?>
											<button class='btn boton-s' 
												onclick="openModalModificar('<?php echo $inventario['id']; ?>', '<?php echo $inventario['nombre_producto']; ?>', '<?php echo $inventario['tipo']; ?>', '<?php echo $inventario['stock']; ?>', '<?php echo $inventario['precio_venta']; ?>', '<?php echo $inventario['rareza']; ?>', '<?php echo $inventario['image']; ?>', '<?php echo $inventario['descripcion']; ?>')">
												Modificar
											</button>
										<?php endif; ?>
										<button class='btn boton-s' onclick="openModalDetalles('<?php echo $inventario['id']; ?>')">
											Ver Detalles
										</button>
									</td>

								</tr>

							<?php
							}

							
							if (mysqli_num_rows($result) == 0) {
								echo "<tr><td colspan='5'>No se encontraron resultados.</td></tr>";
							}
							?>
						</tbody>
						<div id="modal-modificar" class="modal">
							<div class="modal-content input">
								<span class="close" onclick="closeModal('modal-modificar')">&times;</span>
								<h2>MODIFICAR PRODUCTO</h2>
								<form method="POST" action="procesar_modificar.php">
									<input type="hidden" id="modal-id" name="idp">
									
									<div class="textbox d-flex align-items-center">
										<i class="fas fa-clipboard"></i>
										<input class="form-control custom-input" type="text" placeholder="Nombre del producto" id="modal-nomp" name="nomp" required>
									</div>

									<div class="textbox d-flex align-items-center">
										<i class="fa-solid fa-boxes-stacked"></i>
										<input class="form-control custom-input" type="number" placeholder="Stock" id="modal-stoc" name="stoc" required>
									</div>

									<div class="textbox d-flex align-items-center">
										<i class="fas fa-dollar-sign"></i>
										<input class="form-control custom-input" type="number" step="0.01" placeholder="Precio de venta" id="modal-prev" name="prev" required>
									</div>

									<div class="textbox d-flex align-items-center">
										<i class="fas fa-box"></i>
										<select class="form-control custom-input" id="modal-tipo" name="tipo" required>
											<option value="">Selecciona Tipo</option>
											<option value="Cabeza">Cabeza</option>
											<option value="Pies">Pies</option>
											<option value="Torso">Torso</option>
											<option value="ArmaPrimaria">Arma Primaria</option>
											<option value="ArmaSecundaria">Arma Secundaria</option>
										</select>
									</div>

									<div class="textbox d-flex align-items-center">
										<i class="fas fa-star"></i>
										<select class="form-control custom-input" id="modal-rareza" name="rareza" required>
											<option value="">Selecciona Rareza</option>
											<option value="Comun">Común</option>
											<option value="Rara">Rara</option>
											<option value="Epica">Épica</option>
											<option value="Legendaria">Legendaria</option>
										</select>
									</div>

									<div class="textbox d-flex align-items-center">
										<i class="fas fa-image"></i>
										<input type="text" class="form-control custom-input" placeholder="URL de la imagen" id="modal-image" name="image">
									</div>

									<div class="textbox d-flex align-items-center">
										<i class="fas fa-align-left"></i>
										<textarea class="form-control custom-input" placeholder="Descripción" id="modal-desc" name="descripcion"></textarea>
									</div>

									<div class="alert"></div>
									<input class="btn boton-s" type="submit" value="Modificar">
								</form>
							</div>
						</div>

						<div id="modal-detalles" class="modal">
							<div class="modal-content input">
								<span class="close" onclick="closeModal('modal-detalles')">&times;</span>
								<h2>DETALLES DEL PRODUCTO</h2>

								<p><strong>Tipo:</strong> <span id="det-tipo"></span></p>
								<p><strong>Rareza:</strong> <span id="det-rareza"></span></p>
								<p><strong>Descripción:</strong> <span id="det-descripcion"></span></p>
								<p><strong>Imagen:</strong> <br> <img id="det-image" src="" width="100"></p>

								<h3>Estadísticas</h3>
								<ul>
									<li>Vida: <span id="det-vida"></span></li>
									<li>Ataque: <span id="det-ataque"></span></li>
									<li>Defensa: <span id="det-defensa"></span></li>
									<li>Suerte: <span id="det-suerte"></span></li>
									<li>Velocidad: <span id="det-velocidad"></span></li>
									<li>Resistencia: <span id="det-resistencia"></span></li>
									<li>Efectividad: <span id="det-efectividad"></span></li>
								</ul>
							</div>
						</div>


					</table>
				</div>
			</div>
		</div>
	</div>

<script>
	function openModalModificar(id, nombre, tipo, stock, precio, rareza, image, descripcion) {
		document.getElementById('modal-id').value = id;
		document.getElementById('modal-nomp').value = nombre;
		document.getElementById('modal-tipo').value = tipo;
		document.getElementById('modal-stoc').value = stock;
		document.getElementById('modal-prev').value = precio;
		document.getElementById('modal-rareza').value = rareza;
		document.getElementById('modal-image').value = image;
		document.getElementById('modal-desc').value = descripcion;

		document.getElementById('modal-modificar').style.display = 'block';
	}

	function openModalDetalles(id) {
		fetch(`obtener_detalles.php?id=${id}`)
		.then(response => response.json())
		.then(data => {
			if (data.error) {
				console.error('Error:', data.error);
				alert('No se pudo cargar el producto');
				return;
			}

			// Verifica que los datos contengan lo esperado
			console.log('Datos del producto:', data);
			document.getElementById('det-tipo').innerText = data.tipo || "No disponible";
			document.getElementById('det-rareza').innerText = data.rareza || "No disponible";
			document.getElementById('det-descripcion').innerText = data.descripcion || "No disponible";
			document.getElementById('det-image').src = data.image || "No disponible";

			// Asigna los valores de los detalles al modal
			document.getElementById('det-vida').innerText = data.vida || 'No disponible';
			document.getElementById('det-ataque').innerText = data.ataque || 'No disponible';
			document.getElementById('det-defensa').innerText = data.defensa || 'No disponible';
			document.getElementById('det-suerte').innerText = data.suerte || 'No disponible';
			document.getElementById('det-velocidad').innerText = data.velocidad || 'No disponible';
			document.getElementById('det-resistencia').innerText = data.resistencia || 'No disponible';
			document.getElementById('det-efectividad').innerText = data.efectividad || 'No disponible';

			// Muestra el modal con los detalles
			document.getElementById('modal-detalles').style.display = 'block';
		})
		.catch(error => {
			console.error('Error al obtener los detalles:', error);
			alert('Hubo un problema al cargar los detalles');
		});
	}



	function closeModal(id) {
		document.getElementById(id).style.display = 'none';
	}



</script>

    
</body>
</html>