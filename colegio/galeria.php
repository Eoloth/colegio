<?php
session_start();
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
    <link rel="stylesheet" href="css/lightbox.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css" rel="stylesheet" media="all">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/modernizer.js"></script>
    <script src="js/lightbox.js"></script>
</head>
<body class="host_version">
<?php include 'navbar.php'; ?>

<div class="container">
    <h1>Galería de Imágenes</h1>
    <?php if (isset($_SESSION['usuario'])): ?>
        <a href="uploads/list_images.php" class="btn btn-info">Administrar Galería de Imágenes</a>
    <?php endif; ?>

    <div class="row">
        <?php
        // Conectar a la base de datos y obtener las imágenes en tandas de 20
        require_once 'uploads/config.php';
        try {
            $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Número de imágenes por página
            $imagenes_por_pagina = 20;
            $pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
            $inicio = ($pagina_actual - 1) * $imagenes_por_pagina;

            // Consulta total de imágenes para calcular el número total de páginas
            $stmt_total = $conn->prepare("SELECT COUNT(*) AS total FROM galeria");
            $stmt_total->execute();
            $total_imagenes = $stmt_total->fetch(PDO::FETCH_ASSOC)['total'];
            $total_paginas = ceil($total_imagenes / $imagenes_por_pagina);

            // Consulta para obtener las imágenes de la página actual
            $stmt = $conn->prepare("SELECT * FROM galeria ORDER BY id DESC LIMIT :inicio, :cantidad");
            $stmt->bindValue(':inicio', $inicio, PDO::PARAM_INT);
            $stmt->bindValue(':cantidad', $imagenes_por_pagina, PDO::PARAM_INT);
            $stmt->execute();
            $imagenes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            die("Error al conectar a la base de datos: " . $e->getMessage());
        }

        if ($imagenes):
            foreach ($imagenes as $imagen):
        ?>
<div class="col-lg-3 col-md-4 col-xs-6 thumb">
    <a href="uploads/<?php echo htmlspecialchars($imagen['nombre_archivo']); ?>" data-lightbox="galeria" data-title="<?php echo htmlspecialchars($imagen['descripcion']); ?>">
        <img class="img-thumbnail" src="uploads/thumbnails/<?php echo htmlspecialchars($imagen['nombre_archivo']); ?>" alt="<?php echo htmlspecialchars($imagen['nombre_archivo']); ?>" style="width: 100%; height: auto;">
    </a>
</div>



        <?php
            endforeach;
        else:
        ?>
            <p>No hay imágenes para mostrar.</p>
        <?php
        endif;
        ?>
    </div>

    <!-- Paginación -->
    <div class="paginacion">
        <?php if ($pagina_actual > 1): ?>
            <a href="galeria.php?pagina=<?php echo $pagina_actual - 1; ?>">Anterior</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
            <a href="galeria.php?pagina=<?php echo $i; ?>" 
               class="<?php echo $i == $pagina_actual ? 'activo' : ''; ?>">
               <?php echo $i; ?>
            </a>
        <?php endfor; ?>

        <?php if ($pagina_actual < $total_paginas): ?>
            <a href="galeria.php?pagina=<?php echo $pagina_actual + 1; ?>">Siguiente</a>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>

<!-- Incluir dependencias de Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.18/jquery.touchSwipe.min.js"></script>
</body>
</html>
