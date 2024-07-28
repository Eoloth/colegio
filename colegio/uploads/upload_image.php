<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../home.php");
    exit();
}

require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['imagenes'])) {
    $nombres = $_POST['nombres'];
    $descripciones = $_POST['descripciones'];
    
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
                    $descripcion = $descripciones[$i];
                    $stmt = $conn->prepare("INSERT INTO galeria (nombre_archivo, descripcion) VALUES (:nombre_archivo, :descripcion)");
                    $stmt->bindParam(':nombre_archivo', $nombre_archivo);
                    $stmt->bindParam(':descripcion', $descripcion);
                    $stmt->execute();
                } else {
                    $_SESSION['mensaje'] = "Error al subir la imagen: $nombre_archivo";
                    header("Location: upload_image_form.php");
                    exit();
                }
            }
        }

        $_SESSION['mensaje'] = "Las imágenes se han subido correctamente.";
        header("Location: list_images.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['mensaje'] = "Error al conectar a la base de datos.";
        header("Location: upload_image_form.php");
        exit();
    }
} else {
    $_SESSION['mensaje'] = "No se seleccionaron imágenes.";
    header("Location: upload_image_form.php");
    exit();
}
?>
