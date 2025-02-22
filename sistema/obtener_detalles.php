<?php
include '../php/conexionbd.php';  // Ruta correcta a tu archivo de conexión

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM inventario i LEFT JOIN stats s ON i.id = s.inventario_id WHERE i.id = ?";
    $stmt = $conexion->prepare($query);  // Aquí ya debería estar la conexión
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $producto = $resultado->fetch_assoc();
        echo json_encode($producto);
    } else {
        echo json_encode(["error" => "Producto no encontrado"]);
    }
} else {
    echo json_encode(["error" => "ID no especificado"]);
}
?>
