<?php
$host = "localhost";
$dbname = "escuel36_main";
$username = "escuel36_admin";
$password = "NVJd8f2Ae6^M";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $new_password = "ContraseñaSegura1";
    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE admin SET contraseña = :contraseña WHERE usuario = 'admin'");
    $stmt->bindParam(':contraseña', $password_hash);
    $stmt->execute();

    echo "Contraseña actualizada con éxito.";
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
?>
