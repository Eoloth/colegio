<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../home.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Imagen</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../css/versions.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="../css/custom.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/modernizer.js"></script>
</head>
<body class="host_version">
<?php include '../navbar.php'; ?>

<div class="container mt-4">
    <h1 class="mb-4">Subir Imagen</h1>
    <a href="list_images.php" class="btn btn-primary mb-4">Regresar a la Lista de Imágenes</a>
    <form action="upload_image.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="imagen">Seleccionar imágenes</label>
            <input type="file" name="images[]" multiple class="form-control-file" required>
        </div>
        <button type="submit" class="btn btn-success">Subir Imágenes</button>
    </form>
</div>

<?php include '../footer.php'; ?>

<!-- Incluir dependencias de Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
