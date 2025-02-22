<?php
require 'php/conexionbd.php'; // Conexión a la base de datos

// Consulta para obtener todos los productos con la ruta de la imagen actual
$query = "SELECT id, image FROM inventario";
$result = mysqli_query($conn, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $image_path = $row['image'];

        // Nueva ruta completa
        $new_image_path = 'http://localhost/InventarioRPG/' . $image_path;

        // Actualizar la base de datos con la nueva ruta
        $update_query = "UPDATE inventario SET image = '$new_image_path' WHERE id = $id";
        mysqli_query($conn, $update_query);
    }
    echo "Rutas de las imágenes actualizadas correctamente.";
} else {
    echo "Error al obtener las rutas de las imágenes: " . mysqli_error($conn);
}
?>
