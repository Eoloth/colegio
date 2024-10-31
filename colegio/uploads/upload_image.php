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
                $thumbnail_file = "../uploads/thumbnails/" . $nombre_archivo;

                // Mover la imagen original a la carpeta 'uploads'
                if (move_uploaded_file($tmpFilePath, $target_file)) {
                    // Generar miniatura
                    list($ancho, $alto) = getimagesize($target_file);
                    $nuevo_ancho = 200; // Ancho de la miniatura
                    $nuevo_alto = (int)($alto * 200 / $ancho); // Mantener la proporción

                    $miniatura = imagecreatetruecolor($nuevo_ancho, $nuevo_alto);
                    
                    // Identificar el tipo de imagen y crear desde la imagen original
                    $extension = pathinfo($nombre_archivo, PATHINFO_EXTENSION);
                    switch (strtolower($extension)) {
                        case 'jpg':
                        case 'jpeg':
                            $imagen_origen = imagecreatefromjpeg($target_file);
                            break;
                        case 'png':
                            $imagen_origen = imagecreatefrompng($target_file);
                            break;
                        case 'gif':
                            $imagen_origen = imagecreatefromgif($target_file);
                            break;
                        default:
                            continue 2; // Saltar archivos que no sean imágenes válidas
                    }

                    imagecopyresampled($miniatura, $imagen_origen, 0, 0, 0, 0, $nuevo_ancho, $nuevo_alto, $ancho, $alto);
                    
                    // Guardar la miniatura según el tipo de imagen
                    switch (strtolower($extension)) {
                        case 'jpg':
                        case 'jpeg':
                            imagejpeg($miniatura, $thumbnail_file, 80);
                            break;
                        case 'png':
                            imagepng($miniatura, $thumbnail_file, 8);
                            break;
                        case 'gif':
                            imagegif($miniatura, $thumbnail_file);
                            break;
                    }

                    // Liberar memoria
                    imagedestroy($miniatura);
                    imagedestroy($imagen_origen);

                    // Insertar en la base de datos con la ruta de la miniatura
                    $descripcion = $descripciones[$i];
                    $stmt = $conn->prepare("INSERT INTO galeria (nombre_archivo, descripcion, thumbnail) VALUES (:nombre_archivo, :descripcion, :thumbnail)");
                    $stmt->bindParam(':nombre_archivo', $nombre_archivo);
                    $stmt->bindParam(':descripcion', $descripcion);
                    $stmt->bindParam(':thumbnail', $thumbnail_file);
                    $stmt->execute();
                } else {
                    $_SESSION['mensaje'] = "Error al subir la imagen: $nombre_archivo";
                    header("Location: upload_image_form.php");
                    exit();
                }
            }
        }

        $_SESSION['mensaje'] = "Las imágenes se han subido correctamente y se generaron las miniaturas.";
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
