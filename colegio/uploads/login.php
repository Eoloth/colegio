<?php
session_start();
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $contraseña = $_POST["contraseña"];

    // Preparar la consulta
    $stmt = $conn->prepare("SELECT * FROM admin WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($contraseña, $user['contraseña'])) {
        $_SESSION['usuario'] = $usuario;
        // Redirigir a home.php con un parámetro que indique éxito
        header("Location: home.php?login=success");
        exit();
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
    $stmt->close();
}
$conn->close();
?>
