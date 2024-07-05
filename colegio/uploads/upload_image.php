<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.html");
    exit();
}

$host = "localhost";
$dbname = "escuel36_main";
$username = "escuel36_admin";
$password = "NVJd8f2Ae6^M";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if ($_FILES) {
        $file = $_FILES['file'];
        $uploadDir = '../uploads/';
        $uploadFile = $uploadDir . basename($file['name']);

        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            $stmt = $conn->prepare("INSERT INTO galeria (nombre_imagen, ruta_imagen) VALUES (:nombre_imagen, :ruta_imagen)");
            $stmt->bindParam(':nombre_imagen', $file['name']);
            $stmt->bindParam(':ruta_imagen', $uploadFile);
            $stmt->execute();

            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
