<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.html");
    exit();
}

require_once 'config.php';

try {
    // Intenta conectar a la base de datos usando las constantes definidas
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepara y ejecuta la consulta
    $stmt = $conn->prepare("SELECT * FROM galeria ORDER BY id DESC");
    $stmt->execute();
    $imagenes = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Imprime el mensaje de error si la conexión falla
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
?>

<?php include '../header.php'; ?>
<?php include '../navbar.php'; ?>

<div class="container">
    <h1>Lista de Imágenes</h1>
    <a href="../home.php" class="btn btn-primary btn-home">Regresar al Home</a>
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
                        <td><img src="data:image/jpeg;base64,<?php echo base64_encode($imagen['imagen']); ?>" alt="<?php echo htmlspecialchars($imagen['nombre_archivo']); ?>" class="thumbnail"></td>
                        <td><?php echo htmlspecialchars($imagen['nombre_archivo']); ?></td>
                        <td><?php echo htmlspecialchars($imagen['descripcion']); ?></td>
                        <td>
                            <a href="edit_image.php?id=<?php echo $imagen['id']; ?>" class="btn btn-primary">Editar</a>
                            <a href="delete_image.php?id=<?php echo $imagen['id']; ?>" class="btn btn-danger">Borrar</a>
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
