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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $fecha_evento = $_POST['fecha_evento'];

        $stmt = $conn->prepare("INSERT INTO eventos (titulo, descripcion, fecha_evento) VALUES (:titulo, :descripcion, :fecha_evento)");
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':fecha_evento', $fecha_evento);
        $stmt->execute();

        header("Location: lista_eventos.php");
        exit();
    }
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
?>
