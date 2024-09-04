<?php 
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../home.php");
    exit();
}

require_once 'config.php';

if (isset($_GET['id']) && isset($_GET['context']) && isset($_GET['filename'])) {
    $id = intval($_GET['id']);
    $context = $_GET['context'];
    $filename = basename($_GET['filename']); // Sanitizar el nombre del archivo para evitar problemas de seguridad

    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($context === 'galeria') {
            // Obtener el nombre del archivo para eliminarlo del servidor (Galería)
            $stmt = $conn->prepare("SELECT nombre_archivo FROM galeria WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $imagen = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($imagen && $imagen['nombre_archivo'] === $filename) {
                $filepath = '../uploads/' . $imagen['nombre_archivo'];
                if (file_exists($filepath) && unlink($filepath)) {
                    // Eliminar la imagen de la base de datos solo si el archivo fue eliminado exitosamente
                    $stmt = $conn->prepare("DELETE FROM galeria WHERE id = :id");
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();

                    echo "success";
                } else {
                    echo "Error al eliminar la imagen del servidor.";
                }
            } else {
                echo "Error: imagen no encontrada en la base de datos.";
            }
        } elseif ($context === 'evento') {
            // Obtener el nombre del archivo para eliminarlo del servidor (Eventos)
            $stmt = $conn->prepare("SELECT imagen FROM eventos WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $evento = $stmt->fetch(PDO::FETCH_ASSOC);

            $imagenes = json_decode($evento['imagen'], true);

            if ($imagenes && in_array($filename, $imagenes)) {
                $filepath = '../uploads/' . $filename;
                if (file_exists($filepath) && unlink($filepath)) {
                    // Eliminar la imagen de la base de datos solo si el archivo fue eliminado exitosamente
                    $imagenes = array_diff($imagenes, [$filename]);
                    $imagenes_json = json_encode(array_values($imagenes));
                    
                    $stmt = $conn->prepare("UPDATE eventos SET imagen = :imagen WHERE id = :id");
                    $stmt->bindParam(':imagen', $imagenes_json);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();

                    echo "success";
                } else {
                    echo "Error al eliminar la imagen del servidor.";
                }
            } else {
                echo "Error: imagen no encontrada en la base de datos.";
            }
        } else {
            echo "Contexto no válido.";
        }
    } catch (PDOException $e) {
        echo "Error al conectar a la base de datos: " . $e->getMessage();
    }
} else {
    echo "Error: Datos incorrectos.";
}
?>
