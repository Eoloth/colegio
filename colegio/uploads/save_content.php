<?php
include 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $seccion = $_POST['seccion'];
    $content = $_POST['content'];

    // Mostrar mensaje solo en consola del servidor para depuración
    error_log("Iniciando conexión a la base de datos...");

    // Preparar la consulta para actualizar el contenido
    $query = "UPDATE home SET texto = ? WHERE seccion = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $content, $seccion);
    $stmt->execute();

    $response = array();
    if ($stmt->affected_rows > 0) {
        $response['status'] = 'success';
        $response['message'] = 'Datos guardados correctamente.';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error al guardar los datos o no hubo cambios.';
    }

    // Rescatar los datos actualizados para mostrar confirmación
    $query = "SELECT texto FROM home WHERE seccion = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $seccion);
    $stmt->execute();
    $stmt->bind_result($updated_text);
    $stmt->fetch();

    $response['data'] = htmlspecialchars($updated_text);
    $stmt->close();
    $conn->close();

    // Devolver respuesta en formato JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
