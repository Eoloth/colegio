<?php
require_once 'uploads/config.php';

try {
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT * FROM galeria ORDER BY id DESC");
    $stmt->execute();
    $imagenes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
?>

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
    <meta property="og:image" content="https://escuela-niniojesus.cl/path/to/logo.png" />
    <meta property="og:url" content="https://escuela-niniojesus.cl/home.php" />
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/versions.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/lightbox.css"> <!-- Lightbox CSS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Añadir jQuery desde CDN -->
    <script src="js/modernizer.js"></script>
    <style>
        .gallery-item {
            display: inline-block;
            margin: 10px;
            transition: transform 0.3s ease-in-out;
            position: relative;
        }
        .gallery-item img {
            max-width: 150px;
            height: auto;
            transition: transform 0.3s ease-in-out;
        }
        .gallery-item:hover img {
            transform: scale(1.5);
        }
        .image-title {
            display: none;
            position: absolute;
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            padding: 5px;
            z-index: 10;
        }
        .lightbox-navigation {
            display: flex;
            justify-content: space-between;
            width: 100%;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }
        .lightbox-button {
            background: none;
            border: none;
            cursor: pointer;
            outline: none;
            position: absolute;
        }
        .lightbox-close {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            cursor: pointer;
            outline: none;
        }
    </style>
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
                <a class="navbar-brand" href="home.php">
                    <img src="images/logo.png" alt="" />
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbars-host" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbars-host">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link" href="home.php">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.html">Acerca de nosotros</a></li>
                        <li class="nav-item"><a class="nav-link" href="eventos.php">Eventos</a></li>
                        <li class="nav-item active"><a class="nav-link" href="galeria.php">Galería de Imágenes</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact.html">Contacto</a></li>
                        <?php if (isset($_SESSION['usuario'])): ?>
                            <li class="nav-item"><a class="nav-link" href="uploads/logout.php">Cerrar Sesión</a></li>
                        <?php else: ?>
                            <li class="nav-item"><a class="nav-link" href="" data-toggle="modal" data-target="#login">Entrar</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
        <h1>Galería de Imágenes</h1>
        <?php if (isset($_SESSION['usuario'])): ?>
            <a href="uploads/list_images.php" class="btn btn-info">Administrar Galería de Imágenes</a>
        <?php endif; ?>

        <?php
        try {
            $stmt = $conn->prepare("SELECT * FROM galeria ORDER BY id DESC");
            $stmt->execute();
            $imagenes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($imagenes) {
                echo '<div class="gallery">';
                foreach ($imagenes as $index => $imagen) {
                    echo '<div class="gallery-item">';
                    echo '<a href="data:image/jpeg;base64,' . base64_encode($imagen['imagen']) . '" data-lightbox="gallery" data-title="' . htmlspecialchars($imagen['nombre_archivo']) . '" data-index="' . $index . '">';
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($imagen['imagen']) . '" alt="' . htmlspecialchars($imagen['nombre_archivo']) . '">';
                    echo '<div class="image-title">' . htmlspecialchars($imagen['nombre_archivo']) . '</div>';
                    echo '</a>';
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo '<p>No hay imágenes para mostrar.</p>';
            }
        } catch (PDOException $e) {
            die("Error al conectar a la base de datos: " . $e->getMessage());
        }
        ?>
    </div>

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
                            <li class="nav-item"><a class="nav-link" href="home.php">Inicio</a></li>
                            <li class="nav-item"><a class="nav-link" href="about.html">Acerca de nosotros</a></li>
                            <li class="nav-item"><a class="nav-link" href="eventos.php">Eventos</a></li>
                            <li class="nav-item active"><a class="nav-link" href="galeria.php">Galería de Imágenes</a></li>
                            <li class="nav-item"><a class="nav-link" href="contact.html">Contacto</a></li>
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
    <script src="js/lightbox.js"></script> <!-- Lightbox JS -->
    <script>
        $(document).ready(function() {
            $('.gallery-item').hover(function(event) {
                var title = $(this).find('.image-title');
                title.css({
                    top: event.pageY + 15,
                    left: event.pageX + 15
                }).show();
            }, function() {
                $(this).find('.image-title').hide();
            });

            $('.gallery-item').mousemove(function(event) {
                var title = $(this).find('.image-title');
                title.css({
                    top: event.pageY + 15,
                    left: event.pageX + 15
                });
            });

            var lightboxIndex = 0;
            var images = <?php echo json_encode($imagenes); ?>;

            $(document).on('click', '[data-lightbox="gallery"]', function(event) {
                event.preventDefault();
                lightboxIndex = $(this).data('index');
                openLightbox(lightboxIndex);
            });

            function openLightbox(index) {
                var image = images[index];
                var lightbox = '<div class="lightbox-overlay">';
                lightbox += '<img src="data:image/jpeg;base64,' + image.imagen + '" alt="' + image.nombre_archivo + '">';
                lightbox += '<button class="lightbox-close"><img src="images/close.png" alt="Close"></button>';
                lightbox += '<div class="lightbox-navigation">';
                lightbox += '<button class="lightbox-button lightbox-prev"><img src="images/prev.png" alt="Previous"></button>';
                lightbox += '<button class="lightbox-button lightbox-next"><img src="images/next.png" alt="Next"></button>';
                lightbox += '</div>';
                lightbox += '</div>';
                $('body').append(lightbox);
                $('.lightbox-overlay').fadeIn();
            }

            $(document).on('click', '.lightbox-close', function() {
                $('.lightbox-overlay').fadeOut(function() {
                    $(this).remove();
                });
            });

            $(document).on('click', '.lightbox-prev', function() {
                lightboxIndex = (lightboxIndex > 0) ? lightboxIndex - 1 : images.length - 1;
                updateLightboxImage(lightboxIndex);
            });

            $(document).on('click', '.lightbox-next', function() {
                lightboxIndex = (lightboxIndex < images.length - 1) ? lightboxIndex + 1 : 0;
                updateLightboxImage(lightboxIndex);
            });

            function updateLightboxImage(index) {
                var image = images[index];
                $('.lightbox-overlay img').attr('src', 'data:image/jpeg;base64,' + image.imagen).attr('alt', image.nombre_archivo);
            }
        });
    </script>
</body>
</html>
