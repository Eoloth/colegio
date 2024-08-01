<?php
session_start();
require_once 'header.php';
require_once 'navbar.php';
require_once 'uploads/config.php';

// Conexión a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Establecer la conexión en utf8mb4
$conn->set_charset("utf8mb4");

// Obtener todo el contenido de la tabla 'about'
$sql = "SELECT * FROM about";
$result = $conn->query($sql);
$secciones = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $secciones[$row['identifier']] = $row['texto'];
        $secciones[$row['identifier'] . '_imagen'] = $row['imagen'];
    }
}
$conn->close();
?>

<!-- Mostrar mensaje de sesión -->
<?php
if (isset($_SESSION['mensaje'])) {
    echo '<div class="alert alert-info" role="alert">' . $_SESSION['mensaje'] . '</div>';
    unset($_SESSION['mensaje']);
}
?>

<!-- Contenido de la página -->
<div class="all-title-box">
    <div class="container text-center">
        <h1 class="editable-container"><strong>Escuela de Lenguaje Niño Jesús</strong></h1>
        <div class="editable-container">
            <div class="edit-actions" style="display: none;">
                <button class="save-btn">Guardar</button>
                <button class="cancel-btn">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div id="overviews" class="section lb">
    <div class="container">
        <div class="section-title row text-center">
            <div class="col-md-8 offset-md-2">
                <h3 class="editable-container"><strong>Acerca de la escuela</strong></h3>
                <div class="editable-container">
                    <p class="lead editable-content" data-key="about_awards" contenteditable="true">
                        <?php echo isset($secciones['about_awards']) ? $secciones['about_awards'] : 'Texto predeterminado para la descripción'; ?>
                    </p>
                    <div class="edit-actions" style="display: none;">
                        <button class="save-btn">Guardar</button>
                        <button class="cancel-btn">Cancelar</button>
                    </div>
                </div>
            </div>
        </div><!-- end title -->

        <div class="row align-items-center">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="message-box">
                    <h4 class="editable-container"><strong>Escuela de Lenguaje</strong></h4>
                    <h2 class="editable-container"><strong>Niño Jesús</strong></h2>
                    <div class="editable-container">
                        <p class="editable-content" data-key="about_awards" contenteditable="true">
                            <?php echo isset($secciones['about_awards']) ? $secciones['about_awards'] : 'Texto predeterminado para la descripción'; ?>
                        </p>
                        <div class="edit-actions" style="display: none;">
                            <button class="save-btn">Guardar</button>
                            <button class="cancel-btn">Cancelar</button>
                        </div>
                    </div>
                </div><!-- end messagebox -->
            </div><!-- end col -->
        </div><!-- end row -->
    </div><!-- end container -->
</div><!-- end section -->

<div class="hmv-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-12">
                <div class="inner-hmv">
                    <div class="icon-box-hmv"><i class="flaticon-achievement"></i></div>
                    <h3 class="editable-container"><strong>Misión</strong></h3>
                    <div class="editable-container">
                        <p class="editable-content" data-key="about_mission" contenteditable="true">
                            <?php echo isset($secciones['about_mission']) ? $secciones['about_mission'] : 'Texto predeterminado para la misión'; ?>
                        </p>
                        <div class="edit-actions" style="display: none;">
                            <button class="save-btn">Guardar</button>
                            <button class="cancel-btn">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12">
                <div class="inner-hmv">
                    <div class="icon-box-hmv"><i class="flaticon-eye"></i></div>
                    <h3 class="editable-container"><strong>Visión</strong></h3>
                    <div class="editable-container">
                        <p class="editable-content" data-key="about_vision" contenteditable="true">
                            <?php echo isset($secciones['about_vision']) ? $secciones['about_vision'] : 'Texto predeterminado para la visión'; ?>
                        </p>
                        <div class="edit-actions" style="display: none;">
                            <button class="save-btn">Guardar</button>
                            <button class="cancel-btn">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12">
                <div class="inner-hmv">
                    <div class="icon-box-hmv"><i class="flaticon-history"></i></div>
                    <h3 class="editable-container"><strong>Historia</strong></h3>
                    <div class="editable-container">
                        <p class="editable-content" data-key="about_history" contenteditable="true">
                            <?php echo isset($secciones['about_history']) ? $secciones['about_history'] : 'Texto predeterminado para la historia'; ?>
                        </p>
                        <div class="edit-actions" style="display: none;">
                            <button class="save-btn">Guardar</button>
                            <button class="cancel-btn">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include 'footer.php'; ?>

<a href="#" id="scroll-to-top" class="dmtop global-radius"><i class="fa fa-angle-up"></i></a>

<!-- ALL JS FILES -->
<script src="js/all.js"></script>
<!-- ALL PLUGINS -->
<script src="js/custom.js"></script>

</body>
</html>
