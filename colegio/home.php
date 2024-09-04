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
        $secciones[$row['identifier']] = urldecode($row['texto']);  // Decodificar texto
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

<!-- Código HTML adicional para la página -->
<div id="carouselExampleControls" class="carousel slide bs-slider box-slider" data-ride="carousel" data-pause="hover" data-interval="false">
    <div class="carousel-inner" role="listbox">
        <div class="carousel-item active">
            <div id="home" class="first-section" style="background-image:url('images/slider-01.jpg');">
                <div class="dtab">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 text-right">
                                <div class="big-tagline">
                                    <h2><strong>Escuela de Lenguaje</strong> Niño Jesús</h2>
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
                                    <h2><strong>Excelencia</strong> Académica</h2>
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
                                </div>
                            </div>
                        </div><!-- end row -->            
                    </div><!-- end container -->
                </div>
            </div><!-- end section -->
        </div>
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

<!-- Controles de audio y reproducción -->
<audio id="backgroundAudio" autoplay loop>
    <source src="audio/La ronda de los amigos - Mazapan.mp3" type="audio/mpeg">
</audio>
<div class="audio-controls">
    <button id="playPauseBtn" class="btn btn-primary">Pausa</button>
</div>



<!-- Nueva sección de Noticias -->
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

<!-- Mostrar la imagen principal debajo de las noticias -->
<div class="text-center mt-4">
    <img src="images/1000253916.jpg" style="width: 80%; height: auto;" alt="Imagen Principal">
</div>

<!-- Información sobre quienes somos -->
<div id="overviews" class="section wb">
    <div class="container">
        <div class="section-title row text-center">
            <div class="col-md-8 offset-md-2">
                <h3>Quienes somos</h3>
                <div class="editable-container">
                    <p class="lead editable-content" data-key="quienes_somos" contenteditable="true">
                        <?php echo isset($secciones['quienes_somos']) ? htmlspecialchars($secciones['quienes_somos']) : 'Texto predeterminado para quienes somos'; ?>
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
                    <h2> Bienvenidos a la Escuela de Lenguaje Niño Jesús</h2>
                    <div class="editable-container">
                        <p class="editable-content" data-key="bienvenida" contenteditable="true">
                            <?php echo isset($secciones['bienvenida']) ? htmlspecialchars($secciones['bienvenida']) : 'Texto predeterminado para bienvenida'; ?>
                        </p>
                        <div class="edit-actions" style="display: none;">
                            <button class="save-btn">Guardar</button>
                            <button class="cancel-btn">Cancelar</button>
                        </div>
                    </div>

                    <div class="editable-container">
                        <p class="editable-content" data-key="bienvenida_2" contenteditable="true">
                            <?php echo isset($secciones['bienvenida_2']) ? htmlspecialchars($secciones['bienvenida_2']) : 'Texto predeterminado para bienvenida 2'; ?>
                        </p>
                        <div class="edit-actions" style="display: none;">
                            <button class="save-btn">Guardar</button>
                            <button class="cancel-btn">Cancelar</button>
                        </div>
                    </div>
                </div><!-- end messagebox -->
            </div><!-- end col -->
            
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="message-box">
                    <h2>Logros</h2>
                    <div class="editable-container">
                        <p class="editable-content" data-key="logros" contenteditable="true">
                            <?php echo isset($secciones['logros']) ? htmlspecialchars($secciones['logros']) : 'Texto predeterminado para logros'; ?>
                        </p>
                        <div class="edit-actions" style="display: none;">
                            <button class="save-btn">Guardar</button>
                            <button class="cancel-btn">Cancelar</button>
                        </div>
                    </div>

                    <div class="editable-container">
                        <p class="editable-content" data-key="logros_2" contenteditable="true">
                            <?php echo isset($secciones['logros_2']) ? htmlspecialchars($secciones['logros_2']) : 'Texto predeterminado para logros 2'; ?>
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

