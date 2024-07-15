<?php
require 'vendor/autoload.php'; // Asegúrate de que PHPMailer está instalado vía Composer
require_once 'uploads/config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    try {
        // Conexión a la base de datos
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Verificar si el correo electrónico existe en la base de datos
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            $token = bin2hex(random_bytes(16));
            $expira = date("Y-m-d H:i:s", strtotime('+1 hour'));

            // Guardar el token y la fecha de expiración en la base de datos
            $stmt = $conn->prepare("UPDATE usuarios SET token = :token, token_expira = :expira WHERE email = :email");
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':expira', $expira);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // Enviar correo electrónico con el enlace para restablecer la contraseña
            $mail = new PHPMailer(true);
            try {
                // Configuración del servidor
                $mail->isSMTP();
                $mail->Host = 'mail.escuela-niniojesus.cl';
                $mail->SMTPAuth = true;
                $mail->Username = 'noreply@escuela-niniojesus.cl';
                $mail->Password = 'NVJd8f2Ae6^M'; // Utiliza la contraseña de la cuenta de correo
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                // Configuración del correo
                $mail->setFrom('noreply@escuela-niniojesus.cl', 'Escuela Niño Jesús');
                $mail->addAddress($email, $usuario['nombre']);

                $mail->isHTML(true);
                $mail->Subject = 'Restablecer contraseña';
                $mail->Body = 'Haz clic en el siguiente enlace para restablecer tu contraseña: <a href="https://escuela-niniojesus.cl/reset_password.php?token=' . $token . '">Restablecer contraseña</a>';
                $mail->AltBody = 'Haz clic en el siguiente enlace para restablecer tu contraseña: https://escuela-niniojesus.cl/reset_password.php?token=' . $token;

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
