<?php
session_start();
require_once 'config.php';

header('Content-Type: application/json; charset=UTF-8');

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

// Procesar la solicitud
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['key']) && isset($_POST['content'])) {
        $key = $_POST['key'];
        $content = $_POST['content'];

        // Asegúrate de que los datos no estén vacíos
        if (empty($key) || empty($content)) {
            echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
            exit();
        }

        // Asegurarse de que el contenido esté en UTF-8 y sanitizado
        $content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');

        // Manejar los campos específicos para 'about'
        $sql = "UPDATE about SET texto = ? WHERE identifier = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $content, $key);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Datos actualizados']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al guardar el contenido: ' . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    }
}

$conn->close();
?>
