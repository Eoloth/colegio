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

$id = $_GET['id'];

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("DELETE FROM galeria WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header("Location: lista_imagenes.php");
    exit();
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
?>
