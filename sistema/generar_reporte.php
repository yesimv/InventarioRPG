<?php
require '../php/conexionbd.php';
session_start();
if (empty($_SESSION['active'])) {
    header('location: ../');
}

// Función para exportar resultados a Excel
if ($_SESSION['rolus'] == 1 && isset($_GET['export'])) {
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=Inventario_" . date("Ymd") . ".xls");
    $buscar = isset($_GET['buscar']) ? $_GET['buscar'] : '';
    $stock_min = isset($_GET['stock_min']) ? $_GET['stock_min'] : '';
    $stock_max = isset($_GET['stock_max']) ? $_GET['stock_max'] : '';
    $precio_min = isset($_GET['precio_min']) ? $_GET['precio_min'] : '';
    $precio_max = isset($_GET['precio_max']) ? $_GET['precio_max'] : '';

    $sql = "SELECT * FROM inventario WHERE 1";
    if (!empty($buscar)) {
        $sql .= " AND (id LIKE '%$buscar%' OR nombre_producto LIKE '%$buscar%')";
    }
    if (!empty($stock_min) && !empty($stock_max)) {
        $sql .= " AND stock BETWEEN $stock_min AND $stock_max";
    }
    if (!empty($precio_min) && !empty($precio_max)) {
        $sql .= " AND precio_venta BETWEEN $precio_min AND $precio_max";
    }

    $result = mysqli_query($conn, $sql);
    echo "<table border='1'>";
    echo "<tr><th>ID Producto</th><th>Nombre del Producto</th><th>Stock</th><th>Precio de venta</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nombre_producto']}</td>
                <td>{$row['stock']}</td>
                <td>{$row['precio_venta']}</td>
              </tr>";
    }
    echo "</table>";
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="icon" href="../images/icono-logo.png">
    <title>Reporte</title>
    <link rel="icon" href="../images/icono-logo.png">
	<!-- <link rel="stylesheet" href="../styles/style.css"> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<style>
		
	body {
		font-family: 'Montserrat', sans-serif;
		background-color: #141414; 
		color: #eefb03;
		background-image: url('../images/banner-index.png');
		background-repeat: no-repeat;
		background-attachment: fixed;
		background-position: 5% 90% ; 
		background-size:20vw;
        overflow-x: hidden;
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
		
		background-color: #eefb03 ;
	}
	.boton:hover{
		color: #eefb03;
		background-color: #25252b ;
	}
	.boton-s{
		color: #eefb03;
		background-color: inherit;
	}
	.boton-s:hover{
		color: black;
		background-color: #eefb03 ;
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
        box-shadow: 0 0 8px rgba(238, 251, 3, 0.2); /* Efecto de sombra opcional */
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
    .busqueda{
        width: inherit !important;
        height: fit-content;
        margin-bottom:10px;

    }
    
	</style>
</head>
<body > 
<div class="cuadro-oscuro p-3 sticky-top ">
    <div class="row">
        <div class="col-8">
            <button type="button" class="btn boton-s " onclick="window.location.href='index.php'" >Productos</button>
            <button type="button" class="btn boton-s" onclick="window.location.href='crear_venta.php'">Venta</button>
            <?php
                if ($_SESSION['rolus'] == 1) {
                    echo "<button type='button' class='btn boton-s active' onclick=\"window.location.href='generar_reporte.php'\"aria-pressed='true'>Reporte</button>";
                }   
            ?>
        </div>
        <div class="col-4 text-end">
            <button type="button" class="btn boton" onclick="window.location.href='../php/salir.php'">Cerrar sesión</button>
        </div>
    </div>
</div>


    <!-- Formulario de búsqueda -->
    <form class="align-middle mx-auto py-4" method="GET" action="">
        <div class="row justify-content-center align-items-center">
        <input class="custom-input busqueda" type="text" name="buscar" placeholder="Buscar por ID o Nombre del Producto" 
            value="<?php echo isset($_GET['buscar']) ? $_GET['buscar'] : ''; ?>">
        <input class="custom-input busqueda" type="number" name="stock_min" placeholder="Stock mínimo" 
            value="<?php echo isset($_GET['stock_min']) ? $_GET['stock_min'] : ''; ?>">
        <input class="custom-input busqueda" type="number" name="stock_max" placeholder="Stock máximo" 
            value="<?php echo isset($_GET['stock_max']) ? $_GET['stock_max'] : ''; ?>">
        <input class="custom-input busqueda" type="number" name="precio_min" placeholder="Precio mínimo" 
            value="<?php echo isset($_GET['precio_min']) ? $_GET['precio_min'] : ''; ?>">
        <input class="custom-input busqueda" type="number" name="precio_max" placeholder="Precio máximo" 
            value="<?php echo isset($_GET['precio_max']) ? $_GET['precio_max'] : ''; ?>">
        <button class="btn boton-s busqueda" type="submit">Buscar</button>
        <?php if ($_SESSION['rolus'] == 1): ?>
            <a href="?export=1&<?php echo http_build_query($_GET); ?>" class="btn boton busqueda">Exportar a Excel</a>
        <?php endif; ?>
        </div>
    </form>

    <!-- Tabla de productos -->
    <div class="container text-center ">
     <div class="col cuadro-oscuro shadow rounded mx-2">
    <table style="width:100%; text-align: center;">
        <thead>
            <tr>
                <th>ID Producto</th>
                <th>Nombre del Producto</th>
                <th>Stock</th>
                <th>Precio de venta</th>
                
            </tr>
        </thead>
        <tbody>
            <?php
            // Obtener parámetros de búsqueda
            $buscar = isset($_GET['buscar']) ? $_GET['buscar'] : '';
            $stock_min = isset($_GET['stock_min']) ? $_GET['stock_min'] : '';
            $stock_max = isset($_GET['stock_max']) ? $_GET['stock_max'] : '';
            $precio_min = isset($_GET['precio_min']) ? $_GET['precio_min'] : '';
            $precio_max = isset($_GET['precio_max']) ? $_GET['precio_max'] : '';

            // Construir consulta SQL
            $sql = "SELECT * FROM inventario WHERE 1";
            if (!empty($buscar)) {
                $sql .= " AND (id LIKE '%$buscar%' OR nombre_producto LIKE '%$buscar%')";
            }
            if (!empty($stock_min) && !empty($stock_max)) {
                $sql .= " AND stock BETWEEN $stock_min AND $stock_max";
            }
            if (!empty($precio_min) && !empty($precio_max)) {
                $sql .= " AND precio_venta BETWEEN $precio_min AND $precio_max";
            }

            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['nombre_producto']}</td>
                        <td>{$row['stock']}</td>
                        <td>{$row['precio_venta']}</td>";
                
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
        
    </div>
</div>

<script>
function openModal(id, nombre, stock, precio) {
    // Implementar lógica para abrir modal
}
</script>
</body>
</html>
