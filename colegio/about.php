<?php
session_start();
require_once 'uploads/config.php';

// Conexión a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener todo el contenido de la tabla 'about'
$sql = "SELECT * FROM about";
$result = $conn->query($sql);
$secciones = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $secciones[$row['identifier']] = $row['texto'];
        $secciones[$row['identifier'] . '_imagen'] = $row['imagen'];
    }
}
$conn->close();
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
    <meta property="og:description" content="Acerca de la Escuela de Lenguaje Niño Jesús" />
    <meta property="og:image" content="https://tu-dominio.cl/path/to/logo.png" />
    <meta property="og:url" content="https://tu-dominio.cl/about.php" />

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
    <link rel="manifest" href="images/site.webmanifest">
    <link rel="mask-icon" href="images/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/versions.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/custom.css">
    <script src="js/modernizer.js"></script>
</head>
<body class="host_version"> 

<?php include 'navbar.php'; ?>

<!-- Mostrar mensaje de sesión -->
<?php
if (isset($_SESSION['mensaje'])) {
    echo '<div class="alert alert-info" role="alert">' . $_SESSION['mensaje'] . '</div>';
    unset($_SESSION['mensaje']);
}
?>

<div class="all-title-box">
    <div class="container text-center">
        <h1>About<span class="m_1">Lorem Ipsum dolroin gravida nibh vel velit.</span></h1>
    </div>
</div>

<div id="overviews" class="section lb">
    <div class="container">
        <div class="section-title row text-center">
            <div class="col-md-8 offset-md-2">
                <h3>About</h3>
                <div class="editable-container">
                    <p class="lead editable-content" data-key="about_intro" contenteditable="true">
                        <?php echo isset($secciones['about_intro']) ? $secciones['about_intro'] : 'Texto predeterminado para la introducción'; ?>
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
                    <h4>2018 BEST SmartEDU education school</h4>
                    <h2 class="editable-container"><strong>Awards Winner Support Center</strong></h2>
                    <div class="editable-container">
                        <p class="editable-content" data-key="about_awards" contenteditable="true">
                            <?php echo isset($secciones['about_awards']) ? $secciones['about_awards'] : 'Texto predeterminado para la descripción de los premios'; ?>
                        </p>
                        <div class="edit-actions" style="display: none;">
                            <button class="save-btn">Guardar</button>
                            <button class="cancel-btn">Cancelar</button>
                        </div>
                    </div>
                    <a href="#" class="hover-btn-new orange"><span>Learn More</span></a>
                </div><!-- end messagebox -->
            </div><!-- end col -->

            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="post-media wow fadeIn">
                    <div class="editable-image-container">
                        <img src="<?php echo isset($secciones['about_awards_imagen']) ? 'uploads/' . $secciones['about_awards_imagen'] : 'images/default_image.jpg'; ?>" alt="" class="img-fluid img-rounded">
                        <?php if (isset($_SESSION['usuario'])): ?>
                            <a href="#" class="edit-image-icon" data-section="about_awards_imagen">
                                <i class="fas fa-edit"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div><!-- end media -->
            </div><!-- end col -->

            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="post-media wow fadeIn">
                    <div class="editable-image-container">
                        <img src="<?php echo isset($secciones['about_history_imagen']) ? 'uploads/' . $secciones['about_history_imagen'] : 'images/default_image.jpg'; ?>" alt="" class="img-fluid img-rounded">
                        <?php if (isset($_SESSION['usuario'])): ?>
                            <a href="#" class="edit-image-icon" data-section="about_history_imagen">
                                <i class="fas fa-edit"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div><!-- end media -->
            </div><!-- end col -->

            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="message-box">
                    <h2 class="editable-container"><strong>The standard Lorem Ipsum passage, used since the 1500s</strong></h2>
                    <div class="editable-container">
                        <p class="editable-content" data-key="about_history" contenteditable="true">
                            <?php echo isset($secciones['about_history']) ? $secciones['about_history'] : 'Texto predeterminado para la historia'; ?>
                        </p>
                        <div class="edit-actions" style="display: none;">
                            <button class="save-btn">Guardar</button>
                            <button class="cancel-btn">Cancelar</button>
                        </div>
                    </div>
                    <a href="#" class="hover-btn-new orange"><span>Learn More</span></a>
                </div><!-- end messagebox -->
            </div><!-- end col -->
        </div><!-- end row -->
    </div><!-- end container -->
</div><!-- end section -->

