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

    // Verificar si el campo es para noticias
    if ($key === 'noticias') {
        $sql = "UPDATE home SET noticias = ? WHERE identifier = 'noticias'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $content);
    } else {
        // Para otros campos que no sean noticias, manejar según corresponda
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
