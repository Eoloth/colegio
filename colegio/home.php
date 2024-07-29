<?php
session_start();
require_once 'uploads/config.php';

try {
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT * FROM home ORDER BY id ASC");
    $stmt->execute();
    $homeData = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
?>

<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>

<div class="container">
    <?php if (isset($_SESSION['usuario'])): ?>
        <!-- Contenido del panel de administrador -->
        <div class="admin-panel">
            <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</h2>
            <br><br>
            <a href="uploads/admin_home.php" class="btn btn-info">Administrar Contenido de Inicio</a>
            <a href="uploads/list_events.php" class="btn btn-info">Administrar Eventos</a>
            <a href="uploads/list_images.php" class="btn btn-info">Administrar Galería de Imágenes</a>

        </div>
    <?php endif; ?>
</div>


<!-- Carrusel -->
<div id="carouselExampleControls" class="carousel slide bs-slider box-slider" data-ride="carousel" data-pause="hover" data-interval="false">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleControls" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleControls" data-slide-to="1"></li>
        <li data-target="#carouselExampleControls" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
        <?php
        $isActive = 'active';
        foreach ($homeData as $item) {
            if ($item['seccion'] == 'carrusel') {
                echo "<div class='carousel-item $isActive'>";
                echo "<div id='home' class='first-section' style='background-image:url(\"uploads/" . htmlspecialchars($item['imagen']) . "\");'>";
                echo "<div class='dtab'>";
                echo "<div class='container'>";
                echo "<div class='row'>";
                echo "<div class='col-md-12 col-sm-12 text-right'>";
                echo "<div class='big-tagline'>";
                echo "<h2><strong>" . htmlspecialchars($item['titulo']) . "</strong></h2>";
                echo "<p class='lead'>" . htmlspecialchars($item['texto']) . "</p>";
                if (isset($_SESSION['usuario'])) {
                    echo "<a href='#' class='edit-btn' data-toggle='modal' data-target='#editModal' data-id='{$item['id']}' data-titulo='" . htmlspecialchars($item['titulo']) . "' data-texto='" . htmlspecialchars($item['texto']) . "' data-imagen='" . htmlspecialchars($item['imagen']) . "'><i class='fa fa-edit'></i></a>";
                }
                echo "<a href='#' class='hover-btn-new'><span>Contacto</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                echo "<a href='#' class='hover-btn-new'><span>Más Información</span></a>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                $isActive = '';
            }
        }
        ?>
        <!-- Left Control -->
        <a class="new-effect carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="fa fa-angle-left" aria-hidden="true"></span>
            <span class="sr-only">Previa</span>
        </a>

        <!-- Right Control -->
        <a class="new-effect carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="fa fa-angle-right" aria-hidden="true"></span>
            <span class="sr-only">Próxima</span>
        </a>
    </div>
</div>

<!-- Sección Quienes somos -->
<div id="overviews" class="section wb">
    <div class="container">
        <div class="section-title row text-center">
            <div class="col-md-8 offset-md-2">
                <h3>Quienes somos</h3>
                <p class="lead"><?php echo htmlspecialchars($homeData[0]['texto']); ?></p>
                <?php if (isset($_SESSION['usuario'])): ?>
                    <a href="#" class="edit-btn" data-toggle="modal" data-target="#editModal" data-id="<?php echo $homeData[0]['id']; ?>" data-titulo="<?php echo htmlspecialchars($homeData[0]['titulo']); ?>" data-texto="<?php echo htmlspecialchars($homeData[0]['texto']); ?>" data-imagen="<?php echo htmlspecialchars($homeData[0]['imagen']); ?>"><i class="fa fa-edit"></i></a>
                <?php endif; ?>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="message-box">
                    <h4>2018 </h4>
                    <h2><?php echo htmlspecialchars($homeData[1]['titulo']); ?></h2>
                    <p><?php echo htmlspecialchars($homeData[1]['texto']); ?></p>
                    <?php if (isset($_SESSION['usuario'])): ?>
                        <a href="#" class="edit-btn" data-toggle="modal" data-target="#editModal" data-id="<?php echo $homeData[1]['id']; ?>" data-titulo="<?php echo htmlspecialchars($homeData[1]['titulo']); ?>" data-texto="<?php echo htmlspecialchars($homeData[1]['texto']); ?>" data-imagen="<?php echo htmlspecialchars($homeData[1]['imagen']); ?>"><i class="fa fa-edit"></i></a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="post-media wow fadeIn">
                    <img src="uploads/<?php echo htmlspecialchars($homeData[1]['imagen']); ?>" alt="" class="img-fluid img-rounded">
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="post-media wow fadeIn">
                    <img src="uploads/<?php echo htmlspecialchars($homeData[2]['imagen']); ?>" alt="" class="img-fluid img-rounded">
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="message-box">
                    <h2><?php echo htmlspecialchars($homeData[2]['titulo']); ?></h2>
                    <p><?php echo htmlspecialchars($homeData[2]['texto']); ?></p>
                    <?php if (isset($_SESSION['usuario'])): ?>
                        <a href="#" class="edit-btn" data-toggle="modal" data-target="#editModal" data-id="<?php echo $homeData[2]['id']; ?>" data-titulo="<?php echo htmlspecialchars($homeData[2]['titulo']); ?>" data-texto="<?php echo htmlspecialchars($homeData[2]['texto']); ?>" data-imagen="<?php echo htmlspecialchars($homeData[2]['imagen']); ?>"><i class="fa fa-edit"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editForm" action="uploads/actualizar_home.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Contenido</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="modal-id">
                    <div class="form-group">
                        <label for="modal-titulo">Título</label>
                        <input type="text" class="form-control" id="modal-titulo" name="titulo" required>
                    </div>
                    <div class="form-group">
                        <label for="modal-texto">Texto</label>
                        <textarea class="form-control" id="modal-texto" name="texto" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="modal-imagen">Imagen</label>
                        <input type="file" class="form-control" id="modal-imagen" name="imagen">
                        <small id="current-image" class="form-text text-muted"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#editModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var titulo = button.data('titulo')
        var texto = button.data('texto')
        var imagen = button.data('imagen')

        var modal = $(this)
        modal.find('.modal-body #modal-id').val(id)
        modal.find('.modal-body #modal-titulo').val(titulo)
        modal.find('.modal-body #modal-texto').val(texto)
        modal.find('.modal-body #current-image').text("Imagen actual: " + imagen)
    })
</script>

<?php include 'footer.php'; ?>
