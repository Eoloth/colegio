<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../home.php");
    exit();
}

require_once 'config.php';

if (isset($_GET['filename'])) {
    $filename = basename($_GET['filename']);
    $filepath = '../uploads/' . $filename;

    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Eliminar la imagen del servidor
        if (file_exists($filepath)) {
            if (unlink($filepath)) {
                echo 'success';
            } else {
                echo 'error';
            }
        } else {
            echo 'file not found';
        }
    } catch (PDOException $e) {
        echo 'database error: ' . $e->getMessage();
    }
} else {
    echo 'filename not set';
}
?>
