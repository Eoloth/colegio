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
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        
        $stmt = $conn->prepare("UPDATE galeria SET nombre_archivo = :nombre, descripcion = :descripcion WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->execute();
        
        header("Location: lista_imagenes.php");
        exit();
    } else {
        $id = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM galeria WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $imagen = $stmt->fetch(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
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
        <form action="edit_image.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($imagen['id']); ?>">
            <div class="form-group">
                <label for="nombre">Nombre del Archivo</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($imagen['nombre_archivo']); ?>" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?php echo htmlspecialchars($imagen['descripcion']); ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Actualizar Imagen</button>
        </form>
    </div>
</body>
</html>
