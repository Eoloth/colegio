<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../home.php");
    exit();
}

require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO eventos (titulo, descripcion, fecha_evento, fecha_publicacion) VALUES (:titulo, :descripcion, :fecha_evento, NOW())");
        $stmt->bindParam(':titulo', $_POST['titulo']);
        $stmt->bindParam(':descripcion', $_POST['descripcion']);
        $stmt->bindParam(':fecha_evento', $_POST['fecha_evento']);
        $stmt->execute();

        $_SESSION['mensaje'] = "Evento creado exitosamente.";
        header("Location: list_events.php");
        exit();
    } catch (PDOException $e) {
        die("Error al conectar a la base de datos: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Crear Nuevo Evento</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Crear Nuevo Evento</h1>
        <form action="new_event.php" method="post">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="fecha_evento">Fecha del Evento:</label>
                <input type="date" class="form-control" id="fecha_evento" name="fecha_evento" required>
            </div>
            <button type="submit" class="btn btn-success">Crear Evento</button>
            <a href="list_events.php" class="btn btn-primary">Regresar</a>
        </form>
    </div>
</body>
</html>
