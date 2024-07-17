<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
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
    <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="../images/apple-touch-icon.png">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../css/versions.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="../css/custom.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/modernizer.js"></script>
</head>
<body class="host_version">
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

    <!-- Loader -->
    <div id="preloader">
        <div class="loader-container">
            <div class="progress-br float shadow">
                <div class="progress__item"></div>
            </div>
        </div>
    </div>
    <!-- End Loader -->

    <!-- Start header -->
    <header class="top-navbar">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="../home.php">
                    <img src="../images/logo.png" alt="" />
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbars-host" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbars-host">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link" href="../home.php">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="../about.html">Acerca de nosotros</a></li>
                        <li class="nav-item"><a class="nav-link" href="../eventos.php">Eventos</a></li>
                        <li class="nav-item"><a class="nav-link" href="../galeria.php">Galería de Imágenes</a></li>
                        <li class="nav-item"><a class="nav-link" href="../contact.html">Contacto</a></li>
                        <?php if (isset($_SESSION['usuario'])): ?>
                            <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar Sesión</a></li>
                        <?php else: ?>
                            <li class="nav-item"><a class="nav-link" href="" data-toggle="modal" data-target="#login">Entrar</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
