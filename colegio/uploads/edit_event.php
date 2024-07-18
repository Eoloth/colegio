<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../home.php");
    exit();
}


require_once 'config.php';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $stmt = $conn->prepare("UPDATE eventos SET titulo = :titulo, descripcion = :descripcion, fecha_evento = :fecha_evento WHERE id = :id");
        $stmt->bindParam(':id', $_POST['id']);
        $stmt->bindParam(':titulo', $_POST['titulo']);
        $stmt->bindParam(':descripcion', $_POST['descripcion']);
        $stmt->bindParam(':fecha_evento', $_POST['fecha_evento']);
        $stmt->execute();

        $_SESSION['mensaje'] = "Evento actualizado exitosamente.";
        header("Location: list_events.php");
        exit();
    } else {
        $stmt = $conn->prepare("SELECT * FROM eventos WHERE id = :id");
        $stmt->bindParam(':id', $_GET['id']);
        $stmt->execute();
        $evento = $stmt->fetch(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editar Evento</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Editar Evento</h1>
        <form action="edit_event.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($evento['id']); ?>">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($evento['titulo']); ?>" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?php echo htmlspecialchars($evento['descripcion']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="fecha_evento">Fecha del Evento:</label>
                <input type="date" class="form-control" id="fecha_evento" name="fecha_evento" value="<?php echo htmlspecialchars($evento['fecha_evento']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Evento</button>
            <a href="list_events.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
