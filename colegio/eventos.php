<?php
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

<div class="container">
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
                        <?php if ($evento['imagen_ruta']): ?>
                            <img src="<?php echo htmlspecialchars($evento['imagen_ruta']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($evento['titulo']); ?>">
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
    <div id="event-details-container">
        <div id="event-details"></div>
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
