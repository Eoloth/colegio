<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM admin WHERE usuario = :usuario");
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($contraseña, $user['contraseña'])) {
            $_SESSION['usuario'] = $usuario;
            $_SESSION['mensaje'] = "Bienvenido, $usuario!";
            header("Location: ../home.php");
            exit();
        } else {
            $_SESSION['mensaje'] = "Usuario o contraseña incorrectos.";
        }
    } catch (PDOException $e) {
        $_SESSION['mensaje'] = "Error al conectar a la base de datos: " . $e->getMessage();
    }

    header("Location: ../home.php");
    exit();
}
?>
