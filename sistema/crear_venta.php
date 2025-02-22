<?php
	$alert = '';
	session_start();
	if (empty($_SESSION['active'])) {
		header('location: ../');
	}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transacción</title>
    <link rel="icon" href="../images/runa-icon.png">
	<!-- <link rel="stylesheet" href="../styles/style.css"> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<style>
		
	body {
		font-family: 'Montserrat', sans-serif;
		background-color: #141414; 
		color: #7fddea;
		background-image: url('../images/Inner-shop.webp');
		background-repeat: no-repeat;
		background-attachment: fixed;
		background-position: bottom center; 
		
        height: 100vh;
	}
	
	/* Ejemplo de uso con variables */
	h1, h2, h3 {
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
        color: white;
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
            <button type="button" class="btn boton-s" onclick="window.location.href='index.php'" >Inventario</button>
            <button type="button" class="btn boton-s active" onclick="window.location.href='crear_venta.php'" aria-pressed="true">Transacción</button>
            
        </div>
        <div class="col-4 text-end">
            <button type="button" class="btn boton" onclick="window.location.href='../php/salir.php'">Cerrar sesión</button>
        </div>
    </div>
</div>
<div class="container text-center py-4">
		<div class="row row-cols-auto justify-content-evenly">
			<div class="col  cuadro-oscuro shadow rounded my-4">
                <u><p>SELECCIONAR PRODUCTOS</p></u>

                <!-- Filtro de búsqueda -->
                 <div class="textbox d-flex align-items-center ">
                    <input class="form-control custom-input" type="text" id="buscar" placeholder="Buscar por nombre o ID">
                    <button class="btn boton-s mx-2" id="btnBuscar">Buscar</button>
                </div>
                <!-- Resultados de búsqueda -->
                <table border="1" id="tablaResultados">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Stock</th>
                            <th>Precio</th>
                            
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="col  cuadro-oscuro shadow rounded my-4">
                <!-- Productos seleccionados -->
                <u><p>PRODUCTOS SELECCIONADOS</p></u>
                <table border="1" id="tablaVenta">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Precio Unitario</th>
                            <th>Cantidad</th>
                            <th>Total por Producto</th>
                           
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

                <p class="my-4">TOTAL GENERAL: $<span id="totalGeneral">0.00</span></p>
                <button class="btn boton-s mx-2" id="btnConfirmar">Confirmar Transacción</button>
            </div>
            </div>
            </div>
    <script>
        let productosSeleccionados = [];
        let totalGeneral = 0;

        // Buscar productos
        $("#btnBuscar").click(function () {
            const buscar = $("#buscar").val();
            $.get("buscar_producto.php", { buscar }, function (data) {
                const productos = JSON.parse(data);
                const tbody = $("#tablaResultados tbody");
                tbody.empty();

                productos.forEach(producto => {
                    tbody.append(`
                        <tr>
                            <td>${producto.id}</td>
                            <td>${producto.nombre_producto}</td>
                            <td>${producto.stock}</td>
                            <td>${producto.precio_venta}</td>
                            <td>
    <button  class="btn boton-s mx-2" onclick="agregarProducto({ 
        id: ${producto.id}, 
        nombre_producto: '${producto.nombre_producto}', 
        precio_venta: ${producto.precio_venta}, 
        stock: ${producto.stock} 
    })">Agregar</button>
</td>

                        </tr>
                    `);
                });
            });
        });

        // Agregar producto a la tabla de venta
        function agregarProducto(producto) {
    // Verificar si el producto ya está en la lista
    if (productosSeleccionados.some(p => p.id_producto === producto.id)) {
        alert("El producto ya está en la venta.");
        return;
    }

    // Agregar el producto al arreglo
    productosSeleccionados.push({
        id_producto: producto.id, // ID del producto
        nombre: producto.nombre_producto, // Nombre del producto
        precio_unitario: parseFloat(producto.precio_venta), // Precio unitario
        cantidad: 1, // Cantidad inicial
        stock: parseInt(producto.stock), // Stock disponible
        total_producto: parseFloat(producto.precio_venta) // Total por producto (precio_unitario * cantidad)
    });

    // Actualizar la tabla de venta
    actualizarTablaVenta();
}

        // Actualizar tabla de venta
        function actualizarTablaVenta() {
            const tbody = $("#tablaVenta tbody");
            tbody.empty();
            totalGeneral = 0;

            productosSeleccionados.forEach((producto, index) => {
                totalGeneral += producto.total_producto;
                tbody.append(`
                    <tr>
                        <td>${producto.id_producto}</td>
                        <td>${producto.nombre}</td>
                        <td>${producto.precio_unitario}</td>
                        <td>
                            <input class="form-control custom-input"   type="number" value="${producto.cantidad}" min="1" max="${producto.stock}" onchange="actualizarCantidad(${index}, this.value)">
                        </td>
                        <td>${producto.total_producto.toFixed(2)}</td>
                        <td><button  class="btn boton-s mx-2" onclick="eliminarProducto(${index})">Eliminar</button></td>
                    </tr>
                `);
            });

            $("#totalGeneral").text(totalGeneral.toFixed(2));
        }

        // Actualizar cantidad de un producto
        function actualizarCantidad(index, cantidad) {
            const producto = productosSeleccionados[index];
            producto.cantidad = parseInt(cantidad);
            producto.total_producto = producto.cantidad * producto.precio_unitario;
            actualizarTablaVenta();
        }

        // Eliminar producto de la venta
        function eliminarProducto(index) {
            productosSeleccionados.splice(index, 1);
            actualizarTablaVenta();
        }

        // Confirmar y registrar la venta
        $("#btnConfirmar").click(function () {
            if (productosSeleccionados.length === 0) {
                alert("No hay productos seleccionados.");
                return;
            }

            $.post("registrar_venta.php", {
                productos: JSON.stringify(productosSeleccionados),
                total_final: totalGeneral
            }, function (response) {
                alert(response);
                location.reload();
            });
        });
    </script>
</body>
</html>
