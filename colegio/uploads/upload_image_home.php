<?php
session_start();
require_once 'config.php';

// Conexión a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imageFile'])) {
    $targetDir = "uploads/"; // Carpeta de destino
    $targetFile = $targetDir . basename($_FILES["imageFile"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Verificar si el archivo es una imagen real o un falso
    $check = getimagesize($_FILES["imageFile"]["tmp_name"]);
    if ($check !== false) {
        echo "El archivo es una imagen - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "El archivo no es una imagen.";
        $uploadOk = 0;
    }

    // Verificar si el archivo ya existe
    if (file_exists($targetFile)) {
        echo "Lo siento, el archivo ya existe.";
        $uploadOk = 0;
    }

    // Limitar el tamaño del archivo
    if ($_FILES["imageFile"]["size"] > 500000) { // 500 KB
        echo "Lo siento, tu archivo es demasiado grande.";
        $uploadOk = 0;
    }

    // Limitar los formatos permitidos
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "Lo siento, solo se permiten archivos JPG, JPEG y PNG.";
        $uploadOk = 0;
    }

    // Verificar si $uploadOk está establecido en 0 por un error
    if ($uploadOk == 0) {
        echo "Lo siento, tu archivo no fue subido.";
    } else {
        if (move_uploaded_file($_FILES["imageFile"]["tmp_name"], $targetFile)) {
            echo "El archivo " . basename($_FILES["imageFile"]["name"]) . " ha sido subido.";

            // Guardar el nombre del archivo en la base de datos si es necesario
            $sql = "UPDATE home SET imagen='" . $conn->real_escape_string(basename($_FILES["imageFile"]["name"])) . "' WHERE identifier='bienvenida_imagen'";
            if ($conn->query($sql) === TRUE) {
                echo "Imagen actualizada en la base de datos.";
            } else {
                echo "Error al actualizar la base de datos: " . $conn->error;
            }
        } else {
            echo "Lo siento, hubo un error al subir tu archivo.";
        }
    }
}

$conn->close();
?>
