<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: ../home.php");
    exit();
}

try {
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $texto = $_POST['texto'];
    $imagen = $_FILES['imagen']['name'];

    if ($imagen) {
        // Subir nueva imagen si se proporciona
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($imagen);
        move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file);
    } else {
        // Obtener imagen actual si no se proporciona una nueva
        $stmt = $conn->prepare("SELECT imagen FROM home WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $imagen = $stmt->fetch(PDO::FETCH_ASSOC)['imagen'];
    }

    // Actualizar la base de datos
    $stmt = $conn->prepare("UPDATE home SET titulo = :titulo, texto = :texto, imagen = :imagen WHERE id = :id");
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':texto', $texto);
    $stmt->bindParam(':imagen', $imagen);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $_SESSION['mensaje'] = "Contenido actualizado exitosamente.";
    header("Location: ../home.php");
    exit();

} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
