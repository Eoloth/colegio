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

// Procesar la solicitud
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['key']) && !empty($_POST['content'])) {
        $key = trim($_POST['key']);
        $content = trim($_POST['content']);

        if ($key === 'noticias') {
            $sql = "UPDATE home SET texto = ? WHERE identifier = 'noticias'";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta']);
                exit();
            }
            $stmt->bind_param('s', $content);
        } else {
            // Manejar otros campos
            $sql = "UPDATE home SET texto = ? WHERE identifier = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta']);
                exit();
            }
            $stmt->bind_param('ss', $content, $key);
        }

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Datos actualizados']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al guardar el contenido: ' . $stmt->error]);
        }

        $stmt->close();
    } elseif (!empty($_FILES['imagen_principal']['name'])) {
        // Procesar la actualización de la imagen principal
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["imagen_principal"]["name"]);

        if (move_uploaded_file($_FILES["imagen_principal"]["tmp_name"], $target_file)) {
            // Actualizar la base de datos con la nueva imagen
            $sql = "UPDATE home SET imagen_principal = ? WHERE id = 1";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta']);
                exit();
            }
            $stmt->bind_param('s', basename($_FILES["imagen_principal"]["name"]));

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Imagen principal actualizada']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al guardar la imagen: ' . $stmt->error]);
            }

            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al subir la imagen']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos o vacíos']);
    }
}

$conn->close();
?>
