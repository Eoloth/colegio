<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../home.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['imagen'])) {
    $nombre_imagen = $_FILES['imagen']['name'];
    $tipo_imagen = $_FILES['imagen']['type'];
    $tamaño_imagen = $_FILES['imagen']['size'];
    $carpeta_destino = "../uploads/imagenes/";

    if ($tamaño_imagen <= 1000000) { // tamaño máximo 1MB
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $carpeta_destino . $nombre_imagen)) {
            $host = "localhost";
            $dbname = "escuel36_main";
            $username = "escuel36_admin";
            $password = "NVJd8f2Ae6^M";

            try {
                $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $conn->prepare("INSERT INTO galeria (nombre_imagen, tipo_imagen, tamaño_imagen) VALUES (:nombre_imagen, :tipo_imagen, :tamaño_imagen)");
                $stmt->bindParam(':nombre_imagen', $nombre_imagen);
                $stmt->bindParam(':tipo_imagen', $tipo_imagen);
                $stmt->bindParam(':tamaño_imagen', $tamaño_imagen);
                $stmt->execute();

                $_SESSION['mensaje'] = "Imagen subida con éxito.";
            } catch (PDOException $e) {
                die("Error al conectar a la base de datos: " . $e->getMessage());
            }
        }
    } else {
        $_SESSION['mensaje'] = "La imagen es demasiado grande.";
    }
}

header("Location: list_images.php");
exit();
?>
