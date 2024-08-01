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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = $_POST['key']; // Cambiar de 'identifier' a 'key' para mantener la coherencia
    $texto = $_POST['content']; // Cambiar de 'texto' a 'content' para mantener la coherencia

    // Preparar y ejecutar la consulta SQL
    $stmt = $conn->prepare("UPDATE about SET texto = ? WHERE identifier = ?");
    $stmt->bind_param('ss', $texto, $identifier);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el texto']);
    }
    
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Solicitud no válida']);
}
?>
