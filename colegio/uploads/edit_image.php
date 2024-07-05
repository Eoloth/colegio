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

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_archivo = $_POST["nombre_archivo"];
    $ruta = $_POST["ruta"];

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("UPDATE galeria SET nombre_archivo = :nombre_archivo, ruta = :ruta WHERE id = :id");
        $stmt->bindParam(':nombre_archivo', $nombre_archivo);
        $stmt->bindParam(':ruta', $ruta);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        header("Location: lista_imagenes.php");
        exit();
    } catch (PDOException $e) {
        die("Error al conectar a la base de datos: " . $e->getMessage());
    }
} else {
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM galeria WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $imagen = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error al conectar a la base de datos: " . $e->getMessage());
    }
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
        <form action="edit_image.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre_archivo">Nombre del Archivo</label>
                <input type="text" id="nombre_archivo" name="nombre_archivo" class="form-control" value="<?php echo htmlspecialchars($imagen['nombre_archivo']); ?>" required>
            </div>
            <div class="form-group">
                <label for="ruta">Ruta</label>
                <input type="text" id="ruta" name="ruta" class="form-control" value="<?php echo htmlspecialchars($imagen['ruta']); ?>" required>
            </div>
            <input type="submit" class="btn btn-success" value="Actualizar Imagen">
        </form>
    </div>
</body>
</html>
