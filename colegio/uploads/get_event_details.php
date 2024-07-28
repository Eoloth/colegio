<?php
require_once 'config.php';

if (isset($_GET['id'])) {
    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM eventos WHERE id = :id");
        $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();
        $evento = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($evento) {
            echo '<div class="card">';
            echo '<div class="card-header">';
            echo '<h2>' . htmlspecialchars($evento['titulo']) . '</h2>';
            echo '<button class="close">&times;</button>';
            echo '</div>';
            echo '<div class="card-body">';
            echo '<p>' . htmlspecialchars($evento['descripcion']) . '</p>';
            echo '<p><small class="text-muted">Fecha del evento: ' . htmlspecialchars($evento['fecha_evento']) . '</small></p>';
            
            if (!empty($evento['imagen'])) {
                $imagenes = json_decode($evento['imagen'], true);
                if (is_array($imagenes) && !empty($imagenes)) {
                    foreach ($imagenes as $imagen) {
                        echo '<img src="uploads/' . htmlspecialchars($imagen) . '" class="img-fluid mb-2">';
                    }
                }
            }

            echo '</div>';
            echo '</div>';
        } else {
            echo '<p>Detalles del evento no encontrados.</p>';
        }
    } catch (PDOException $e) {
        echo 'Error al conectar a la base de datos: ' . $e->getMessage();
    }
}
?>
