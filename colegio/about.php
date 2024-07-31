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
        <h1 class="editable-container"><strong>About</strong>
        </h1>
        <div class="editable-container">
            <p class="lead editable-content" data-key="about_intro" contenteditable="true">
                <?php echo isset($secciones['about_intro']) ? $secciones['about_intro'] : 'Texto predeterminado para la introducción'; ?>
            </p>
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
                <h3 class="editable-container"><strong>About</strong></h3>
                <div class="editable-container">
                    <p class="lead editable-content" data-key="about_awards" contenteditable="true">
                        <?php echo isset($secciones['about_awards']) ? $secciones['about_awards'] : 'Texto predeterminado para la descripción de los premios'; ?>
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
                    <h4 class="editable-container"><strong>2018 BEST SmartEDU education school</strong></h4>
                    <h2 class="editable-container"><strong>Awards Winner Support Center</strong></h2>
                    <div class="editable-container">
                        <p class="editable-content" data-key="about_awards" contenteditable="true">
                            <?php echo isset($secciones['about_awards']) ? $secciones['about_awards'] : 'Texto predeterminado para la descripción de los premios'; ?>
                        </p>
                        <div class="edit-actions" style="display: none;">
                            <button class="save-btn">Guardar</button>
                            <button class="cancel-btn">Cancelar</button>
                        </div>
                    </div>
                    <a href="#" class="hover-btn-new orange"><span>Learn More</span></a>
                </div><!-- end messagebox -->
            </div><!-- end col -->

            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="post-media wow fadeIn">
                    <div class="editable-image-container">
                        <img src="<?php echo isset($secciones['about_awards_imagen']) ? 'uploads/' . $secciones['about_awards_imagen'] : 'images/about_01.jpg'; ?>" alt="" class="img-fluid img-rounded">
                        <?php if (isset($_SESSION['usuario'])): ?>
                            <a href="#" class="edit-image-icon" data-section="about_awards_imagen">
                                <i class="fas fa-edit"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div><!-- end media -->
            </div><!-- end col -->
        </div><!-- end row -->

        <div class="row align-items-center">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="post-media wow fadeIn">
                    <div class="editable-image-container">
                        <img src="<?php echo isset($secciones['about_standard_imagen']) ? 'uploads/' . $secciones['about_standard_imagen'] : 'images/about_02.jpg'; ?>" alt="" class="img-fluid img-rounded">
                        <?php if (isset($_SESSION['usuario'])): ?>
                            <a href="#" class="edit-image-icon" data-section="about_standard_imagen">
                                <i class="fas fa-edit"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div><!-- end media -->
            </div><!-- end col -->

            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="message-box">
                    <h2 class="editable-container"><strong>The standard Lorem Ipsum passage, used since the 1500s</strong></h2>
                    <div class="editable-container">
                        <p class="editable-content" data-key="about_standard" contenteditable="true">
                            <?php echo isset($secciones['about_standard']) ? $secciones['about_standard'] : 'Texto predeterminado para la historia'; ?>
                        </p>
                        <div class="edit-actions" style="display: none;">
                            <button class="save-btn">Guardar</button>
                            <button class="cancel-btn">Cancelar</button>
                        </div>
                    </div>
                    <a href="#" class="hover-btn-new orange"><span>Learn More</span></a>
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
                    <h3 class="editable-container"><strong>Mission</strong></h3>
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
                    <h3 class="editable-container"><strong>Vision</strong></h3>
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
                    <h3 class="editable-container"><strong>History</strong></h3>
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

<div class="parallax section dbcolor">
    <div class="container">
        <div class="row logos">
            <div class="col-md-2 col-sm-2 col-xs-6 wow fadeInUp">
                <a href="#"><img src="images/logo_01.png" alt="" class="img-repsonsive"></a>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-6 wow fadeInUp">
                <a href="#"><img src="images/logo_02.png" alt="" class="img-repsonsive"></a>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-6 wow fadeInUp">
                <a href="#"><img src="images/logo_03.png" alt="" class="img-repsonsive"></a>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-6 wow fadeInUp">
                <a href="#"><img src="images/logo_04.png" alt="" class="img-repsonsive"></a>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-6 wow fadeInUp">
                <a href="#"><img src="images/logo_05.png" alt="" class="img-repsonsive"></a>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-6 wow fadeInUp">
                <a href="#"><img src="images/logo_06.png" alt="" class="img-repsonsive"></a>
            </div>
        </div><!-- end row -->
    </div><!-- end container -->
</div><!-- end section -->

<?php include 'footer.php'; ?>

<a href="#" id="scroll-to-top" class="dmtop global-radius"><i class="fa fa-angle-up"></i></a>

<!-- Modal para subir imágenes -->
<div id="uploadImageModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="uploadImageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadImageModalLabel">Subir Imagen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="uploadImageForm" action="uploads/upload_image_about.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="section" id="modalSection" value="">
                    <div class="form-group">
                        <label for="imageFile">Seleccionar imagen</label>
                        <input type="file" class="form-control-file" id="imageFile" name="imageFile" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Subir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ALL JS FILES -->
<script src="js/all.js"></script>
<!-- ALL PLUGINS -->
<script src="js/custom.js"></script>

</body>
</html>
