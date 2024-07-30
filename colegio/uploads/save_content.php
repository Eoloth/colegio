<?php
include 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $seccion = $_POST['seccion'];
    $content = $_POST['content'];

    echo "Iniciando conexión a la base de datos...<br>";

    $query = "UPDATE home SET texto = ? WHERE seccion = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $content, $seccion);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Datos guardados correctamente.<br>";
    } else {
        echo "Error al guardar los datos o no hubo cambios.<br>";
    }

    $stmt->close();
    
    // Rescatar los datos insertados para mostrar confirmación
    $query = "SELECT texto FROM home WHERE seccion = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $seccion);
    $stmt->execute();
    $stmt->bind_result($updated_text);
    $stmt->fetch();
    
    echo "Contenido recibido: " . htmlspecialchars($updated_text);
    $stmt->close();
}

$conn->close();
?>
