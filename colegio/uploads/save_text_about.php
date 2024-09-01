<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit();
}

require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['key']) && isset($_POST['content'])) {
        $key = $_POST['key'];
        $content = $_POST['content'];

        // Conexión a la base de datos
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            echo json_encode(['success' => false, 'message' => 'Conexión fallida: ' . $conn->connect_error]);
            exit();
        }

        // Establecer el charset a UTF-8
        if (!$conn->set_charset("utf8")) {
            echo json_encode(['success' => false, 'message' => 'Error al cargar el conjunto de caracteres utf8: ' . $conn->error]);
            exit();
        }

        // Preparar la declaración para actualizar la base de datos
        $stmt = $conn->prepare("UPDATE about SET texto = ? WHERE identifier = ?");
        $stmt->bind_param('ss', $content, $key);

        // Ejecutar la declaración y verificar el resultado
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Datos actualizados']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar el texto.']);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
        exit();
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Solicitud no válida.']);
    exit();
}
?>
