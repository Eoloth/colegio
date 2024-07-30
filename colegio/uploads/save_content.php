<?php
session_start();
require 'config.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $section = $_POST['seccion'];
    $content = $_POST['content'];

    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("UPDATE home SET texto = :content WHERE seccion = :section");
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':section', $section);
        $stmt->execute();

        $stmt = $conn->prepare("SELECT * FROM home WHERE seccion = :section");
        $stmt->bindParam(':section', $section);
        $stmt->execute();
        $updatedData = $stmt->fetch(PDO::FETCH_ASSOC);

        echo 'Datos actualizados: ';
        print_r($updatedData);
    } catch (PDOException $e) {
        echo 'Error al conectar a la base de datos: ' . $e->getMessage();
    }
    exit();
}
