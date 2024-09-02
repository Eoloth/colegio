<?php
session_start();
require_once 'config.php';

if (isset($_POST['galeria-image']) && isset($_SESSION['usuario'])) {
    $imagenSeleccionada = $_POST['galeria-image'];

    // Conexión a la base de datos
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Actualizar la imagen seleccionada en la tabla 'home' para el identificador 'noticias_imagen'
    $sql = "UPDATE home SET imagen = ? WHERE identifier = 'noticias_imagen'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $imagenSeleccionada);
    
    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Imagen de noticias actualizada exitosamente.";
        error_log("Imagen seleccionada: " . $imagenSeleccionada);
    } else {
        $_SESSION['mensaje'] = "Error al actualizar la imagen: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    header('Location: ../home.php');
    exit();
}
?>
