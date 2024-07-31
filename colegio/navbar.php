<?php
// Detectar la página actual
$current_page = basename($_SERVER['PHP_SELF']);
?>
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
                    <li class="nav-item <?php echo ($current_page == 'home.php') ? 'active' : ''; ?>"><a class="nav-link" href="home.php">Inicio</a></li>
                    <li class="nav-item <?php echo ($current_page == 'about.php') ? 'active' : ''; ?>"><a class="nav-link" href="about.php">Acerca de nosotros</a></li>
                    <li class="nav-item <?php echo ($current_page == 'eventos.php') ? 'active' : ''; ?>"><a class="nav-link" href="eventos.php">Eventos</a></li>
                    <li class="nav-item <?php echo ($current_page == 'galeria.php') ? 'active' : ''; ?>"><a class="nav-link" href="galeria.php">Galería de Imágenes</a></li>
                    <?php if (isset($_SESSION['usuario'])): ?>
                        <li class="nav-item"><a class="nav-link" href="uploads/logout.php">Cerrar Sesión</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="#" data-toggle="modal" data-target="#login">Entrar</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>

<!-- Modal de login -->
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
                                    <a class="for-pwd" href="forgot_password.php">¿Olvidaste tu contraseña?</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
