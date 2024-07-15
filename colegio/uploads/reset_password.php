<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        echo 'Las contraseñas no coinciden.';
        exit();
    }

    $contraseña_hash = password_hash($new_password, PASSWORD_DEFAULT);

    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM admin WHERE token = :token AND token_expira > NOW()");
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $stmt = $conn->prepare("UPDATE admin SET contraseña = :password, token = NULL, token_expira = NULL WHERE token = :token");
            $stmt->bindParam(':password', $contraseña_hash);
            $stmt->bindParam(':token', $token);
            $stmt->execute();
            echo 'Contraseña actualizada correctamente.';
        } else {
            echo 'El enlace para restablecer la contraseña ha caducado o no es válido.';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
} elseif (isset($_GET['token'])) {
    $token = $_GET['token'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Restablecer Contraseña</h1>
        <form action="reset_password.php" method="post">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <div class="form-group">
                <label for="new_password">Nueva Contraseña</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirmar Nueva Contraseña</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary">Restablecer Contraseña</button>
        </form>
    </div>
</body>
</html>
<?php
} else {
    echo 'Token no proporcionado.';
}
?>
