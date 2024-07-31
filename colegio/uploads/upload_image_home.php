<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../home.php");
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['imagenes'])) {
    $seccion = $_POST['seccion'];
    $total = count($_FILES['imagenes']['name']);

    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        for ($i = 0; $i < $total; $i++) {
            $tmpFilePath = $_FILES['imagenes']['tmp_name'][$i];
            $type = $_FILES['imagenes']['type'][$i];
            if ($tmpFilePath != "" && in_array($type, ['image/jpeg', 'image/png'])) {
                $nombre_archivo = basename($_FILES['imagenes']['name'][$i]);
                $target_file = "../uploads/" . $nombre_archivo;

                if (move_uploaded_file($tmpFilePath, $target_file)) {
                    resizeImage($target_file, 1200, 800, $type);

                    $stmt = $conn->prepare("UPDATE home SET imagen = :imagen WHERE seccion = :seccion");
                    $stmt->bindParam(':imagen', $nombre_archivo);
                    $stmt->bindParam(':seccion', $seccion);
                    $stmt->execute();
                } else {
                    $_SESSION['mensaje'] = "Error al subir la imagen: $nombre_archivo. Error: " . $_FILES['imagenes']['error'][$i];
                    header("Location: ../home.php?edit=true");
                    exit();
                }
            } else {
                $_SESSION['mensaje'] = "Formato de imagen no permitido o archivo vacío.";
                header("Location: ../home.php?edit=true");
                exit();
            }
        }

        $_SESSION['mensaje'] = "Las imágenes se han subido correctamente.";
        header("Location: ../home.php?edit=true");
        exit();
    } catch (PDOException $e) {
        $_SESSION['mensaje'] = "Error al conectar a la base de datos.";
        header("Location: ../home.php?edit=true");
        exit();
    }
} else {
    $_SESSION['mensaje'] = "No se seleccionaron imágenes.";
    header("Location: ../home.php?edit=true");
    exit();
}

?>
