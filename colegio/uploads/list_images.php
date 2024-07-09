<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Metas y otros elementos head -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">   
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Escuela Niño Jesús</title>  
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta property="og:title" content="Escuela Niño Jesús" />
    <meta property="og:description" content="Bienvenidos a la Escuela de Lenguaje Niño Jesús" />
    <meta property="og:image" content="https://tu-dominio.cl/path/to/logo.png" />
    <meta property="og:url" content="https://tu-dominio.cl/home.html" />
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/versions.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/custom.css">
    <script src="js/modernizer.js"></script>
</head>

<body class="host_version"> 

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

<!-- Start header -->
<header class="top-navbar">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.html">
                <img src="images/logo.png" alt="" />
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbars-host" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbars-host">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active"><a class="nav-link" href="index.html">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.html">Acerca de nosotros</a></li>
                    <li class="nav-item"><a class="nav-link" href="eventos.html">Eventos</a></li>
                    <li class="nav-item"><a class="nav-link" href="galeria.html">Galería de Imágenes</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.html">Contacto</a></li>
                    <li class="nav-item"><a class="nav-link" href="" data-toggle="modal" data-target="#login">Entrar</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<div class="container">
    <?php if (isset($_SESSION['usuario'])): ?>
        <!-- Contenido del panel de administrador -->
        <div class="admin-panel">
            <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</h2>
            <a href="uploads/logout.php">Cerrar sesión</a>
            <br><br>
            <a href="uploads/list_events.php" class="btn btn-info">Administrar Eventos</a>
            <a href="uploads/list_images.php" class="btn btn-info">Administrar Galería de Imágenes</a>
            <!-- Aquí puedes añadir el contenido de CRUD para eventos y galería de fotos -->
        </div>
    <?php else: ?>
        <!-- Contenido normal de la página -->
    <?php endif; ?>
</div>

<!-- Resto del contenido de tu página -->

