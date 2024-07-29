<?php
session_start();
require 'config.php'; // Incluye las credenciales de la base de datos

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Se ha enviado una solicitud AJAX para guardar el contenido
    $section = $_POST['section'];
    $content = $_POST['content'];

    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Actualizar el contenido en la base de datos
        $stmt = $conn->prepare("UPDATE home SET texto = :content WHERE seccion = :section");
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':section', $section);
        $stmt->execute();

        echo 'Actualización exitosa';
    } catch (PDOException $e) {
        echo 'Error al conectar a la base de datos: ' . $e->getMessage();
    }
    exit();
}

try {
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT * FROM home ORDER BY seccion, posicion");
    $stmt->execute();
    $contenido = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Administrar Contenido de Inicio</h1>
    <?php foreach ($contenido as $item): ?>
        <form action="actualizar_home.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']); ?>">
            <input type="hidden" name="seccion" value="<?php echo htmlspecialchars($item['seccion']); ?>">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($item['titulo']); ?>">
            </div>
            <div class="form-group">
                <label for="texto">Texto:</label>
                <textarea class="form-control" id="texto" name="texto" rows="3"><?php echo htmlspecialchars($item['texto']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen (dejar en blanco para no cambiar):</label>
                <input type="file" class="form-control" id="imagen" name="imagen">
            </div>
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </form>
        <hr>
    <?php endforeach; ?>
</div>
</body>
</html>
