<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.html");
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
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $fecha_evento = $_POST['fecha_evento'];

        // Insertar el evento
        $stmt = $conn->prepare("INSERT INTO eventos (titulo, descripcion, fecha_evento, fecha_publicacion) VALUES (:titulo, :descripcion, :fecha_evento, NOW())");
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':fecha_evento', $fecha_evento);
        $stmt->execute();

        // Obtener el ID del evento insertado
        $evento_id = $conn->lastInsertId();

        // Procesar y subir las imágenes
        if (isset($_FILES['images'])) {
            $total = count($_FILES['images']['name']);
            for ($i = 0; $i < $total; $i++) {
                $tmpFilePath = $_FILES['images']['tmp_name'][$i];
                if ($tmpFilePath != "") {
                    $newFilePath = "../uploads/" . $_FILES['images']['name'][$i];
                    if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                        $stmt = $conn->prepare("INSERT INTO galeria (nombre, ruta, tipo_archivo, tamaño_archivo) VALUES (:nombre, :ruta, :tipo_archivo, :tamaño_archivo)");
                        $stmt->bindParam(':nombre', $_FILES['images']['name'][$i]);
                        $stmt->bindParam(':ruta', $newFilePath);
                        $stmt->bindParam(':tipo_archivo', $_FILES['images']['type'][$i]);
                        $stmt->bindParam(':tamaño_archivo', $_FILES['images']['size'][$i]);
                        $stmt->execute();

                        // Obtener el ID de la imagen insertada
                        $imagen_id = $conn->lastInsertId();

                        // Relacionar la imagen con el evento
                        $stmt = $conn->prepare("UPDATE eventos SET galeria_id = :galeria_id WHERE id = :evento_id");
                        $stmt->bindParam(':galeria_id', $imagen_id);
                        $stmt->bindParam(':evento_id', $evento_id);
                        $stmt->execute();
                    }
                }
            }
        }

        header("Location: lista_eventos.php");
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
    <title>Crear Evento</title>
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
        <h1>Crear Evento</h1>
        <form action="create_event.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titulo">Título</label>
                <input type="text" id="titulo" name="titulo" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="fecha_evento">Fecha del Evento</label>
                <input type="date" id="fecha_evento" name="fecha_evento" class="form-control" required>
            </div>
            <div class="dropzone" id="dropzone">
                <p>Arrastra y suelta tus imágenes aquí o</p>
                <input type="file" id="fileInput" multiple>
                <button id="selectFiles" class="btn btn-primary">Seleccionar archivos</button>
            </div>
            <div id="gallery"></div>
            <input type="file" id="hiddenFileInput" name="images[]" multiple style="display: none;">
            <input type="submit" class="btn btn-success" value="Crear Evento">
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
