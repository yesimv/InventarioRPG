<?php
require '../php/conexionbd.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['idp'];
    $nombre = $_POST['nomp'];
    $stock = $_POST['stoc'];
    $precio = $_POST['prev'];

    $sql = "UPDATE inventario SET nombre_producto = ?, stock = ?, precio_venta = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sidi", $nombre, $stock, $precio, $id);

    if ($stmt->execute()) {
        header('Location: index.php?mensajem=Producto modificado exitosamente');
    } else {
        echo "Error al modificar: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
