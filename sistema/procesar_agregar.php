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
    $stats = $_POST['stats'];

    var_dump($_POST['stats']);

    // Preparar y ejecutar la consulta
    $sql = "INSERT INTO inventario (nombre_producto, stock, precio_venta, tipo, descripcion, rareza, image) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sidssss", $nombre_producto, $stock, $precio_venta, $tipo_equipo, $descripcion_equipo, $rareza_equipo, $imagen_equipo);

    if ($stmt->execute()) {

        $inventario_id = $conn->insert_id;

        $sql_stats = "INSERT INTO stats (inventario_id, vida, ataque, defensa, suerte, velocidad, resistencia, efectividad) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_stats = $conn->prepare($sql_stats);
        list($vida, $ataque, $defensa, $suerte, $velocidad, $resistencia, $efectividad) = $stats;
        $stmt_stats->bind_param("iiiiiiii", $inventario_id, $vida, $ataque, $defensa, $suerte, $velocidad, $resistencia, $efectividad);

        if ($stmt_stats->execute()) {
        } else {
            $mensaje = "Error al insertar estadísticas: " . $stmt_stats->error;
        }

        $stmt_stats->close();
        
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

