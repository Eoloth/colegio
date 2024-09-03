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

$response = ['success' => false, 'message' => 'Error desconocido']; // Variable para almacenar la respuesta

// Procesar la solicitud para home.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['key']) && !empty($_POST['content'])) {
        $key = trim($_POST['key']);
        $content = trim($_POST['content']);

        // Asegurarse de que el contenido esté en UTF-8
        $content = mb_convert_encoding($content, 'UTF-8', 'auto');

        // Manejar campos para home.php
        $sql = "UPDATE home SET texto = ? WHERE identifier = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            $response['message'] = 'Error en la preparación de la consulta';
        } else {
            $stmt->bind_param('ss', $content, $key);

            if ($stmt->execute()) {
                $response = ['success' => true, 'message' => 'Datos actualizados'];
            } else {
                $response['message'] = 'Error al guardar el contenido: ' . $stmt->error;
            }

            $stmt->close();
        }
    } elseif (!empty($_FILES['imagen_principal']['name'])) {
        // Procesar la carga de la imagen principal
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["imagen_principal"]["name"]);

        // Verificar si se recibió el archivo y su ruta temporal
        error_log("Archivo recibido: " . $_FILES["imagen_principal"]["name"]);
        error_log("Ruta temporal: " . $_FILES["imagen_principal"]["tmp_name"]);

        if (move_uploaded_file($_FILES["imagen_principal"]["tmp_name"], $target_file)) {
            error_log("Archivo movido a: " . $target_file);
            // Actualizar la base de datos con la nueva imagen
            $sql = "UPDATE home SET imagen_principal = ? WHERE identifier = 'noticias'";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                $response['message'] = 'Error en la preparación de la consulta';
            } else {
                $stmt->bind_param('s', basename($_FILES["imagen_principal"]["name"]));

                if ($stmt->execute()) {
                    $response = ['success' => true, 'message' => 'Imagen principal actualizada'];
                } else {
                    $response['message'] = 'Error al guardar la imagen: ' . $stmt->error;
                }

                $stmt->close();
            }
        } else {
            $response['message'] = 'Error al mover el archivo subido.';
            error_log("Error al mover el archivo: " . $_FILES["imagen_principal"]["name"]);
        }
    } else {
        $response['message'] = 'No se recibió ningún archivo o hubo un error en la subida.';
        error_log("Error en la subida: " . $_FILES['imagen_principal']['error']);
    }
}

$conn->close();

// Devolver la respuesta en JSON
echo json_encode($response);