<div class="hmv-box">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-4 col-md-6 col-12">
                <div class="inner-hmv">
                    <div class="icon-box-hmv"><i class="flaticon-achievement"></i></div>
                    <h3 class="editable-container"><strong>Mission</strong></h3>
                    <div class="editable-container">
                        <p class="editable-content" data-key="about_mission" contenteditable="true">
                            <?php echo isset($secciones['about_mission']) ? $secciones['about_mission'] : 'Texto predeterminado para la misión'; ?>
                        </p>
                        <div class="edit-actions" style="display: none;">
                            <button class="save-btn">Guardar</button>
                            <button class="cancel-btn">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12">
                <div class="inner-hmv">
                    <div class="icon-box-hmv"><i class="flaticon-eye"></i></div>
                    <h3 class="editable-container"><strong>Vision</strong></h3>
                    <div class="editable-container">
                        <p class="editable-content" data-key="about_vision" contenteditable="true">
                            <?php echo isset($secciones['about_vision']) ? $secciones['about_vision'] : 'Texto predeterminado para la visión'; ?>
                        </p>
                        <div class="edit-actions" style="display: none;">
                            <button class="save-btn">Guardar</button>
                            <button class="cancel-btn">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12">
                <div class="inner-hmv">
                    <div class="icon-box-hmv"><i class="flaticon-history"></i></div>
                    <h3 class="editable-container"><strong>History</strong></h3>
                    <div class="editable-container">
                        <p class="editable-content" data-key="about_history_details" contenteditable="true">
                            <?php echo isset($secciones['about_history_details']) ? $secciones['about_history_details'] : 'Texto predeterminado para los detalles de la historia'; ?>
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

<div id="testimonials" class="parallax section db parallax-off" style="background-image:url('images/parallax_04.jpg');">
    <div class="container">
        <div class="section-title text-center">
            <h3>Testimonials</h3>
            <div class="editable-container">
                <p class="lead editable-content" data-key="about_testimonials_intro" contenteditable="true">
                    <?php echo isset($secciones['about_testimonials_intro']) ? $secciones['about_testimonials_intro'] : 'Texto predeterminado para la introducción de testimonios'; ?>
                </p>
                <div class="edit-actions" style="display: none;">
                    <button class="save-btn">Guardar</button>
                    <button class="cancel-btn">Cancelar</button>
                </div>
            </div>
        </div><!-- end title -->

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="testi-carousel owl-carousel owl-theme">
                    <div class="testimonial clearfix">
                        <div class="testi-meta">
                            <img src="images/testi_01.png" alt="" class="img-fluid">
                            <h4>James Fernando</h4>
                        </div>
                        <div class="desc">
                            <h3><i class="fa fa-quote-left"></i> Wonderful Support!</h3>
                            <div class="editable-container">
                                <p class="editable-content" data-key="about_testimonial_1" contenteditable="true">
                                    <?php echo isset($secciones['about_testimonial_1']) ? $secciones['about_testimonial_1'] : 'They have got my project on time with the competition with a sed highly skilled, and experienced & professional team.'; ?>
                                </p>
                                <div class="edit-actions" style="display: none;">
                                    <button class="save-btn">Guardar</button>
                                    <button class="cancel-btn">Cancelar</button>
                                </div>
                            </div>
                        </div><!-- end desc -->
                    </div><!-- end testimonial -->

                    <div class="testimonial clearfix">
                        <div class="testi-meta">
                            <img src="images/testi_02.png" alt="" class="img-fluid">
                            <h4>Jacques Philips</h4>
                        </div>
                        <div class="desc">
                            <h3><i class="fa fa-quote-left"></i> Awesome Services!</h3>
                            <div class="editable-container">
                                <p class="editable-content" data-key="about_testimonial_2" contenteditable="true">
                                    <?php echo isset($secciones['about_testimonial_2']) ? $secciones['about_testimonial_2'] : 'Explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you completed.'; ?>
                                </p>
                                <div class="edit-actions" style="display: none;">
                                    <button class="save-btn">Guardar</button>
                                    <button class="cancel-btn">Cancelar</button>
                                </div>
                            </div>
                        </div><!-- end desc -->
                    </div><!-- end testimonial -->

                    <div class="testimonial clearfix">
                        <div class="testi-meta">
                            <img src="images/testi_03.png" alt="" class="img-fluid">
                            <h4>Venanda Mercy</h4>
                        </div>
                        <div class="desc">
                            <h3><i class="fa fa-quote-left"></i> Great & Talented Team!</h3>
                            <div class="editable-container">
                                <p class="editable-content" data-key="about_testimonial_3" contenteditable="true">
                                    <?php echo isset($secciones['about_testimonial_3']) ? $secciones['about_testimonial_3'] : 'The master-builder of human happiness no one rejects, dislikes avoids pleasure itself, because it is very pursue pleasure.'; ?>
                                </p>
                                <div class="edit-actions" style="display: none;">
                                    <button class="save-btn">Guardar</button>
                                    <button class="cancel-btn">Cancelar</button>
                                </div>
                            </div>
                        </div><!-- end desc -->
                    </div><!-- end testimonial -->
                </div><!-- end carousel -->
            </div><!-- end col -->
        </div><!-- end row -->
    </div><!-- end container -->
</div><!-- end section -->

<?php include 'footer.php'; ?>

<!-- Modal para subir imágenes -->
<div id="uploadImageModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="uploadImageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadImageModalLabel">Subir Imagen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="uploadImageForm" action="uploads/upload_image_about.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="section" id="modalSection" value="">
                    <div class="form-group">
                        <label for="imageFile">Seleccionar imagen</label>
                        <input type="file" class="form-control-file" id="imageFile" name="imageFile" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Subir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="js/all.js"></script>
<script src="js/custom.js"></script>

</body>
</html>
