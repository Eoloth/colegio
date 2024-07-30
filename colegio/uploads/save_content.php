<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $key = $_POST['key'];
    $content = $_POST['content'];

    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Actualizar el contenido en la base de datos
        $stmt = $conn->prepare("UPDATE home SET texto = :content WHERE seccion = :key");
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':key', $key);
        $stmt->execute();

        echo 'Actualización exitosa';
    } catch (PDOException $e) {
        echo 'Error al conectar a la base de datos: ' . $e->getMessage();
    }
    exit();
}
