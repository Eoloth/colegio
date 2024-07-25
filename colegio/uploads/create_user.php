<?php
session_start();
require_once 'config.php';

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $password = $_POST['password'];
    $correo_recuperacion = trim($_POST['correo_recuperacion']);

    // Validar que los campos no estén vacíos
    if (empty($usuario) || empty($password) || empty($correo_recuperacion)) {
        $errores[] = "Todos los campos son obligatorios.";
    }

    // Validar que el correo electrónico sea válido
    if (!filter_var($correo_recuperacion, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "Correo de recuperación inválido.";
    }

    // Validar que la contraseña tenga al menos 8 caracteres, incluyendo un número o símbolo
    if (!preg_match('/^(?=.*[0-9])(?=.*[^\w\d]).{8,}$/', $password)) {
        $errores[] = "La contraseña debe tener al menos 8 caracteres, incluyendo un número o símbolo.";
    }

    // Si no hay errores, proceder con la creación del usuario
    if (empty($errores)) {
        $contraseña_hash = password_hash($password, PASSWORD_DEFAULT);

        try {
            $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("INSERT INTO admin (usuario, contraseña, correo_recuperacion) VALUES (?, ?, ?)");
            $stmt->bindParam(1, $usuario, PDO::PARAM_STR);
            $stmt->bindParam(2, $contraseña_hash, PDO::PARAM_STR);
            $stmt->bindParam(3, $correo_recuperacion, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $_SESSION['mensaje'] = "Usuario creado correctamente.";
                header("Location: ../home.php");
                exit();
            } else {
                $errores[] = "Error al crear el usuario.";
            }
        } catch (PDOException $e) {
            $errores[] = "Error al conectar a la base de datos: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario Administrador</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Crear Usuario Administrador</h1>
        <?php
        if (isset($_SESSION['mensaje'])) {
            echo '<div class="alert alert-info">' . $_SESSION['mensaje'] . '</div>';
            unset($_SESSION['mensaje']);
        }

        if (!empty($errores)) {
            echo '<div class="alert alert-danger"><ul>';
            foreach ($errores as $error) {
                echo '<li>' . htmlspecialchars($error) . '</li>';
            }
            echo '</ul></div>';
        }
        ?>
        <form action="create_user.php" method="post">
            <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <small class="form-text text-muted">Debe tener al menos 8 caracteres, incluyendo un número o símbolo.</small>
            </div>
            <div class="form-group">
                <label for="correo_recuperacion">Correo de Recuperación</label>
                <input type="email" class="form-control" id="correo_recuperacion" name="correo_recuperacion" required>
            </div>
            <button type="submit" class="btn btn-primary">Crear Usuario</button>
        </form>
    </div>
</body>
</html>
