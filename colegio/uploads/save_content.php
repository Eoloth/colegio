<?php
include 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $seccion = $_POST['seccion'] ?? '';
    $content = $_POST['content'] ?? '';

    // Comprobar que los datos no estén vacíos
    if (empty($seccion) || empty($content)) {
        echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
        exit;
    }

    // Preparar la conexión
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Comprobar la conexión
    if ($conn->connect_error) {
        echo json_encode(['status' => 'error', 'message' => 'Error de conexión: ' . $conn->connect_error]);
        exit;
    }

    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare("UPDATE home SET texto = ? WHERE seccion = ?");
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Error en la preparación de la consulta: ' . $conn->error]);
        $conn->close();
        exit;
    }

    $stmt->bind_param("ss", $content, $seccion);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Datos guardados correctamente']);
        } else {
            // Determinar si fue un error o simplemente no hubo cambios
            $stmt = $conn->prepare("SELECT texto FROM home WHERE seccion = ?");
            $stmt->bind_param("s", $seccion);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows == 0) {
                echo json_encode(['status' => 'error', 'message' => 'Sección no encontrada']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'No se realizaron cambios']);
            }
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al ejecutar la consulta: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
