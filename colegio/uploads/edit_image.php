<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../home.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nombre_imagen = $_POST["nombre_imagen"];

    $host = "localhost";
    $dbname = "escuel36_main";
    $username = "escuel36_admin";
    $password = "NVJd8f2Ae6^M";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("UPDATE galeria SET nombre_imagen = :nombre_imagen WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre_imagen', $nombre_imagen);
        $stmt->execute();

        $_SESSION['mensaje'] = "Imagen actualizada con éxito.";
    } catch (PDOException $e) {
        die("Error al conectar a la base de datos: " . $e->getMessage());
    }
}

header("Location: list_images.php");
exit();
?>
