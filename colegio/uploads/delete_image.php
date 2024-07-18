<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../home.php");
    exit();
}


$host = "localhost";
$dbname = "escuel36_main";
$username = "escuel36_admin";
$password = "NVJd8f2Ae6^M";

$id = $_GET['id'];

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("DELETE FROM galeria WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $_SESSION['mensaje'] = "Imagen eliminada con éxito.";
    header("Location: list_images.php");
    exit();
} catch (PDOException $e) {
    $_SESSION['mensaje'] = "Error al conectar a la base de datos.";
    header("Location: list_images.php");
    exit();
}
?>
