<?php
session_start();
$servername = "localhost";  // Utiliza 'localhost' ya que la base de datos está en el mismo servidor que la web
$username = "escuel36_admin";  // Cambia esto a tu usuario de base de datos
$password = "NVJd8f2Ae6^M";  // Cambia esto a tu contraseña de base de datos
$dbname = "escuel36_main";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error al conectar a la base de datos: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $contraseña = $_POST["contraseña"];

    $stmt = $conn->prepare("SELECT * FROM admin WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($contraseña, $user['contraseña'])) {
        $_SESSION['usuario'] = $usuario;
        header("Location: admin_dashboard.php"); // Redirigir al dashboard de admin si el login es exitoso
        exit();
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" name="usuario" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="contraseña">Contraseña:</label>
                <input type="password" id="contraseña" name="contraseña" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Entrar</button>
        </form>
    </div>
</body>
</html>