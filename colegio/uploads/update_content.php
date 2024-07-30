<?php
session_start();
require 'config.php';

if (isset($_POST['key']) && isset($_POST['content'])) {
    $key = $_POST['key'];
    $content = $_POST['content'];

    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Aquí se espera que 'key' tenga un valor que identifique de manera única la fila a actualizar
        $stmt = $conn->prepare("UPDATE contenido SET texto = :content WHERE seccion = :key");
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':key', $key);
        $stmt->execute();

        echo json_encode(['success' => true, 'message' => 'Datos actualizados']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
}
