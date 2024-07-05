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
    
    $stmt = $conn->prepare("SELECT * FROM galeria ORDER BY id DESC");
    $stmt->execute();
    $imagenes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Galería de Imágenes</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Galería de Imágenes</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Ruta</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($imagenes as $imagen): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($imagen['id']); ?></td>
                        <td><?php echo htmlspecialchars($imagen['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($imagen['ruta']); ?></td>
                        <td>
                            <a href="edit_image.php?id=<?php echo $imagen['id']; ?>" class="btn btn-primary">Editar</a>
                            <a href="delete_image.php?id=<?php echo $imagen['id']; ?>" class="btn btn-danger">Borrar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="upload_image.php" class="btn btn-success">Subir Nueva Imagen</a>
    </div>
</body>
</html>
