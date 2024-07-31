<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../about.php");
    exit();
}

require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = $_POST['identifier'];
    $texto = $_POST['texto'];

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        $_SESSION['mensaje'] = "Conexión fallida: " . $conn->connect_error;
        header("Location: ../about.php?edit=true");
        exit();
    }

    // Establecer el charset a UTF-8
    if (!$conn->set_charset("utf8")) {
        $_SESSION['mensaje'] = "Error al cargar el conjunto de caracteres utf8: " . $conn->error;
        header("Location: ../about.php?edit=true");
        exit();
    }

    $stmt = $conn->prepare("UPDATE about SET texto = ? WHERE identifier = ?");
    $stmt->bind_param('ss', $texto, $identifier);
    
    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "El texto ha sido actualizado.";
    } else {
        $_SESSION['mensaje'] = "Error al actualizar el texto.";
    }
    
    $stmt->close();
    $conn->close();
} else {
    $_SESSION['mensaje'] = "Solicitud no válida.";
}

header("Location: ../about.php?edit=true");
exit();
