<?php
session_start();
require_once 'config.php';

header('Content-Type: application/json');

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit();
}

// Conexión a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Conexión fallida: ' . $conn->connect_error]);
    exit();
}

// Establecer el charset a utf8mb4
$conn->set_charset("utf8mb4");

// Procesar la solicitud para home.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['key']) && isset($_POST['content'])) {
        $key = $_POST['key'];
        $content = $_POST['content'];

        // Asegurarse de que el contenido esté en UTF-8
        $content = mb_convert_encoding($content, 'UTF-8', 'auto');

        // Manejar campos para home.php
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
}

$conn->close();
?>
