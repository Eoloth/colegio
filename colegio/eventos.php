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

<!-- Mostrar mensaje de sesión -->
<?php
session_start();
if (isset($_SESSION['mensaje'])) {
    echo '<div class="alert alert-info" role="alert">' . $_SESSION['mensaje'] . '</div>';
    unset($_SESSION['mensaje']);
}
?>

<!-- Modal -->
<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body customer-box">
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="Login">
                        <form role="form" class="form-horizontal" action="uploads/login.php" method="POST">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input class="form-control" id="usuario" name="usuario" placeholder="Usuario" type="text" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input class="form-control" id="contraseña" name="contraseña" placeholder="Contraseña" type="password" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-light btn-radius btn-brd grd1">
                                        Entrar
                                    </button>
                                    <a class="for-pwd" href="javascript:;">¿Olvidaste tu contraseña?</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- LOADER -->
<div id="preloader">
    <div class="loader-container">
        <div class="progress-br float shadow">
            <div class="progress__item"></div>
        </div>
    </div>
</div>
<!-- END LOADER -->

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
</body>
</html>
