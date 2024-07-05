<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Subir Imagen</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Subir Imagen</h1>
        <form action="upload_image.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="imagen">Seleccionar Imagen:</label>
                <input type="file" id="imagen" name="imagen" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Subir</button>
        </form>
    </div>
</body>
</html>
