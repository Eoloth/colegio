<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../home.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];
    $fecha_evento = $_POST["fecha_evento"];
    $fecha_publicacion = date('Y-m-d H:i:s');

    $host = "localhost";
    $dbname = "escuel36_main";
    $username = "escuel36_admin";
    $password = "NVJd8f2Ae6^M";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO eventos (titulo, descripcion, fecha_evento, fecha_publicacion) VALUES (:titulo, :descripcion, :fecha_evento, :fecha_publicacion)");
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':fecha_evento', $fecha_evento);
        $stmt->bindParam(':fecha_publicacion', $fecha_publicacion);
        $stmt->execute();

        $_SESSION['mensaje'] = "Evento creado con éxito.";
    } catch (PDOException $e) {
        die("Error al conectar a la base de datos: " . $e->getMessage());
    }
}

header("Location: list_events.php");
exit();
?>
