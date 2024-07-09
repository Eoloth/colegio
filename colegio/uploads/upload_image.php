<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.html");
    exit();
}

require_once 'config.php';

try {
    // Conexión a la base de datos
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['images'])) {
        $total = count($_FILES['images']['name']);
        for ($i = 0; $i < $total; $i++) {
            $tmpFilePath = $_FILES['images']['tmp_name'][$i];
            if ($tmpFilePath != "") {
                $nombre_archivo = $_FILES['images']['name'][$i];
                $imagen = file_get_contents($tmpFilePath);
                $stmt = $conn->prepare("INSERT INTO galeria (nombre_archivo, imagen) VALUES (:nombre_archivo, :imagen)");
                $stmt->bindParam(':nombre_archivo', $nombre_archivo);
                $stmt->bindParam(':imagen', $imagen, PDO::PARAM_LOB);
                $stmt->execute();
            }
        }
        $_SESSION['mensaje'] = "Imágenes subidas con éxito.";
        header("Location: list_images.php");
        exit();
    }
} catch (PDOException $e) {
    $_SESSION['mensaje'] = "Error al conectar a la base de datos.";
    header("Location: list_images.php");
    exit();
}
?>
