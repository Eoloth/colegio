<?php
include 'config.php';

try {
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $new_password = "ContraseñaSegura1";
    $contraseña_hash = password_hash($new_password, PASSWORD_DEFAULT);
    $usuario = "admin";

    $stmt = $conn->prepare("UPDATE admin SET contraseña = :contraseña WHERE usuario = :usuario");
    $stmt->bindParam(':contraseña', $contraseña_hash);
    $stmt->bindParam(':usuario', $usuario);

    if ($stmt->execute()) {
        echo "Contraseña actualizada correctamente.";
    } else {
        echo "Error actualizando la contraseña.";
    }
} catch (PDOException $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
}
?>
