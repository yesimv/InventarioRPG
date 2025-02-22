<?php
include '../php/conexionbd.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_producto = $_POST['nombre_producto'];
    $stock = $_POST['stock'];
    $precio_venta = $_POST['precio_venta'];
    var_dump($_POST);

    // Preparar y ejecutar la consulta
    $sql = "INSERT INTO inventario (nombre_producto, stock, precio_venta) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sid", $nombre_producto, $stock, $precio_venta);

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

