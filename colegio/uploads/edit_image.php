<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../home.php");
    exit();
}

require_once 'config.php';

try {
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $descripcion = $_POST['descripcion'];

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
            $nombre_archivo = $_FILES['imagen']['name'];
            $imagen = file_get_contents($_FILES['imagen']['tmp_name']);
            $stmt = $conn->prepare("UPDATE galeria SET nombre_archivo = :nombre_archivo, descripcion = :descripcion, imagen = :imagen WHERE id = :id");
            $stmt->bindParam(':nombre_archivo', $nombre_archivo);
            $stmt->bindParam(':imagen', $imagen, PDO::PARAM_LOB);
        } else {
            $stmt = $conn->prepare("UPDATE galeria SET descripcion = :descripcion WHERE id = :id");
        }

        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $_SESSION['mensaje'] = "Imagen actualizada con éxito.";
        header("Location: list_images.php");
        exit();
    } else {
        $id = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM galeria WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $imagen = $stmt->fetch(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    $_SESSION['mensaje'] = "Error al conectar a la base de datos: " . $e->getMessage();
    header("Location: list_images.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editar Imagen</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Editar Imagen</h1>
    <form action="edit_image.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($imagen['id']); ?>">
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?php echo htmlspecialchars($imagen['descripcion']); ?>" required>
        </div>
        <div class="form-group">
            <label for="imagen">Imagen (opcional):</label>
            <input type="file" class="form-control" id="imagen" name="imagen">
            <p>Imagen actual: <?php echo htmlspecialchars($imagen['nombre_archivo']); ?></p>
        </div>
        <button type="submit" class="btn btn-success">Actualizar Imagen</button>
        <a href="list_images.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
