<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $correo_recuperacion = $_POST['correo_recuperacion'];
    $contraseña_hash = password_hash($password, PASSWORD_DEFAULT);

    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO admin (usuario, contraseña, correo_recuperacion) VALUES (?, ?, ?)");
        $stmt->bindParam(1, $usuario, PDO::PARAM_STR);
        $stmt->bindParam(2, $contraseña_hash, PDO::PARAM_STR);
        $stmt->bindParam(3, $correo_recuperacion, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $_SESSION['mensaje'] = "Usuario creado correctamente.";
        } else {
            $_SESSION['mensaje'] = "Error al crear el usuario.";
        }
    } catch (PDOException $e) {
        $_SESSION['mensaje'] = "Error al conectar a la base de datos: " . $e->getMessage();
    }
    header("Location: create_user.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Crear Administrador</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Crear Administrador</h1>
        <?php
        if (isset($_SESSION['mensaje'])) {
            echo '<div class="alert alert-info" role="alert">' . $_SESSION['mensaje'] . '</div>';
            unset($_SESSION['mensaje']);
        }
        ?>
        <form action="create_user.php" method="POST">
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <input type="text" class="form-control" id="usuario" name="usuario" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="correo_recuperacion">Correo de Recuperación:</label>
                <input type="email" class="form-control" id="correo_recuperacion" name="correo_recuperacion" required>
            </div>
            <button type="submit" class="btn btn-primary">Crear Administrador</button>
        </form>
        <br>
        <a href="../home.php" class="btn btn-secondary">Regresar al Home</a>
    </div>
</body>
</html>
