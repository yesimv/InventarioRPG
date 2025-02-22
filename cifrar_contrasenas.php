<?php
require 'php/conexionbd.php'; // Conexión a la base de datos

// Consulta para obtener todas las contraseñas en texto plano
$query = "SELECT id, password FROM usuarios";
$result = mysqli_query($conn, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $plain_password = $row['password'];

        // Cifrar la contraseña con password_hash()
        $hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);

        // Actualizar la base de datos con la contraseña cifrada
        $update_query = "UPDATE usuarios SET password = '$hashed_password' WHERE id = $id";
        mysqli_query($conn, $update_query);
    }
    echo "Contraseñas cifradas correctamente.";
} else {
    echo "Error al obtener las contraseñas: " . mysqli_error($conn);
}
?>
