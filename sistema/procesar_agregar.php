<?php
include '../php/conexionbd.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $nombre_producto = $_POST['nombre_producto'];
    $stock = $_POST['stock'];
    $precio_venta = $_POST['precio_venta'];
    $tipo_equipo = $_POST['tipo'];
    $descripcion_equipo = $_POST['descripcion'];
    $rareza_equipo = $_POST['rareza'];
    $imagen_equipo = $_POST['image'];
    var_dump($_POST);

    // Preparar y ejecutar la consulta
    $sql = "INSERT INTO inventario (nombre_producto, stock, precio_venta, tipo, descripcion, rareza, image) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sidssss", $nombre_producto, $stock, $precio_venta, $tipo_equipo, $descripcion_equipo, $rareza_equipo, $imagen_equipo);

    if ($stmt->execute()) {
        $mensaje = "Producto agregado exitosamente.";
    } else {
        echo "Error en la consulta: " . $stmt->error;
    }

    // Cerrar conexión
    $stmt->close();
    $conn->close();
}

// Pasar el mensaje como parámetro
header("Location: index.php?mensaje=" . urlencode($mensaje));
exit;
?>

