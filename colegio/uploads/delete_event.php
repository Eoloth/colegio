<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../home.php");
    exit();
}

require_once 'config.php';

if (isset($_GET['id'])) {
    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Obtener la imagen del evento
        $stmt = $conn->prepare("SELECT imagen FROM eventos WHERE id = :id");
        $stmt->bindParam(':id', $_GET['id']);
        $stmt->execute();
        $evento = $stmt->fetch(PDO::FETCH_ASSOC);

        // Eliminar la imagen del servidor
        if ($evento && file_exists('../uploads/' . $evento['imagen'])) {
            unlink('../uploads/' . $evento['imagen']);
        }

        // Eliminar el evento de la base de datos
        $stmt = $conn->prepare("DELETE FROM eventos WHERE id = :id");
        $stmt->bindParam(':id', $_GET['id']);
        $stmt->execute();

        $_SESSION['mensaje'] = "Evento eliminado exitosamente.";
        header("Location: list_events.php");
        exit();
    } catch (PDOException $e) {
        die("Error al conectar a la base de datos: " . $e->getMessage());
    }
} else {
    header("Location: list_events.php");
    exit();
}
?>
