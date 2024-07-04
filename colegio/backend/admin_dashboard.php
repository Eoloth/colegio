<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: home.html"); // Redirigir a la página de inicio si no está autenticado
    exit();
}

$host = "localhost";
$dbname = "escuel36_main";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}

// Aquí puedes agregar la lógica para manejar CRUD de eventos y galería
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Bienvenido, <?php echo $_SESSION['usuario']; ?></h1>
        <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
        
        <!-- Aquí puedes agregar la interfaz para CRUD de eventos y galería -->
        
    </div>
</body>
</html>
