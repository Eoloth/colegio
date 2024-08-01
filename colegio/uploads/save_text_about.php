<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../about.php");
    exit();
}

require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $key = $_POST['key'];
    $content = $_POST['content'];

    // Conexión a la base de datos
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        echo json_encode(['status' => 'error', 'message' => 'Conexión fallida: ' . $conn->connect_error]);
        exit();
    }

    // Establecer el charset a UTF-8
    if (!$conn->set_charset("utf8")) {
        echo json_encode(['status' => 'error', 'message' => 'Error al cargar el conjunto de caracteres utf8: ' . $conn->error]);
        exit();
    }

    // Preparar la declaración para actualizar la base de datos
    $stmt = $conn->prepare("UPDATE about SET texto = ? WHERE identifier = ?");
    $stmt->bind_param('ss', $content, $key);
    
    // Ejecutar la declaración y verificar el resultado
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el texto.']);
    }
    
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Solicitud no válida.']);
    exit();
}
?>
