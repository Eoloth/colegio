<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.html");
    exit();
}

require_once 'config.php';

try {
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['images'])) {
        $total = count($_FILES['images']['name']);
        for ($i = 0; $i < $total; $i++) {
            $tmpFilePath = $_FILES['images']['tmp_name'][$i];
            if ($tmpFilePath != "") {
                $nombre_archivo = $_FILES['images']['name'][$i];
                $imagen = file_get_contents($tmpFilePath);

                // Guardar en la tabla galeria
                $stmt = $conn->prepare("INSERT INTO galeria (nombre_archivo, imagen) VALUES (:nombre_archivo, :imagen)");
                $stmt->bindParam(':nombre_archivo', $nombre_archivo);
                $stmt->bindParam(':imagen', $imagen, PDO::PARAM_LOB);
                $stmt->execute();
                $galeria_id = $conn->lastInsertId();

                // Guardar en la tabla eventos si hay datos de evento
                if (!empty($_POST['evento_titulo']) && !empty($_POST['evento_descripcion']) && !empty($_POST['fecha_evento'])) {
                    $evento_titulo = $_POST['evento_titulo'];
                    $evento_descripcion = $_POST['evento_descripcion'];
                    $fecha_evento = $_POST['fecha_evento'];
                    $stmt = $conn->prepare("INSERT INTO eventos (id_galeria, titulo, descripcion, fecha_evento) VALUES (:id_galeria, :titulo, :descripcion, :fecha_evento)");
                    $stmt->bindParam(':id_galeria', $galeria_id);
                    $stmt->bindParam(':titulo', $evento_titulo);
                    $stmt->bindParam(':descripcion', $evento_descripcion);
                    $stmt->bindParam(':fecha_evento', $fecha_evento);
                    $stmt->execute();
                }
            }
        }
        header("Location: list_images.php");
        exit();
    }
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Subir Imagen</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
        .dropzone {
            border: 2px dashed #007bff;
            padding: 50px;
            text-align: center;
            margin-bottom: 20px;
        }
        .dropzone.dragover {
            border-color: #ff0000;
        }
        #gallery img {
            width: 100px;
            margin: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Subir Imagen</h1>
        <div class="dropzone" id="dropzone">
            <p>Arrastra y suelta tus imágenes aquí o</p>
            <input type="file" id="fileInput" multiple>
            <button id="selectFiles" class="btn btn-primary">Seleccionar archivos</button>
        </div>
        <div id="gallery"></div>
        <form action="upload_image_form.php" method="POST" enctype="multipart/form-data">
            <input type="file" id="hiddenFileInput" name="images[]" multiple style="display: none;">
            <div class="form-group">
                <label for="evento_titulo">Título del Evento</label>
                <input type="text" class="form-control" id="evento_titulo" name="evento_titulo">
            </div>
            <div class="form-group">
                <label for="evento_descripcion">Descripción del Evento</label>
                <textarea class="form-control" id="evento_descripcion" name="evento_descripcion"></textarea>
            </div>
            <div class="form-group">
                <label for="fecha_evento">Fecha del Evento</label>
                <input type="date" class="form-control" id="fecha_evento" name="fecha_evento">
            </div>
            <input type="submit" class="btn btn-success" value="Subir Imágenes">
        </form>
    </div>

    <script>
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('fileInput');
        const hiddenFileInput = document.getElementById('hiddenFileInput');
        const selectFilesButton = document.getElementById('selectFiles');
        const gallery = document.getElementById('gallery');

        dropzone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropzone.classList.add('dragover');
        });

        dropzone.addEventListener('dragleave', () => {
            dropzone.classList.remove('dragover');
        });

        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropzone.classList.remove('dragover');
            handleFiles(e.dataTransfer.files);
        });

        selectFilesButton.addEventListener('click', () => {
            fileInput.click();
        });

        fileInput.addEventListener('change', () => {
            handleFiles(fileInput.files);
        });

        function handleFiles(files) {
            [...files].forEach(previewFile);
            const dt = new DataTransfer();
            [...files].forEach(file => dt.items.add(file));
            hiddenFileInput.files = dt.files;
        }

        function previewFile(file) {
            let reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onloadend = function() {
                let img = document.createElement('img');
                img.src = reader.result;
                gallery.appendChild(img);
            }
        }
    </script>
</body>
</html>
