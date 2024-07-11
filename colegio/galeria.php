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

<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>

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

<?php include 'footer.php'; ?>

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