<!-- linea de tiempo -->
<section class="section lb page-section">
    <div class="container">
        <div class="section-title row text-center">
            <div class="col-md-8 offset-md-2">
                <h3>Nuestra historia</h3>
                <div class="editable-container">
                    <p class="lead editable-content" data-key="nuestra_historia" contenteditable="true">
                        <?php echo isset($secciones['nuestra_historia']) ? htmlspecialchars($secciones['nuestra_historia']) : 'Texto predeterminado para nuestra historia'; ?>
                    </p>
                    <div class="timeline-edit-actions" style="display: none;">
                        <button class="timeline-save-btn">Guardar</button>
                    </div>
                </div>
            </div>
        </div><!-- end title -->
        <div class="timeline">
            <div class="timeline__wrap">
                <div class="timeline__items">
                    <div class="timeline__item">
                        <div class="timeline__content img-bg-01">
                            <div class="editable-container">
                                <p class="editable-content" data-key="nuestra_historia_2018" contenteditable="true">
                                    <?php echo isset($secciones['nuestra_historia_2018']) ? htmlspecialchars($secciones['nuestra_historia_2018']) : 'Texto predeterminado para nuestra historia 2018'; ?>
                                </p>
                                <div class="timeline-edit-actions" style="display: none;">
                                    <button class="timeline-save-btn">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="timeline__item">
                        <div class="timeline__content img-bg-02">
                            <div class="editable-container">
                                <p class="editable-content" data-key="nuestra_historia_2015" contenteditable="true">
                                    <?php echo isset($secciones['nuestra_historia_2015']) ? htmlspecialchars($secciones['nuestra_historia_2015']) : 'Texto predeterminado para nuestra historia 2015'; ?>
                                </p>
                                <div class="timeline-edit-actions" style="display: none;">
                                    <button class="timeline-save-btn">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="timeline__item">
                        <div class="timeline__content img-bg-03">
                            <div class="editable-container">
                                <p class="editable-content" data-key="nuestra_historia_2014" contenteditable="true">
                                    <?php echo isset($secciones['nuestra_historia_2014']) ? htmlspecialchars($secciones['nuestra_historia_2014']) : 'Texto predeterminado para nuestra historia 2014'; ?>
                                </p>
                                <div class="timeline-edit-actions" style="display: none;">
                                    <button class="timeline-save-btn">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="timeline__item">
                        <div class="timeline__content img-bg-04">
                            <div class="editable-container">
                                <p class="editable-content" data-key="nuestra_historia_2012" contenteditable="true">
                                    <?php echo isset($secciones['nuestra_historia_2012']) ? htmlspecialchars($secciones['nuestra_historia_2012']) : 'Texto predeterminado para nuestra historia 2012'; ?>
                                </p>
                                <div class="timeline-edit-actions" style="display: none;">
                                    <button class="timeline-save-btn">Guardar</button>
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
                    <p class="stat_count editable-content" data-key="estadisticas_estudiantes" contenteditable="true"><?php echo isset($secciones['estadisticas_estudiantes']) ? htmlspecialchars($secciones['estadisticas_estudiantes']) : '0'; ?></p>
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
                    <p class="stat_count editable-content" data-key="estadisticas_cursos" contenteditable="true"><?php echo isset($secciones['estadisticas_cursos']) ? htmlspecialchars($secciones['estadisticas_cursos']) : '0'; ?></p>
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
                    <p class="stat_count editable-content" data-key="estadisticas_anos_funcionando" contenteditable="true"><?php echo isset($secciones['estadisticas_anos_funcionando']) ? htmlspecialchars($secciones['estadisticas_anos_funcionando']) : '0'; ?></p>
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

<?php include 'footer.php'; ?>

<!-- Script para controlar el audio -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const audio = document.getElementById('backgroundAudio');
    const playPauseBtn = document.getElementById('playPauseBtn');

    // Configurar el botón para reproducir o pausar
    playPauseBtn.addEventListener('click', function () {
        if (audio.paused) {
            audio.play();
            playPauseBtn.textContent = 'Pausa';
        } else {
            audio.pause();
            playPauseBtn.textContent = 'Reproducir';
        }
    });

    // Iniciar con el botón en estado de pausa si el audio está reproduciéndose
    if (!audio.paused) {
        playPauseBtn.textContent = 'Pausa';
    } else {
        playPauseBtn.textContent = 'Reproducir';
    }
});


</script>
