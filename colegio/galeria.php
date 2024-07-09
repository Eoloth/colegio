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
    <style>
        .gallery-item {
            display: inline-block;
            margin: 10px;
        }
        .gallery-item img {
            max-width: 150px;
            height: auto;
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
                    <li class="nav-item"><a class="nav-link" href="home.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.html">Acerca de nosotros</a></li>
                    <li class="nav-item"><a class="nav-link" href="eventos.html">Eventos</a></li>
                    <li class="nav-item active"><a class="nav-link" href="galeria.php">Galería de Imágenes</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.html">Contacto</a></li>
                    <li class="nav-item"><a class="nav-link" href="" data-toggle="modal" data-target="#login">Entrar</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<div class="container">
    <h1>Galería de Imágenes</h1>
    <?php if (isset($_SESSION['usuario'])): ?>
        <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</h2>
        <a href="uploads/logout.php">Cerrar sesión</a>
        <br><br>
        <a href="uploads/list_events.php" class="btn btn-info">Administrar Eventos</a>
        <a href="uploads/list_images.php" class="btn btn-info">Administrar Galería de Imágenes</a>
    <?php endif; ?>

    <?php
    require_once 'uploads/config.php';

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM galeria ORDER BY id DESC");
        $stmt->execute();
        $imagenes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($imagenes) {
            echo '<div class="gallery">';
            foreach ($imagenes as $imagen) {
                echo '<div class="gallery-item">';
                echo '<img src="' . htmlspecialchars($imagen['ruta']) . '" alt="' . htmlspecialchars($imagen['nombre']) . '">';
                echo '<p>' . htmlspecialchars($imagen['nombre']) . '</p>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<p>No hay imágenes para mostrar.</p>';
        }
    } catch (PDOException $e) {
        // Error handling ocultado para evitar mostrar detalles de error a los usuarios.
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
                        <li class="nav-item active"><a class="nav-link" href="home.php">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.html">Acerca de nosotros</a></li>
                        <li class="nav-item"><a class="nav-link" href="eventos.html">Eventos</a></li>
                        <li class="nav-item"><a class="nav-link" href="galeria.php">Galería de Imágenes</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact.html">Contacto</a></li>
                        <li class="nav-item"><a class="nav-link" href="" data-toggle="modal" data-target="#login">Entrar</a></li>
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
