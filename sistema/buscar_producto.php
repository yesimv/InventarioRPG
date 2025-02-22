<?php
include '../php/conexionbd.php';

$buscar = $_GET['buscar'] ?? '';

// Consulta con filtro por `id` o `nombre_producto`
$sql = "SELECT id, nombre_producto, precio_venta, stock FROM inventario WHERE id LIKE ? OR nombre_producto LIKE ?";
$stmt = $conn->prepare($sql);
$param = "%$buscar%";
$stmt->bind_param("ss", $param, $param);
$stmt->execute();
$result = $stmt->get_result();

$productos = [];
while ($row = $result->fetch_assoc()) {
    $productos[] = $row;
}

echo json_encode($productos); // Devolver datos en formato JSON

$stmt->close();
$conn->close();
?>
