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

    $stmt = $conn->prepare("SELECT * FROM galeria ORDER BY id DESC");
    $stmt->execute();
    $imagenes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Verificación para asegurar que se están obteniendo los datos
    if (!$imagenes) {
        echo "No se encontraron imágenes en la base de datos.";
    } else {
        echo "Se encontraron " . count($imagenes) . " imágenes en la base de datos.";
    }
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Imágenes</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../css/versions.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="../css/custom.css">
    <link rel="stylesheet" href="../css/lightbox.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/modernizer.js"></script>
    <script src="../js/lightbox.js"></script>
</head>
<body class="host_version">
<?php include '../navbar.php'; ?>

<div class="container">
    <h1>Lista de Imágenes</h1>
    <a href="../home.php" class="btn btn-primary btn-home">Regresar al Home</a>
    <a href="upload_image_form.php" class="btn btn-success">Subir Imagen</a>
    <?php if ($imagenes): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imagen</th>
                    <th>Nombre del Archivo</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($imagenes as $imagen): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($imagen['id']); ?></td>
                        <td>
                            <a href="data:image/jpeg;base64,<?php echo base64_encode($imagen['imagen']); ?>" data-lightbox="galeria" data-title="<?php echo htmlspecialchars($imagen['nombre_archivo']); ?>">
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($imagen['imagen']); ?>" alt="<?php echo htmlspecialchars($imagen['nombre_archivo']); ?>" class="thumbnail" style="width: 100px; height: 100px;">
                            </a>
                        </td>
                        <td><?php echo htmlspecialchars($imagen['nombre_archivo']); ?></td>
                        <td><?php echo htmlspecialchars($imagen['descripcion']); ?></td>
                        <td>
                            <a href="edit_image.php?id=<?php echo $imagen['id']; ?>" class="btn btn-primary">Editar</a>
                            <a href="delete_image.php?id=<?php echo $imagen['id']; ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta imagen?');">Borrar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay imágenes para mostrar.</p>
    <?php endif; ?>
</div>

<?php include '../footer.php'; ?>

<!-- Incluir dependencias de Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
