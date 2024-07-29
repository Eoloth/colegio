<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../home.php");
    exit();
}

require_once 'config.php';

function resizeImage($file, $width, $height) {
    list($originalWidth, $originalHeight) = getimagesize($file);
    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($width, $height);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $originalWidth, $originalHeight);
    imagejpeg($dst, $file); // Sobrescribe la imagen original
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['imagenes'])) {
    $seccion = $_POST['seccion'];
    $total = count($_FILES['imagenes']['name']);

    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        for ($i = 0; $i < $total; $i++) {
            $tmpFilePath = $_FILES['imagenes']['tmp_name'][$i];
            if ($tmpFilePath != "") {
                $nombre_archivo = basename($_FILES['imagenes']['name'][$i]);
                $target_file = "../uploads/" . $nombre_archivo;
                
                if (move_uploaded_file($tmpFilePath, $target_file)) {
                    // Redimensionar la imagen a los tamaños adecuados
                    resizeImage($target_file, 1200, 800); // Ejemplo de tamaño

                    $stmt = $conn->prepare("UPDATE home SET imagen = :imagen WHERE seccion = :seccion");
                    $stmt->bindParam(':imagen', $nombre_archivo);
                    $stmt->bindParam(':seccion', $seccion);
                    $stmt->execute();
                } else {
                    $_SESSION['mensaje'] = "Error al subir la imagen: $nombre_archivo";
                    header("Location: ../home.php?edit=true");
                    exit();
                }
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
