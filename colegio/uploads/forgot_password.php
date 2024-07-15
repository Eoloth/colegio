<?php
require_once 'uploads/config.php';
require_once 'vendor/autoload.php'; // Assuming you're using Composer for PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            $token = bin2hex(random_bytes(50)); // Generate a secure token
            $expira = date("Y-m-d H:i:s", strtotime('+1 hour')); // Token expiry time

            $stmt = $conn->prepare("INSERT INTO password_resets (email, token, expira) VALUES (:email, :token, :expira)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':expira', $expira);
            $stmt->execute();

            // Send the email
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.tu-dominio.com'; // SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'noreply@tu-dominio.com'; // SMTP username
                $mail->Password = 'tu-password'; // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587; // TCP port

                $mail->setFrom('noreply@tu-dominio.com', 'Escuela Niño Jesús');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Recuperación de contraseña';
                $mail->Body = "Haga clic en el siguiente enlace para restablecer su contraseña: <a href='https://tu-dominio.com/reset_password.php?token=$token'>Restablecer contraseña</a>";

                $mail->send();
                echo 'Se ha enviado un correo con instrucciones para restablecer su contraseña.';
            } catch (Exception $e) {
                echo "No se pudo enviar el correo. Error: {$mail->ErrorInfo}";
            }
        } else {
            echo 'No se encontró una cuenta con ese correo electrónico.';
        }
    } catch (PDOException $e) {
        die("Error al conectar a la base de datos: " . $e->getMessage());
    }
}
?>
