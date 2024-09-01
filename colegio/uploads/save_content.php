<?php
session_start();
require_once 'config.php';

header('Content-Type: application/json');

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['usuario'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
    exit;
}

// Conexión a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Conexión fallida: ' . $conn->connect_error]);
    exit;
}

// Procesar la solicitud
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $key = isset($_POST['key']) ? trim($_POST['key']) : '';
    $content = isset($_POST['content']) ? trim($_POST['content']) : '';

    // Validar entradas
    if (empty($key) || empty($content)) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Campos vacíos o inválidos']);
        exit;
    }

    if ($key === 'noticias') {
        $sql = "UPDATE home SET noticias = ? WHERE identifier = 'noticias'";
    } else {
        $sql = "UPDATE home SET texto = ? WHERE identifier = ?";
    }

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Error en la preparación de la consulta: ' . $conn->error]);
        exit;
    }

    if ($key === 'noticias') {
        $stmt->bind_param('s', $content);
    } else {
        $stmt->bind_param('ss', $content, $key);
    }

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Error al guardar el contenido: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
}

$conn->close();
?>
