<?php
session_start();
require_once 'config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Conexión fallida: ' . $conn->connect_error]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['key'], $_POST['content'])) {
    $key = $_POST['key'];
    $content = $_POST['content'];

    $sql = "UPDATE home SET texto = ? WHERE identifier = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $content, $key);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Datos actualizados']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al guardar el contenido']);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
}

$conn->close();
?>
