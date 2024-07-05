<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../home.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];
    $fecha_evento = $_POST["fecha_evento"];

    $host = "localhost";
    $dbname = "escuel36_main";
    $username = "escuel36_admin";
    $password = "NVJd8f2Ae6^M";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("UPDATE eventos SET titulo = :titulo, descripcion = :descripcion, fecha_evento = :fecha_evento WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':fecha_evento', $fecha_evento);
        $stmt->execute();

        $_SESSION['mensaje'] = "Evento actualizado con éxito.";
    } catch (PDOException $e) {
        die("Error al conectar a la base de datos: " . $e->getMessage());
    }
}

header("Location: list_events.php");
exit();
?>
