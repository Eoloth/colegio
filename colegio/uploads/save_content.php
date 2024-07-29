<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    http_response_code(403);
    echo 'Acceso no autorizado';
    exit();
}

require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $key = $_POST['key'];
    $content = $_POST['content'];

    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("UPDATE home SET content = :content WHERE key = :key");
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':key', $key);
        $stmt->execute();

        echo 'Contenido actualizado';
    } catch (PDOException $e) {
        echo 'Error al conectar a la base de datos: ' . $e->getMessage();
    }
} else {
    echo 'Método de solicitud no permitido';
}
