<?php
session_start();
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
                                        <p class="lead editable-content" data-key="slider_text_1" contenteditable="true">
                                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eveniet aliquam, dicta facilis, tenetur explicabo perspiciatis quia laborum praesentium qui consequatur provident fuga aut. Ab earum aut expedita, delectus voluptatum omnis!
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
                                        <p class="lead editable-content" data-key="slider_text_2" contenteditable="true">
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ducimus accusamus consequatur cum perferendis error totam id. Numquam sint officiis debitis ad nostrum iure vitae, consectetur deleniti eaque similique inventore?
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
                                        <p class="lead editable-content" data-key="slider_text_3" contenteditable="true">
                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit excepturi aliquid expedita inventore molestias aspernatur cum alias vitae magnam harum, repellendus doloribus aliquam ratione? Amet quidem at sequi corrupti libero!
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
                    <p class="lead editable-content" data-key="quienes_somos_text" contenteditable="true">
                        Lorem Ipsum dolroin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem!
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
                        <p class="editable-content" data-key="bienvenidos_text" contenteditable="true">
                            Quisque eget nisl id nulla sagittis auctor quis id. Aliquam quis vehicula enim, non aliquam risus. Sed a tellus quis mi rhoncus dignissim.
                        </p>
                        <div class="edit-actions" style="display: none;">
                            <button class="save-btn">Guardar</button>
                            <button class="cancel-btn">Cancelar</button>
                        </div>
                    </div>

                    <div class="editable-container">
                        <p class="editable-content" data-key="bienvenidos_text_2" contenteditable="true">
                            Integer rutrum ligula eu dignissim laoreet. Pellentesque venenatis nibh sed tellus faucibus bibendum. Sed fermentum est vitae rhoncus molestie. Cum sociis natoque penatibus et magnis montes, nascetur ridiculus mus. Sed vitae rutrum neque.
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
                    <img src="images/about_02.jpg" alt="" class="img-fluid img-rounded">
                    <?php if (isset($_SESSION['usuario'])): ?>
                        <a href="uploads/upload_image_home.php?section=image_about_02" class="edit-icon">
                            <i class="fas fa-edit"></i>
                        </a>
                    <?php endif; ?>
                </div><!-- end media -->
            </div><!-- end col -->
        </div>
        <div class="row align-items-center">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="post-media wow fadeIn">
                    <img src="images/about_03.jpg" alt="" class="img-fluid img-rounded">
                    <?php if (isset($_SESSION['usuario'])): ?>
                        <a href="uploads/upload_image_home.php?section=image_about_03" class="edit-icon">
                            <i class="fas fa-edit"></i>
                        </a>
                    <?php endif; ?>
                </div><!-- end media -->
            </div><!-- end col -->
            
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="message-box">
                    <h2>Logros</h2>
                    <div class="editable-container">
                        <p class="editable-content" data-key="logros_text" contenteditable="true">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                        <div class="edit-actions" style="display: none;">
                            <button class="save-btn">Guardar</button>
                            <button class="cancel-btn">Cancelar</button>
                        </div>
                    </div>

                    <div class="editable-container">
                        <p class="editable-content" data-key="logros_text_2" contenteditable="true">
                            Integer rutrum ligula eu dignissim laoreet. Pellentesque venenatis nibh sed tellus faucibus bibendum.
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
                    <p class="lead editable-content" data-key="historia_text" contenteditable="true">
                        Lorem Ipsum dolroin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem!
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
                                <p class="editable-content" data-key="historia_2018_text" contenteditable="true">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim neque condimentum lacus dapibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
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
                                <p class="editable-content" data-key="historia_2015_text" contenteditable="true">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim neque condimentum lacus dapibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
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
                                <p class="editable-content" data-key="historia_2014_text" contenteditable="true">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim neque condimentum lacus dapibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
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
                                <p class="editable-content" data-key="historia_2012_text" contenteditable="true">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim neque condimentum lacus dapibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
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
                                <p class="editable-content" data-key="historia_2010_text" contenteditable="true">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim neque condimentum lacus dapibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
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
                                <p class="editable-content" data-key="historia_2007_text" contenteditable="true">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim neque condimentum lacus dapibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
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
                                <p class="editable-content" data-key="historia_2004_text" contenteditable="true">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim neque condimentum lacus dapibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
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
                                <p class="editable-content" data-key="historia_2002_text" contenteditable="true">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim neque condimentum lacus dapibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
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
                    <p class="stat_count editable-content" data-key="stat_estudiantes" contenteditable="true">100</p>
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
                    <p class="stat_count editable-content" data-key="stat_cursos" contenteditable="true">20</p>
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
                    <p class="stat_count editable-content" data-key="stat_anos_funcionando" contenteditable="true">5</p>
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Mostrar botones de edición al hacer clic en el contenido editable
    document.querySelectorAll('.editable-content').forEach(function (element) {
        element.addEventListener('click', function () {
            var parent = element.closest('.editable-container');
            parent.querySelector('.edit-actions').style.display = 'block';
        });
    });

    // Cancelar edición
    document.querySelectorAll('.cancel-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            var parent = button.closest('.editable-container');
            parent.querySelector('.edit-actions').style.display = 'none';
        });
    });

    // Guardar cambios (ejemplo simple, debe ajustarse para enviar al servidor)
    document.querySelectorAll('.save-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            var parent = button.closest('.editable-container');
            var content = parent.querySelector('.editable-content').textContent;
            var key = parent.querySelector('.editable-content').getAttribute('data-key');

            // Aquí puedes hacer una llamada AJAX para enviar los cambios al servidor
            console.log('Guardar', key, content);
            parent.querySelector('.edit-actions').style.display = 'none';
        });
    });
});
</script>


<?php include 'footer.php'; ?>
