<?php
$servername = "localhost";
$username = "escuel36_admin";
$password = "NVJd8f2Ae6^M";
$dbname = "escuel36_main";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Nueva contraseña a actualizar
$new_password = "ContraseñaSegura1";
$contraseña_hash = password_hash($new_password, PASSWORD_DEFAULT);

// Usuario a actualizar
$usuario = "admin";

// Preparar la consulta de actualización
$stmt = $conn->prepare("UPDATE admin SET contraseña = ? WHERE usuario = ?");
$stmt->bind_param("ss", $contraseña_hash, $usuario);

if ($stmt->execute()) {
    echo "Contraseña actualizada correctamente.";
} else {
    echo "Error actualizando la contraseña: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
