<?php
session_start();
require_once 'uploads/config.php';

// Conexión a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener todo el contenido de la tabla 'home'
$sql = "SELECT * FROM home";
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
    <?php if (isset($_SESSION['usuario'])): ?>
        <!-- Contenido del panel de administrador -->
        <div class="admin-panel">
            <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</h2>
            <br><br>
            <a href="home.php?edit=true" class="btn btn-info">Administrar Contenido de Inicio</a>
            <a href="uploads/list_events.php" class="btn btn-info">Administrar Eventos</a>
            <a href="uploads/list_images.php" class="btn btn-info">Administrar Galería de Imágenes</a>
        </div>
    <?php endif; ?>
</div>

<!-- Resto del contenido de tu página -->
<div id="carouselExampleControls" class="carousel slide bs-slider box-slider" data-ride="carousel" data-pause="hover" data-interval="false">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleControls" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleControls" data-slide-to="1"></li>
        <li data-target="#carouselExampleControls" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
        <div class="carousel-item active">
            <div id="home" class="first-section" style="background-image:url('images/slider-01.jpg');">
                <div class="dtab">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 text-right">
                                <div class="big-tagline">
                                    <h2><strong>Escuela de Lenguaje</strong> Niño Jesús</h2>
                                    <div class="editable-container">
                                        <p class="lead editable-content" data-key="carrusel_escuela" contenteditable="true">
                                            <?php echo isset($secciones['carrusel_escuela']) ? $secciones['carrusel_escuela'] : 'Texto predeterminado para carrusel escuela'; ?>
                                        </p>
                                        <div class="edit-actions" style="display: none;">
                                            <button class="save-btn">Guardar</button>
                                            <button class="cancel-btn">Cancelar</button>
                                        </div>
                                    </div>
                                    <a href="#" class="hover-btn-new"><span>Contacto</span></a>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="#" class="hover-btn-new"><span>Más Información</span></a>
                                </div>
                            </div>
                        </div><!-- end row -->            
                    </div><!-- end container -->
                </div>
            </div><!-- end section -->
        </div>
        <div class="carousel-item">
            <div id="home" class="first-section" style="background-image:url('images/slider-02.jpg');">
                <div class="dtab">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 text-left">
                                <div class="big-tagline">
                                    <h2 data-animation="animated zoomInRight">Texto a reemplazar <strong>educación</strong></h2>
                                    <div class="editable-container">
                                        <p class="lead editable-content" data-key="carrusel_educacion" contenteditable="true">
                                            <?php echo isset($secciones['carrusel_educacion']) ? $secciones['carrusel_educacion'] : 'Texto predeterminado para carrusel educación'; ?>
                                        </p>
                                        <div class="edit-actions" style="display: none;">
                                            <button class="save-btn">Guardar</button>
                                            <button class="cancel-btn">Cancelar</button>
                                        </div>
                                    </div>
                                    <a href="#" class="hover-btn-new"><span>Contacto</span></a>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="#" class="hover-btn-new"><span>Más Información</span></a>
                                </div>
                            </div>
                        </div><!-- end row -->            
                    </div><!-- end container -->
                </div>
            </div><!-- end section -->
        </div>
        <div class="carousel-item">
            <div id="home" class="first-section" style="background-image:url('images/slider-03.jpg');">
                <div class="dtab">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 text-center">
                                <div class="big-tagline">
                                    <h2 data-animation="animated zoomInRight"><strong>Eventos</strong> y graduaciones</h2>
                                    <div class="editable-container">
                                        <p class="lead editable-content" data-key="carrusel_eventos" contenteditable="true">
                                            <?php echo isset($secciones['carrusel_eventos']) ? $secciones['carrusel_eventos'] : 'Texto predeterminado para carrusel eventos'; ?>
                                        </p>
                                        <div class="edit-actions" style="display: none;">
                                            <button class="save-btn">Guardar</button>
                                            <button class="cancel-btn">Cancelar</button>
                                        </div>
                                    </div>
                                    <a href="#" class="hover-btn-new"><span>Contacto</span></a>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="#" class="hover-btn-new"><span>Más Información</span></a>
                                </div>
                            </div>
                        </div><!-- end row -->            
                    </div><!-- end container -->
                </div>
            </div><!-- end section -->
        </div>
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

