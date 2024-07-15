<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require_once 'uploads/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM admin WHERE correo_recuperacion = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            $token = bin2hex(random_bytes(16));
            $expira = date("Y-m-d H:i:s", strtotime('+1 hour'));

            $stmt = $conn->prepare("UPDATE admin SET token = :token, token_expira = :expira WHERE correo_recuperacion = :email");
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':expira', $expira);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'mail.escuela-niniojesus.cl';
                $mail->SMTPAuth = true;
                $mail->Username = 'noreply@escuela-niniojesus.cl';
                $mail->Password = 'NVJd8f2Ae6^M'; // Utiliza la contraseña de la cuenta de correo
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                $mail->setFrom('noreply@escuela-niniojesus.cl', 'Escuela Niño Jesús');
                $mail->addAddress($email, $usuario['usuario']);

                $mail->isHTML(true);
                $mail->Subject = 'Restablecer contraseña';
                $mail->Body = 'Haz clic en el siguiente enlace para restablecer tu contraseña: <a href="https://escuela-niniojesus.cl/uploads/reset_password.php?token=' . $token . '">Restablecer contraseña</a>';
                $mail->AltBody = 'Haz clic en el siguiente enlace para restablecer tu contraseña: https://escuela-niniojesus.cl/uploads/reset_password.php?token=' . $token;

                $mail->send();
                echo 'El mensaje ha sido enviado';
            } catch (Exception $e) {
                echo "No se pudo enviar el mensaje. Error de PHPMailer: {$mail->ErrorInfo}";
            }
        } else {
            echo 'El correo electrónico no existe en nuestra base de datos';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>
