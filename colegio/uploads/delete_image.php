<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../home.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nombre_imagen = $_POST["nombre_imagen"];
    $carpeta_destino = "../uploads/imagenes/";

    $host = "localhost";
    $dbname = "escuel36_main";
    $username = "escuel36_admin";
    $password = "NVJd8f2Ae6^M";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("DELETE FROM galeria WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if (file_exists($carpeta_destino . $nombre_imagen)) {
            unlink($carpeta_destino . $nombre_imagen);
        }

        $_SESSION['mensaje'] = "Imagen eliminada con éxito.";
    } catch (PDOException $e) {
        die("Error al conectar a la base de datos: " . $e->getMessage());
    }
}

header("Location: list_images.php");
exit();
?>