<div id="carouselExampleControls" class="carousel slide bs-slider box-slider" data-ride="carousel" data-pause="hover" data-interval="false" >
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
                                    <p class="lead">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eveniet aliquam, dicta facilis, tenetur explicabo perspiciatis quia laborum praesentium qui consequatur provident fuga aut. Ab earum aut expedita, delectus voluptatum omnis! </p>
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
                                    <p class="lead" data-animation="animated fadeInLeft">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ducimus accusamus consequatur cum perferendis error totam id. Numquam sint officiis debitis ad nostrum iure vitae, consectetur deleniti eaque similique inventore? </p>
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
                                    <p class="lead" data-animation="animated fadeInLeft">Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit excepturi aliquid expedita inventore molestias aspernatur cum alias vitae magnam harum, repellendus doloribus aliquam ratione? Amet quidem at sequi corrupti libero!</p>
                                        <a href="#" class="hover-btn-new"><span>Contacto</span></a>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="#" class="hover-btn-new"><span>Más Information</span></a>
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
                <p class="lead">Lorem Ipsum dolroin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem!</p>
            </div>
        </div><!-- end title -->
    
        <div class="row align-items-center">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="message-box">
                    <h4>2018 </h4>
                    <h2> Bienvenidos a la Escuela de Lenguaje Niño Jesús</h2>
                    <p>Quisque eget nisl id nulla sagittis auctor quis id. Aliquam quis vehicula enim, non aliquam risus. Sed a tellus quis mi rhoncus dignissim.</p>

                    <p> Integer rutrum ligula eu dignissim laoreet. Pellentesque venenatis nibh sed tellus faucibus bibendum. Sed fermentum est vitae rhoncus molestie. Cum sociis natoque penatibus et magnis montes, nascetur ridiculus mus. Sed vitae rutrum neque. </p>

                    <a href="#" class="hover-btn-new orange"><span>Learn More</span></a>
                </div><!-- end messagebox -->
            </div><!-- end col -->
            
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="post-media wow fadeIn">
                    <img src="images/about_02.jpg" alt="" class="img-fluid img-rounded">
                </div><!-- end media -->
            </div><!-- end col -->
        </div>
        <div class="row align-items-center">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="post-media wow fadeIn">
                    <img src="images/about_03.jpg" alt="" class="img-fluid img-rounded">
                </div><!-- end media -->
            </div><!-- end col -->
            
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="message-box">
                    <h2>Logros</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

                    <p> Integer rutrum ligula eu dignissim laoreet. Pellentesque venenatis nibh sed tellus faucibus bibendum.</p>

                    <a href="#" class="hover-btn-new orange"><span>Learn More</span></a>
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
                <p class="lead">Lorem Ipsum dolroin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem!</p>
            </div>
        </div><!-- end title -->
        <div class="timeline">
            <div class="timeline__wrap">
                <div class="timeline__items">
                    <div class="timeline__item">
                        <div class="timeline__content img-bg-01">
                            <h2>2018</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim neque condimentum lacus dapibus. Lorem
                                ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>
                    <div class="timeline__item">
                        <div class="timeline__content img-bg-02">
                            <h2>2015</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim neque condimentum lacus dapibus. Lorem
                                ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>
                    <div class="timeline__item">
                        <div class="timeline__content img-bg-03">
                            <h2>2014</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim neque condimentum lacus dapibus. Lorem
                                ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>
                    <div class="timeline__item">
                        <div class="timeline__content img-bg-04">
                            <h2>2012</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim neque condimentum lacus dapibus. Lorem
                                ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>
                    <div class="timeline__item">
                        <div class="timeline__content img-bg-01">
                            <h2>2010</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim neque condimentum lacus dapibus. Lorem
                                ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>
                    <div class="timeline__item">
                        <div class="timeline__content img-bg-02">
                            <h2>2007</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim neque condimentum lacus dapibus. Lorem
                                ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>
                    <div class="timeline__item">
                        <div class="timeline__content img-bg-03">
                            <h2>2004</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim neque condimentum lacus dapibus. Lorem
                                ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>
                    <div class="timeline__item">
                        <div class="timeline__content img-bg-04">
                            <h2>2002</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dignissim neque condimentum lacus dapibus. Lorem
                                ipsum dolor sit amet, consectetur adipiscing elit.</p>
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
                <span data-scroll class="global-radius icon_wrap effect-1 alignleft"><i class="flaticon-study"></i></span>
                <p class="stat_count">100</p>
                <h3>Estudiantes</h3>
            </div><!-- end col -->

            <div class="col-md-4 col-sm-4 col-xs-12">
                <span data-scroll class="global-radius icon_wrap effect-1 alignleft"><i class="flaticon-online"></i></span>
                <p class="stat_count">20</p>
                <h3>Cursos</h3>
            </div><!-- end col -->

            <div class="col-md-4 col-sm-4 col-xs-12">
                <span data-scroll class="global-radius icon_wrap effect-1 alignleft"><i class="flaticon-years"></i></span>
                <p class="stat_count">5</p>
                <h3>Años funcionando</h3>
            </div><!-- end col -->
        </div><!-- end row -->
    </div><!-- end container -->
</div><!-- end section -->

<div id="plan" class="section lb">