<div id="overviews" class="section wb">
    <div class="container">
        <div class="section-title row text-center">
            <div class="col-md-8 offset-md-2">
                <h3>Quienes somos</h3>
                <div class="editable-container">
                    <p class="lead editable-content" data-key="quienes_somos" contenteditable="true">
                        <?php echo isset($secciones['quienes_somos']) ? $secciones['quienes_somos'] : 'Texto predeterminado para quienes somos'; ?>
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
                    <h4>2018</h4>
                    <h2> Bienvenidos a la Escuela de Lenguaje Niño Jesús</h2>
                    <div class="editable-container">
                        <p class="editable-content" data-key="bienvenida" contenteditable="true">
                            <?php echo isset($secciones['bienvenida']) ? $secciones['bienvenida'] : 'Texto predeterminado para bienvenida'; ?>
                        </p>
                        <div class="edit-actions" style="display: none;">
                            <button class="save-btn">Guardar</button>
                            <button class="cancel-btn">Cancelar</button>
                        </div>
                    </div>

                    <div class="editable-container">
                        <p class="editable-content" data-key="bienvenida_2" contenteditable="true">
                            <?php echo isset($secciones['bienvenida_2']) ? $secciones['bienvenida_2'] : 'Texto predeterminado para bienvenida 2'; ?>
                        </p>
                        <div class="edit-actions" style="display: none;">
                            <button class="save-btn">Guardar</button>
                            <button class="cancel-btn">Cancelar</button>
                        </div>
                    </div>
                </div><!-- end messagebox -->
            </div><!-- end col -->
            
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="post-media wow fadeIn">
                    <div class="editable-image-container">
                        <img src="<?php echo isset($secciones['bienvenida_imagen']) ? 'uploads/' . $secciones['bienvenida_imagen'] : 'images/about_02.jpg'; ?>" alt="" class="img-fluid img-rounded">
                        <?php if (isset($_SESSION['usuario'])): ?>
                            <a href="#" class="edit-image-icon" data-section="bienvenida_imagen">
                                <i class="fas fa-edit"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div><!-- end media -->
            </div><!-- end col -->

            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="post-media wow fadeIn">
                        <div class="editable-image-container">
                            <img src="<?php echo isset($secciones['logros_imagen']) ? 'uploads/' . $secciones['logros_imagen'] : 'images/about_03.jpg'; ?>" alt="" class="img-fluid img-rounded">
                            <?php if (isset($_SESSION['usuario'])): ?>
                                <a href="#" class="edit-image-icon" data-section="logros_imagen">
                                    <i class="fas fa-edit"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div><!-- end media -->
                </div><!-- end col -->
            </div>

            
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="message-box">
                    <h2>Logros</h2>
                    <div class="editable-container">
                        <p class="editable-content" data-key="logros" contenteditable="true">
                            <?php echo isset($secciones['logros']) ? $secciones['logros'] : 'Texto predeterminado para logros'; ?>
                        </p>
                        <div class="edit-actions" style="display: none;">
                            <button class="save-btn">Guardar</button>
                            <button class="cancel-btn">Cancelar</button>
                        </div>
                    </div>

                    <div class="editable-container">
                        <p class="editable-content" data-key="logros_2" contenteditable="true">
                            <?php echo isset($secciones['logros_2']) ? $secciones['logros_2'] : 'Texto predeterminado para logros 2'; ?>
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

