<?php
include '../php/conexionbd.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productos = json_decode($_POST['productos'], true); // Array de productos
    $total_final = $_POST['total_final'];
    $fecha = date('Y-m-d H:i:s');

    // Insertar en la tabla "ventas"
    $sql_venta = "INSERT INTO ventas (fecha, total_final) VALUES (?, ?)";
    $stmt_venta = $conn->prepare($sql_venta);
    $stmt_venta->bind_param("sd", $fecha, $total_final);
    $stmt_venta->execute();
    $id_venta = $stmt_venta->insert_id;

    // Insertar en "detalle_venta"
    $sql_detalle = "INSERT INTO detalle_ventas (id_venta, id_producto, cantidad, precio_unitario, total_producto) VALUES (?, ?, ?, ?, ?)";
    $stmt_detalle = $conn->prepare($sql_detalle);

    foreach ($productos as $producto) {
        $stmt_detalle->bind_param(
            "iiidd",
            $id_venta,
            $producto['id_producto'],
            $producto['cantidad'],
            $producto['precio_unitario'],
            $producto['total_producto']
        );
        $stmt_detalle->execute();
    }

    echo "Venta registrada con éxito";

    // Cerrar conexiones
    $stmt_detalle->close();
    $stmt_venta->close();
    $conn->close();
}
?>
