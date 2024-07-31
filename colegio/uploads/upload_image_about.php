<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../about.php");
    exit();
}

require_once 'config.php';

function resizeImage($file, $width, $height, $type) {
    list($originalWidth, $originalHeight) = getimagesize($file);
    if ($type == 'image/jpeg') {
        $src = imagecreatefromjpeg($file);
    } elseif ($type == 'image/png') {
        $src = imagecreatefrompng($file);
    }
    $dst = imagecreatetruecolor($width, $height);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $originalWidth, $originalHeight);
    if ($type == 'image/jpeg') {
        imagejpeg($dst, $file); // Sobrescribe la imagen original
    } elseif ($type == 'image/png') {
        imagepng($dst, $file);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['imageFile'])) {
    $section = $_POST['section'];
    $fileName = basename($_FILES['imageFile']['name']);
    $tmpFilePath = $_FILES['imageFile']['tmp_name'];
    $type = $_FILES['imageFile']['type'];

    if ($tmpFilePath != "" && in_array($type, ['image/jpeg', 'image/png'])) {
        $targetFile = "../uploads/" . $fileName;

        if (move_uploaded_file($tmpFilePath, $targetFile)) {
            resizeImage($targetFile, 1200, 800, $type);

            try {
                $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $conn->prepare("UPDATE about SET imagen = :imagen WHERE identifier = :identifier");
                $stmt->bindParam(':imagen', $fileName);
                $stmt->bindParam(':identifier', $section);
                $stmt->execute();

                $_SESSION['mensaje'] = "La imagen se ha subido correctamente.";
            } catch (PDOException $e) {
                $_SESSION['mensaje'] = "Error al conectar a la base de datos: " . $e->getMessage();
            }
        } else {
            $_SESSION['mensaje'] = "Error al subir la imagen.";
        }
    } else {
        $_SESSION['mensaje'] = "Formato de imagen no permitido o archivo vacío.";
    }
} else {
    $_SESSION['mensaje'] = "No se seleccionaron imágenes.";
}

header("Location: ../about.php?edit=true");
exit();
?>
