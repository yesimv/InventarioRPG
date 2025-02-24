<?php
require '../php/conexionbd.php';
$mensajee = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar que el ID del producto esté presente
    if (isset($_POST['idreg']) && !empty($_POST['idreg'])) {
        $idreg = $_POST['idreg'];
        
        // Verificar si el producto existe
        $query = "SELECT * FROM inventario WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $idreg);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Si existe, eliminarlo
            $deleteQuery = "DELETE FROM inventario WHERE id = ?";
            $deleteStmt = $conn->prepare($deleteQuery);
            $deleteStmt->bind_param("i", $idreg);

            if ($deleteStmt->execute()) {
                $mensajee = "Producto eliminado exitosamente.";
            } else {
                $mensajee = "Error al eliminar el producto.";
            }
            $deleteStmt->close();
        } else {
            $mensajee = "El producto con ID $idreg no existe.";
        }
        $stmt->close();
    } else {
        $mensajee = "Por favor, ingresa un ID válido.";
    }

    $conn->close();
    // Redirigir con mensaje
    header("Location: index.php?mensajee=" . urlencode($mensajee));
    exit;
}
?>
