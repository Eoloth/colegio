<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../home.php");
    exit();
}

require_once 'config.php';

if (isset($_GET['filename']) && isset($_GET['id'])) {
    $filename = basename($_GET['filename']);
    $id = intval($_GET['id']);

    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT imagen FROM eventos WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $evento = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($evento) {
            $imagenes = json_decode($evento['imagen'], true);
            if ($imagenes && is_array($imagenes)) {
                $imagenes = array_diff($imagenes, [$filename]);
                $imagenes_json = json_encode($imagenes);

                $stmt = $conn->prepare("UPDATE eventos SET imagen = :imagen WHERE id = :id");
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->bindParam(':imagen', $imagenes_json);
                $stmt->execute();

                echo 'success';
            } else {
                echo 'error: imagenes not array';
            }
        } else {
            echo 'error: evento not found';
        }
    } catch (PDOException $e) {
        echo 'database error: ' . $e->getMessage();
    }
} else {
    echo 'error: filename or id not set';
}
?>
