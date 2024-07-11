<?php
require_once 'config.php';

if (isset($_GET['id'])) {
    $eventId = $_GET['id'];

    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM eventos WHERE id = :id");
        $stmt->bindParam(':id', $eventId, PDO::PARAM_INT);
        $stmt->execute();
        $evento = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($evento) {
            echo '<h2>' . htmlspecialchars($evento['titulo']) . '</h2>';
            echo '<p>' . htmlspecialchars($evento['descripcion']) . '</p>';
            echo '<p><small class="text-muted">Fecha del evento: ' . htmlspecialchars($evento['fecha_evento']) . '</small></p>';
            if ($evento['imagen_ruta']) {
                echo '<img src="' . htmlspecialchars($evento['imagen_ruta']) . '" class="img-fluid">';
            }
        } else {
            echo '<p>Evento no encontrado.</p>';
        }
    } catch (PDOException $e) {
        echo 'Error al conectar a la base de datos: ' . $e->getMessage();
    }
} else {
    echo 'ID de evento no proporcionado.';
}
?>
