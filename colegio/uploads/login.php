<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM admin WHERE usuario = :usuario");
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($contraseña, $admin['contraseña'])) {
                $_SESSION['usuario'] = $admin['usuario'];
                $_SESSION['rol'] = 'admin'; // Añade el rol a la sesión
                header("Location: ../home.php");
                exit();
            } else {
                $_SESSION['mensaje'] = 'Contraseña incorrecta';
            }
        } else {
            $_SESSION['mensaje'] = 'Usuario no encontrado';
        }
    } catch (PDOException $e) {
        $_SESSION['mensaje'] = 'Error de conexión: ' . $e->getMessage();
    }

    header("Location: ../home.php");
    exit();
}
?>
