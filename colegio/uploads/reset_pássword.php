<?php
require_once 'uploads/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM password_resets WHERE token = :token AND expira > NOW()");
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        $reset = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($reset) {
            $stmt = $conn->prepare("UPDATE usuarios SET password = :password WHERE email = :email");
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':email', $reset['email']);
            $stmt->execute();

            $stmt = $conn->prepare("DELETE FROM password_resets WHERE email = :email");
            $stmt->bindParam(':email', $reset['email']);
            $stmt->execute();

            echo 'Su contraseña ha sido restablecida con éxito.';
        } else {
            echo 'El enlace de restablecimiento de contraseña es inválido o ha expirado.';
        }
    } catch (PDOException $e) {
        die("Error al conectar a la base de datos: " . $e->getMessage());
    }
} else if (isset($_GET['token'])) {
    $token = $_GET['token'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body class="host_version">
    <div class="container">
        <h2>Restablecer Contraseña</h2>
        <form action="reset_password.php" method="POST">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <div class="form-group">
                <label for="password">Nueva Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Restablecer Contraseña</button>
        </form>
    </div>
</body>
</html>
<?php
} else {
    echo 'Solicitud inválida.';
}
?>
