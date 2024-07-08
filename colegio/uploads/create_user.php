<?php
include 'config.php';

try {
    // Paso 1: Conectar a la base de datos
    echo "Intentando conectar a la base de datos...<br>";
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa.<br>";

    // Paso 2: Definir valores
    $usuario = "admin";
    $new_password = "ContraseñaSegura1";
    $correo_recuperacion = "correo@recuperacion.com";
    $contraseña_hash = password_hash($new_password, PASSWORD_DEFAULT);

    echo "Valores definidos: <br>";
    echo "Usuario: $usuario<br>";
    echo "Contraseña Hasheada: $contraseña_hash<br>";
    echo "Correo Recuperacion: $correo_recuperacion<br>";

    // Paso 3: Preparar la consulta
    echo "Preparando la consulta...<br>";
    $stmt = $conn->prepare("INSERT INTO admin (usuario, contraseña, correo_recuperacion) VALUES (?, ?, ?)");

    // Paso 4: Vincular parámetros
    echo "Vinculando parámetros...<br>";
    $stmt->bindParam(1, $usuario, PDO::PARAM_STR);
    $stmt->bindParam(2, $contraseña_hash, PDO::PARAM_STR);
    $stmt->bindParam(3, $correo_recuperacion, PDO::PARAM_STR);

    // Paso 5: Ejecutar la consulta
    echo "Ejecutando la consulta...<br>";
    if ($stmt->execute()) {
        echo "Usuario creado correctamente.<br>";
    } else {
        echo "Error al crear el usuario.<br>";
    }
} catch (PDOException $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
}
?>
