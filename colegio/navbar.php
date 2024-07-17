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
                    <li class="nav-item"><a class="nav-link" href="galeria.php">Galería de Imágenes</a></li>
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