<section class="section lb page-section">
    <div class="container">
        <div class="section-title row text-center">
            <div class="col-md-8 offset-md-2">
                <h3>Nuestra historia</h3>
                <div class="editable-container">
                    <p class="lead editable-content" data-key="nuestra_historia" contenteditable="true">
                        <?php echo isset($secciones['nuestra_historia']) ? $secciones['nuestra_historia'] : 'Texto predeterminado para nuestra historia'; ?>
                    </p>
                    <div class="edit-actions" style="display: none;">
                        <button class="save-btn">Guardar</button>
                        <button class="cancel-btn">Cancelar</button>
                    </div>
                </div>
            </div>
        </div><!-- end title -->
        <div class="timeline">
            <div class="timeline__wrap">
                <div class="timeline__items">
                    <div class="timeline__item">
                        <div class="timeline__content img-bg-01">
                            <h2>2018</h2>
                            <div class="editable-container">
                                <p class="editable-content" data-key="nuestra_historia_2018" contenteditable="true">
                                    <?php echo isset($secciones['nuestra_historia_2018']) ? $secciones['nuestra_historia_2018'] : 'Texto predeterminado para nuestra historia 2018'; ?>
                                </p>
                                <div class="edit-actions" style="display: none;">
                                    <button class="save-btn">Guardar</button>
                                    <button class="cancel-btn">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="timeline__item">
                        <div class="timeline__content img-bg-02">
                            <h2>2015</h2>
                            <div class="editable-container">
                                <p class="editable-content" data-key="nuestra_historia_2015" contenteditable="true">
                                    <?php echo isset($secciones['nuestra_historia_2015']) ? $secciones['nuestra_historia_2015'] : 'Texto predeterminado para nuestra historia 2015'; ?>
                                </p>
                                <div class="edit-actions" style="display: none;">
                                    <button class="save-btn">Guardar</button>
                                    <button class="cancel-btn">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="timeline__item">
                        <div class="timeline__content img-bg-03">
                            <h2>2014</h2>
                            <div class="editable-container">
                                <p class="editable-content" data-key="nuestra_historia_2014" contenteditable="true">
                                    <?php echo isset($secciones['nuestra_historia_2014']) ? $secciones['nuestra_historia_2014'] : 'Texto predeterminado para nuestra historia 2014'; ?>
                                </p>
                                <div class="edit-actions" style="display: none;">
                                    <button class="save-btn">Guardar</button>
                                    <button class="cancel-btn">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="timeline__item">
                        <div class="timeline__content img-bg-04">
                            <h2>2012</h2>
                            <div class="editable-container">
                                <p class="editable-content" data-key="nuestra_historia_2012" contenteditable="true">
                                    <?php echo isset($secciones['nuestra_historia_2012']) ? $secciones['nuestra_historia_2012'] : 'Texto predeterminado para nuestra historia 2012'; ?>
                                </p>
                                <div class="edit-actions" style="display: none;">
                                    <button class="save-btn">Guardar</button>
                                    <button class="cancel-btn">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="timeline__item">
                        <div class="timeline__content img-bg-01">
                            <h2>2010</h2>
                            <div class="editable-container">
                                <p class="editable-content" data-key="nuestra_historia_2010" contenteditable="true">
                                    <?php echo isset($secciones['nuestra_historia_2010']) ? $secciones['nuestra_historia_2010'] : 'Texto predeterminado para nuestra historia 2010'; ?>
                                </p>
                                <div class="edit-actions" style="display: none;">
                                    <button class="save-btn">Guardar</button>
                                    <button class="cancel-btn">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="timeline__item">
                        <div class="timeline__content img-bg-02">
                            <h2>2007</h2>
                            <div class="editable-container">
                                <p class="editable-content" data-key="nuestra_historia_2007" contenteditable="true">
                                    <?php echo isset($secciones['nuestra_historia_2007']) ? $secciones['nuestra_historia_2007'] : 'Texto predeterminado para nuestra historia 2007'; ?>
                                </p>
                                <div class="edit-actions" style="display: none;">
                                    <button class="save-btn">Guardar</button>
                                    <button class="cancel-btn">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="timeline__item">
                        <div class="timeline__content img-bg-03">
                            <h2>2004</h2>
                            <div class="editable-container">
                                <p class="editable-content" data-key="nuestra_historia_2004" contenteditable="true">
                                    <?php echo isset($secciones['nuestra_historia_2004']) ? $secciones['nuestra_historia_2004'] : 'Texto predeterminado para nuestra historia 2004'; ?>
                                </p>
                                <div class="edit-actions" style="display: none;">
                                    <button class="save-btn">Guardar</button>
                                    <button class="cancel-btn">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="timeline__item">
                        <div class="timeline__content img-bg-04">
                            <h2>2002</h2>
                            <div class="editable-container">
                                <p class="editable-content" data-key="nuestra_historia_2002" contenteditable="true">
                                    <?php echo isset($secciones['nuestra_historia_2002']) ? $secciones['nuestra_historia_2002'] : 'Texto predeterminado para nuestra historia 2002'; ?>
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
    </div>
</section>

<div class="section cl">
    <div class="container">
        <div class="row text-left stat-wrap">
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="editable-container">
                    <span data-scroll class="global-radius icon_wrap effect-1 alignleft"><i class="flaticon-study"></i></span>
                    <p class="stat_count editable-content" data-key="estadisticas_estudiantes" contenteditable="true"><?php echo isset($secciones['estadisticas_estudiantes']) ? $secciones['estadisticas_estudiantes'] : '0'; ?></p>
                    <h3>Estudiantes</h3>
                    <div class="edit-actions" style="display: none;">
                        <button class="save-btn">Guardar</button>
                        <button class="cancel-btn">Cancelar</button>
                    </div>
                </div>
            </div><!-- end col -->

            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="editable-container">
                    <span data-scroll class="global-radius icon_wrap effect-1 alignleft"><i class="flaticon-online"></i></span>
                    <p class="stat_count editable-content" data-key="estadisticas_cursos" contenteditable="true"><?php echo isset($secciones['estadisticas_cursos']) ? $secciones['estadisticas_cursos'] : '0'; ?></p>
                    <h3>Cursos</h3>
                    <div class="edit-actions" style="display: none;">
                        <button class="save-btn">Guardar</button>
                        <button class="cancel-btn">Cancelar</button>
                    </div>
                </div>
            </div><!-- end col -->

            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="editable-container">
                    <span data-scroll class="global-radius icon_wrap effect-1 alignleft"><i class="flaticon-years"></i></span>
                    <p class="stat_count editable-content" data-key="estadisticas_anos_funcionando" contenteditable="true"><?php echo isset($secciones['estadisticas_anos_funcionando']) ? $secciones['estadisticas_anos_funcionando'] : '0'; ?></p>
                    <h3>Años funcionando</h3>
                    <div class="edit-actions" style="display: none;">
                        <button class="save-btn">Guardar</button>
                        <button class="cancel-btn">Cancelar</button>
                    </div>
                </div>
            </div><!-- end col -->
        </div><!-- end row -->
    </div><!-- end container -->
</div><!-- end section -->

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
                <form id="uploadImageForm" action="uploads/upload_image_home.php" method="post" enctype="multipart/form-data">
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


<?php include 'footer.php'; ?>
