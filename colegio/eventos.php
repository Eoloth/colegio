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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Añadir jQuery desde CDN -->
    <script src="js/modernizer.js"></script>
    <style>
        .evento-card {
            cursor: pointer;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        #event-details-container {
            display: none;
            text-align: center;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #fff;
            margin: 20px auto;
            max-width: 800px;
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
                        <li class="nav-item active"><a class="nav-link" href="eventos.php">Eventos</a></li>
                        <li class="nav-item"><a class="nav-link" href="galeria.php">Galería de Imágenes</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact.html">Contacto</a></li>
                        <?php if (isset($_SESSION['usuario'])): ?>
                            <li class="nav-item"><a class="nav-link" href="home.php">Panel Principal</a></li>
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
                            <li class="nav-item"><a class="nav-link" href="galeria.php">Galería de Imágenes</a></li>
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
