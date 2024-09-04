<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../home.php");
    exit();
}

require_once 'config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Obtener el nombre del archivo para eliminarlo del servidor
        $stmt = $conn->prepare("SELECT nombre_archivo FROM galeria WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $imagen = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($imagen) {
            $filepath = '../uploads/' . $imagen['nombre_archivo'];
            if (file_exists($filepath)) {
                if (unlink($filepath)) {
                    // Eliminar la imagen de la base de datos solo si el archivo fue eliminado exitosamente
                    $stmt = $conn->prepare("DELETE FROM galeria WHERE id = :id");
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();

                    $_SESSION['mensaje'] = "Imagen eliminada con éxito.";
                } else {
                    $_SESSION['mensaje'] = "Error al eliminar la imagen del servidor.";
                }
            } else {
                $_SESSION['mensaje'] = "Error: archivo no encontrado en el servidor.";
            }
        } else {
            $_SESSION['mensaje'] = "Error: imagen no encontrada en la base de datos.";
        }
    } catch (PDOException $e) {
        $_SESSION['mensaje'] = "Error al conectar a la base de datos: " . $e->getMessage();
    }

    header("Location: list_images.php");
    exit();
} else {
    $_SESSION['mensaje'] = "Error: ID no establecido.";
    header("Location: list_images.php");
    exit();
}
?>
