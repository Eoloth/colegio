<?php
session_start();
require_once 'config.php';

header('Content-Type: application/json');

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['usuario'])) {
    echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
    exit;
}

// Conexión a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Conexión fallida: ' . $conn->connect_error]);
    exit;
}

// Procesar la solicitud
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $key = $_POST['key'];
    $content = $_POST['content'];

    // Verificar si el campo es un año
    if (strpos($key, '_year') !== false) {
        $year = intval($content);
        $identifier = str_replace('_year', '', $key);
        $sql = "UPDATE home SET year = ? WHERE identifier = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('is', $year, $identifier);
    } else {
        // Actualizar el contenido del texto
        $sql = "UPDATE home SET texto = ? WHERE identifier = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $content, $key);
    }

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al guardar el contenido']);
    }
    $stmt->close();
}

$conn->close();
?>
