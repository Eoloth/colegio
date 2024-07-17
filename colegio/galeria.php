<?php
session_start(); // Asegúrate de iniciar la sesión

require_once 'uploads/config.php';

try {
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT * FROM galeria ORDER BY id DESC");
    $stmt->execute();
    $imagenes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
?>

<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>

<div class="container">
    <h1>Galería de Imágenes</h1>
    <?php if (isset($_SESSION['usuario']) && $_SESSION['rol'] === 'admin'): ?>
        <a href="uploads/list_images.php" class="btn btn-info">Administrar Galería de Imágenes</a>
    <?php endif; ?>

    <div class="row">
        <?php if (empty($imagenes)): ?>
            <p>No hay imágenes para mostrar.</p>
        <?php else: ?>
            <?php foreach ($imagenes as $imagen): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($imagen['imagen']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($imagen['nombre_archivo']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($imagen['nombre_archivo']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($imagen['descripcion']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
