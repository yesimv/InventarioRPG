<?php
include '../php/conexionbd.php';


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Ajusta la consulta para seleccionar los campos correctos
    $query = "SELECT i.nombre_producto, i.tipo, i.rareza, i.stock, i.precio_venta, i.descripcion, 
              i.image, s.vida, s.ataque, s.defensa, s.suerte, s.velocidad, s.resistencia, s.efectividad
              FROM inventario i 
              LEFT JOIN stats s ON i.id = s.inventario_id 
              WHERE i.id = ?";
    
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $producto = $resultado->fetch_assoc();
    
    // Verifica si el producto fue encontrado
    if ($producto) {
        echo json_encode($producto);
    } else {
        // Si no se encuentra el producto, devuelve un error en JSON
        echo json_encode(["error" => "Producto no encontrado"]);
    }
}
?>
