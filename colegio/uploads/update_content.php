<?php
session_start();
require 'config.php';

if (isset($_POST['key']) && isset($_POST['content'])) {
    $key = $_POST['key'];
    $content = $_POST['content'];

    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Actualizar la columna noticias en la fila correspondiente
        if ($key === 'noticias') {
            $stmt = $conn->prepare("UPDATE home SET noticias = :content WHERE identifier = 'noticias'");
        } else {
            // Para otros campos que no sean noticias, manejar según corresponda
            $stmt = $conn->prepare("UPDATE home SET texto = :content WHERE identifier = :key");
            $stmt->bindParam(':key', $key);
        }

        $stmt->bindParam(':content', $content);
        $stmt->execute();

        echo json_encode(['success' => true, 'message' => 'Datos actualizados']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
}
?>
