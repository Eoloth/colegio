<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../home.php");
    exit();
}


$host = "localhost";
$dbname = "escuel36_main";
$username = "escuel36_admin";
$password = "NVJd8f2Ae6^M";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        
        $stmt = $conn->prepare("UPDATE galeria SET nombre_archivo = :nombre, descripcion = :descripcion WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->execute();
        
        $_SESSION['mensaje'] = "Imagen actualizada con éxito.";
        header("Location: list_images.php");
        exit();
    } else {
        $id = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM galeria WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $imagen = $stmt->fetch(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    $_SESSION['mensaje'] = "Error al conectar a la base de datos.";
    header("Location: list_images.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editar Imagen</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../css/versions.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="../css/custom.css">
</head>
<body class="host_version">
    <!-- Mostrar mensaje de sesión -->
    <?php
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
                    <div class="tab-content">
                        <div class="tab-pane active" id="Login">
                            <form role="form" class="form-horizontal" action="login.php" method="POST">
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
                    <img src="../images/logo.png" alt="" />
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbars-host" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbars-host">
                    <ul class="navbar-nav ml-auto">
                    <li class="nav-item active"><a class="nav-link" href="../home.php">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="../about.html">Acerca de nosotros</a></li>
                        <li class="nav-item"><a class="nav-link" href="../eventos.php">Eventos</a></li>
                        <li class="nav-item"><a class="nav-link" href="../galeria.php">Galería de Imágenes</a></li>
                        <li class="nav-item"><a class="nav-link" href="../contact.html">Contacto</a></li>
                        <li class="nav-item"><a class="nav-link" href="" data-toggle="modal" data-target="#login">Entrar</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
        <h1>Editar Imagen</h1>
        <form action="edit_image.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($imagen['id']); ?>">
            <div class="form-group">
                <label for="nombre">Nombre del Archivo</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($imagen['nombre_archivo']); ?>" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?php echo htmlspecialchars($imagen['descripcion']); ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Actualizar Imagen</button>
        </form>
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
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-xs-12">
                    <div class="widget clearfix">
                        <div class="widget-title">
                            <h3>Information Link</h3>
                        </div>
                        <ul class="footer-links">
                        <li class="nav-item active"><a class="nav-link" href="../home.php">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="../about.html">Acerca de nosotros</a></li>
                        <li class="nav-item"><a class="nav-link" href="../eventos.php">Eventos</a></li>
                        <li class="nav-item"><a class="nav-link" href="../galeria.php">Galería de Imágenes</a></li>
                        <li class="nav-item"><a class="nav-link" href="../contact.html">Contacto</a></li>
                        </ul>
                    </div>
                </div>

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
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <a href="#" id="scroll-to-top" class="dmtop global-radius"><i class="fa fa-angle-up"></i></a>

    <!-- ALL JS FILES -->
    <script src="../js/all.js"></script>
    <!-- ALL PLUGINS -->
    <script src="../js/custom.js"></script>
    <script src="../js/timeline.min.js"></script>
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
