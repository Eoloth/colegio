<?php
session_start();
require_once 'uploads/config.php';

try {
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT * FROM eventos ORDER BY id DESC");
    $stmt->execute();
    $eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
?>

<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>

<!-- Mostrar mensaje de sesión -->
<?php
if (isset($_SESSION['mensaje'])) {
    echo '<div class="alert alert-info" role="alert">' . $_SESSION['mensaje'] . '</div>';
    unset($_SESSION['mensaje']);
}
?>

<div class="container">
    <!-- Sección de Noticias -->
    <div class="section-title row text-center">
        <div class="col-md-8 offset-md-2">
            <div class="editable-container">
                <h2 class="editable-content" data-key="noticias" contenteditable="true">
                    <?php echo isset($secciones['noticias']) ? htmlspecialchars($secciones['noticias']) : 'Título predeterminado para noticias'; ?>
                </h2>
                <div class="edit-actions" style="display: none;">
                    <button class="save-btn">Guardar</button>
                    <button class="cancel-btn">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="noticias-upload">
        <form action="uploads/upload_image_noticias.php" method="POST" enctype="multipart/form-data">
            <label for="noticias-image">Cargar imagen para noticias:</label>
            <input type="file" name="noticias-image" id="noticias-image" required>
            <button type="submit" class="btn btn-primary mt-2">Subir Imagen</button>
        </form>
    </div>

    <h1>Eventos</h1>
    <?php if (isset($_SESSION['usuario'])): ?>
        <a href="uploads/list_events.php" class="btn btn-info">Administrar Eventos</a>
    <?php endif; ?>

    <div class="row">
        <?php if (empty($eventos)): ?>
            <p>No hay eventos para mostrar.</p>
        <?php else: ?>
            <?php foreach ($eventos as $evento): ?>
                <div class="col-md-4">
                    <div class="card mb-4 evento-card" data-id="<?php echo $evento['id']; ?>">
                        <?php if (!empty($evento['imagen'])): ?>
                            <?php 
                                $imagenes = json_decode($evento['imagen'], true);
                                if (is_array($imagenes) && !empty($imagenes)): 
                            ?>
                                <img src="uploads/<?php echo htmlspecialchars($imagenes[0]); ?>" class="card-img-top img-fluid" alt="<?php echo htmlspecialchars($evento['titulo']); ?>">
                            <?php endif; ?>
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($evento['titulo']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($evento['descripcion']); ?></p>
                            <p class="card-text"><small class="text-muted">Fecha del evento: <?php echo htmlspecialchars($evento['fecha_evento']); ?></small></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div id="event-details-container" style="display:none;">
        <div id="event-details" class="card">
            <span class="close">&times;</span>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script>
    $(document).ready(function() {
        $('.evento-card').on('click', function() {
            var eventId = $(this).data('id');
            $.ajax({
                url: 'uploads/get_event_details.php',
                method: 'GET',
                data: { id: eventId },
                success: function(data) {
                    $('#event-details').html(data);
                    $('#event-details-container').show();

                    // Asegurar que la imagen dentro del evento cargado ocupe el 100% del ancho
                    $('#event-details img').css({
                        'width': '100%',
                        'height': 'auto'
                    });
                }
            });
        });

        $('#event-details-container').on('click', '.close', function() {
            $('#event-details-container').hide();
        });

        $(window).on('click', function(event) {
            if (event.target == document.getElementById('event-details-container')) {
                $('#event-details-container').hide();
            }
        });
    });
</script>
</body>
</html>
