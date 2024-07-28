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

        // Subida de imagen
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
            $imagen = $_FILES['imagen']['name'];
            $target = '../uploads/' . basename($imagen);

            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $target)) {
                $stmt = $conn->prepare("INSERT INTO eventos (titulo, descripcion, fecha_evento, fecha_publicacion, imagen) VALUES (:titulo, :descripcion, :fecha_evento, NOW(), :imagen)");
                $stmt->bindParam(':titulo', $_POST['titulo']);
                $stmt->bindParam(':descripcion', $_POST['descripcion']);
                $stmt->bindParam(':fecha_evento', $_POST['fecha_evento']);
                $stmt->bindParam(':imagen', $imagen);
                $stmt->execute();

                $_SESSION['mensaje'] = "Evento creado exitosamente.";
                header("Location: list_events.php");
                exit();
            } else {
                throw new Exception("Error al subir la imagen.");
            }
        } else {
            throw new Exception("Error al subir la imagen.");
        }
    } catch (PDOException $e) {
        die("Error al conectar a la base de datos: " . $e->getMessage());
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
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
        <form action="new_event.php" method="post" enctype="multipart/form-data">
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
            <div class="form-group">
                <label for="imagen">Imagen del Evento:</label>
                <input type="file" class="form-control" id="imagen" name="imagen" required>
            </div>
            <button type="submit" class="btn btn-success">Crear Evento</button>
            <a href="list_events.php" class="btn btn-primary">Regresar</a>
        </form>
    </div>
</body>
</html>
