<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../home.php");
    exit();
}

require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['imagen_principal'])) {
    $tmpFilePath = $_FILES['imagen_principal']['tmp_name'];
    if ($tmpFilePath != "") {
        $nombre_archivo = basename($_FILES['imagen_principal']['name']);
        $target_file = "../uploads/" . $nombre_archivo;

        try {
            $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if (move_uploaded_file($tmpFilePath, $target_file)) {
                // Actualizar la columna 'imagen_principal' en la tabla 'home'
                $stmt = $conn->prepare("UPDATE home SET imagen_principal = :nombre_archivo WHERE identifier = 'noticias'");
                $stmt->bindParam(':nombre_archivo', $nombre_archivo);
                $stmt->execute();

                $_SESSION['mensaje'] = "La imagen se ha subido y actualizado correctamente.";
                header("Location: ../home.php");
                exit();
            } else {
                $_SESSION['mensaje'] = "Error al subir la imagen: $nombre_archivo";
                header("Location: ../home.php");
                exit();
            }
        } catch (PDOException $e) {
            $_SESSION['mensaje'] = "Error al conectar a la base de datos.";
            header("Location: ../home.php");
            exit();
        }
    } else {
        $_SESSION['mensaje'] = "No se seleccionó ninguna imagen.";
        header("Location: ../home.php");
        exit();
    }
} else {
    $_SESSION['mensaje'] = "Solicitud no válida.";
    header("Location: ../home.php");
    exit();
}
?>
