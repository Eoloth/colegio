<?php
session_start();
$host = "localhost";
$dbname = "escuel36_main";
$username = "root"; // Cambia esto a tu usuario de base de datos
$password = ""; // Cambia esto a tu contraseña de base de datos

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $contraseña = $_POST["contraseña"];

    $stmt = $conn->prepare("SELECT * FROM admin WHERE usuario = :usuario");
    $stmt->bindParam(':usuario', $usuario);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($contraseña, $user['contraseña'])) {
        $_SESSION['usuario'] = $usuario;
        header("Location: admin_dashboard.php"); // Redirigir al dashboard de admin si el login es exitoso
        exit();
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
}
?>
