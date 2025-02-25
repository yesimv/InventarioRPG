<?php
require '../php/conexionbd.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['idp'];
    $nombre = $_POST['nomp'];
    $stock = $_POST['stoc'];
    $precio = $_POST['prev'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $rareza = $_POST['rareza'];
    $imagen = $_POST['image'];
    $stats = $_POST['stats'];

    $sql = "UPDATE inventario SET nombre_producto = ?, stock = ?, precio_venta = ?, tipo = ?, descripcion = ?, rareza = ?, image = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sidssssi", $nombre, $stock, $precio, $tipo, $descripcion, $rareza, $imagen, $id);

    if ($stmt->execute()) {

        $sql_stats = "UPDATE stats s SET vida = ?, ataque = ?, defensa = ?, suerte = ?, velocidad = ?, resistencia = ?, efectividad = ? WHERE s.inventario_id = ?";
        $stmt_stats = $conn->prepare($sql_stats);
        list($vida, $ataque, $defensa, $suerte, $velocidad, $resistencia, $efectividad) = $stats;
        $stmt_stats->bind_param("iiiiiiii", $vida, $ataque, $defensa, $suerte, $velocidad, $resistencia, $efectividad, $id);

        if ($stmt_stats->execute()) {
        } else {
            $mensaje = "Error al insertar estadísticas: " . $stmt_stats->error;
        }

        $stmt_stats->close();

        header('Location: index.php?mensajem=Producto modificado exitosamente');
    } else {
        echo "Error al modificar: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
