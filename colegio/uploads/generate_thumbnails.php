<?php
// Cargar configuración de la base de datos
require_once 'config.php';

// Definir directorios (ajustados para estar en la misma carpeta de 'uploads')
$upload_dir = __DIR__ . "/";
$thumbnail_dir = __DIR__ . "/thumbnails/";

// Crear la carpeta de miniaturas si no existe
if (!is_dir($thumbnail_dir)) {
    mkdir($thumbnail_dir, 0777, true);
    echo "Carpeta 'thumbnails' creada.\n";
}

try {
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener todas las imágenes en la carpeta de uploads
    $imagenes = glob($upload_dir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);

    foreach ($imagenes as $ruta_imagen) {
        $nombre_archivo = basename($ruta_imagen);
        $ruta_miniatura = $thumbnail_dir . $nombre_archivo;

        // Generar miniatura solo si no existe
        if (!file_exists($ruta_miniatura)) {
            list($ancho, $alto) = getimagesize($ruta_imagen);
            $nuevo_ancho = 200; // Ancho de la miniatura
            $nuevo_alto = (int)($alto * 200 / $ancho); // Mantener la proporción

            $miniatura = imagecreatetruecolor($nuevo_ancho, $nuevo_alto);
            
            // Identificar el tipo de imagen y crear desde la imagen original
            $extension = pathinfo($nombre_archivo, PATHINFO_EXTENSION);
            switch (strtolower($extension)) {
                case 'jpg':
                case 'jpeg':
                    $imagen_origen = imagecreatefromjpeg($ruta_imagen);
                    break;
                case 'png':
                    $imagen_origen = imagecreatefrompng($ruta_imagen);
                    break;
                case 'gif':
                    $imagen_origen = imagecreatefromgif($ruta_imagen);
                    break;
                default:
                    continue 2; // Saltar archivos que no sean imágenes válidas
            }

            imagecopyresampled($miniatura, $imagen_origen, 0, 0, 0, 0, $nuevo_ancho, $nuevo_alto, $ancho, $alto);
            
            // Guardar la miniatura según el tipo de imagen
            switch (strtolower($extension)) {
                case 'jpg':
                case 'jpeg':
                    imagejpeg($miniatura, $ruta_miniatura, 80);
                    break;
                case 'png':
                    imagepng($miniatura, $ruta_miniatura, 8);
                    break;
                case 'gif':
                    imagegif($miniatura, $ruta_miniatura);
                    break;
            }

            // Liberar memoria
            imagedestroy($miniatura);
            imagedestroy($imagen_origen);

            echo "Miniatura generada para $nombre_archivo\n";
        } else {
            echo "La miniatura para $nombre_archivo ya existe.\n";
        }

        // Actualizar la base de datos con la ruta de la miniatura
        // Usamos una ruta relativa para que funcione correctamente en la aplicación
        $ruta_miniatura_relativa = "uploads/thumbnails/" . $nombre_archivo;
        $stmt = $conn->prepare("UPDATE galeria SET thumbnail = :thumbnail WHERE nombre_archivo = :nombre_archivo");
        $stmt->bindParam(':thumbnail', $ruta_miniatura_relativa);
        $stmt->bindParam(':nombre_archivo', $nombre_archivo);
        $stmt->execute();
    }

    echo "Proceso completado.\n";
} catch (PDOException $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
}
?>
