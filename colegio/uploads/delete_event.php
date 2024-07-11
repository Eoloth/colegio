<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.html");
    exit();
}

require_once 'config.php';

if (isset($_GET['id'])) {
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