<div id="testimonials" class="parallax section db parallax-off" style="background-image:url('images/parallax_04.jpg');">
    <div class="container">
        <div class="section-title text-center">
            <h3>Profesores</h3>
            <p>Lorem ipsum dolor sit aet, consectetur adipisicing lit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
        </div><!-- end title -->

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="testi-carousel owl-carousel owl-theme">
                    <div class="testimonial clearfix">
                        <div class="testi-meta">
                            <img src="images/testi_01.png" alt="" class="img-fluid">
                            <h4>James Fernando
                            </br>
                                Licenciado en educación </h4>
                        </div>
                        <div class="desc">
                            <h3><i class="fa fa-quote-left"></i> Testimonio </h3>
                            <p class="lead">Experiencia o palabras que quiera decir</p>
                        </div>
                        <!-- end testi-meta -->
                    </div>
                    <!-- end testimonial -->

                    <div class="testimonial clearfix">
                        <div class="testi-meta">
                            <img src="images/testi_02.png" alt="" class="img-fluid">
                            <h4>Jacques Philips </h4>
                        </div>
                        <div class="desc">
                            <h3><i class="fa fa-quote-left"></i> Awesome Services!</h3>
                            <p class="lead">Explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you completed.</p>
                        </div>
                        <!-- end testi-meta -->
                    </div>
                    <!-- end testimonial -->

                    <div class="testimonial clearfix">
                        <div class="testi-meta">
                            <img src="images/testi_03.png" alt="" class="img-fluid ">
                            <h4>Venanda Mercy </h4>
                        </div>
                        <div class="desc">
                            <h3><i class="fa fa-quote-left"></i> Great & Talented Team!</h3>
                            <p class="lead">The master-builder of human happines no one rejects, dislikes avoids pleasure itself, because it is very pursue pleasure. </p>
                        </div>
                        <!-- end testi-meta -->
                    </div>
                    <!-- end testimonial -->
                    <div class="testimonial clearfix">
                        <div class="testi-meta">
                            <img src="images/testi_01.png" alt="" class="img-fluid">
                            <h4>James Fernando </h4>
                        </div>
                        <div class="desc">
                            <h3><i class="fa fa-quote-left"></i> Wonderful Support!</h3>
                            <p class="lead">They have got my project on time with the competition with a sed highly skilled, and experienced & professional team.</p>
                        </div>
                        <!-- end testi-meta -->
                    </div>
                    <!-- end testimonial -->

                    <div class="testimonial clearfix">
                        <div class="testi-meta">
                            <img src="images/testi_02.png" alt="" class="img-fluid">
                            <h4>Jacques Philips </h4>
                        </div>
                        <div class="desc">
                            <h3><i class="fa fa-quote-left"></i> Awesome Services!</h3>
                            <p class="lead">Explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you completed.</p>
                        </div>
                        <!-- end testi-meta -->
                    </div>
                    <!-- end testimonial -->

                    <div class="testimonial clearfix">
                        <div class="testi-meta">
                            <img src="images/testi_03.png" alt="" class="img-fluid">
                            <h4>Venanda Mercy </h4>
                        </div>
                        <div class="desc">
                            <h3><i class="fa fa-quote-left"></i> Great & Talented Team!</h3>
                            <p class="lead">The master-builder of human happines no one rejects, dislikes avoids pleasure itself, because it is very pursue pleasure. </p>
                        </div>
                        <!-- end testi-meta -->
                    </div><!-- end testimonial -->
                </div><!-- end carousel -->
            </div><!-- end col -->
        </div><!-- end row -->
    </div><!-- end container -->
</div><!-- end section -->

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-xs-12">
                <div class="widget clearfix">
                    <div class="widget-title">
                        <h3>Acerca de nosotros</h3>
                    </div>
                    <p> Integer rutrum ligula eu dignissim laoreet. Pellentesque venenatis nibh sed tellus faucibus bibendum. Sed fermentum est vitae rhoncus molestie. Cum sociis natoque penatibus et magnis dis montes.</p>   
                    <div class="footer-right">
                        <ul class="footer-links-soi">
                            <li><a href="https://www.facebook.com/p/Escuela-de-lenguaje-Ni%C3%B1o-Jesus-100063466527084/?locale=es_LA" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        </ul><!-- end links -->
                    </div>						
                </div><!-- end clearfix -->
            </div><!-- end col -->

            <div class="col-lg-4 col-md-4 col-xs-12">
                <div class="widget clearfix">
                    <div class="widget-title">
                        <h3>Information Link</h3>
                    </div>
                    <ul class="footer-links">
                        <li><a href="#">Inicio</a></li>
                        <li><a href="#">La Escuela </a></li>
                        <li><a href="#">Eventos</a></li>
                        <li><a href="#">Galería de Imágenes</a></li>
                        <li><a href="#">Contacto</a></li>
                    </ul><!-- end links -->
                </div><!-- end clearfix -->
            </div><!-- end col -->

            <div class="col-lg-4 col-md-4 col-xs-12">
                <div class="widget clearfix">
                    <div class="widget-title">
                        <h3>Contacto</h3>
                    </div>

                    <ul class="footer-links">
                        <li><a href="mailto:#">Correo</a></li>
                        <li><a href="#">Facebook</a></li>
                        <li>Dirección</li>
                        <li>Teléfono</li>
                    </ul><!-- end links -->
                </div><!-- end clearfix -->
            </div><!-- end col -->

        </div><!-- end row -->
    </div><!-- end container -->
</footer><!-- end footer -->

<a href="#" id="scroll-to-top" class="dmtop global-radius"><i class="fa fa-angle-up"></i></a>

<!-- ALL JS FILES -->
<script src="js/all.js"></script>
<!-- ALL PLUGINS -->
<script src="js/custom.js"></script>
<script src="js/timeline.min.js"></script>
<script>
    timeline(document.querySelectorAll('.timeline'), {
        forceVerticalMode: 700,
        mode: 'horizontal',
        verticalStartPosition: 'left',
        visibleItems: 4
    });
</script>
</body>
</html>
