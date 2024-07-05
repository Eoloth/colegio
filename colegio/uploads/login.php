<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $contraseña = $_POST["contraseña"];

    $host = "localhost";
    $dbname = "escuel36_main";
    $username = "escuel36_admin";
    $password = "NVJd8f2Ae6^M";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $conn->prepare("SELECT * FROM admin WHERE usuario = :usuario");
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($contraseña, $user['contraseña'])) {
            $_SESSION['usuario'] = $usuario;
            $_SESSION['mensaje'] = "Bienvenido, $usuario!";
        } else {
            $_SESSION['mensaje'] = "Usuario o contraseña incorrectos.";
        }
    } catch (PDOException $e) {
        $_SESSION['mensaje'] = "Error al conectar a la base de datos: " . $e->getMessage();
    }
    
    header("Location: ../home.html");
    exit();
}
?>
