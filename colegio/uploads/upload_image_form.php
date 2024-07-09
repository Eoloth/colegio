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
            $nombre = $_POST['nombre'][$i]; // Recoger el nombre del título de la imagen
            if ($tmpFilePath != "") {
                $nombre_archivo = $_FILES['images']['name'][$i];
                $imagen = file_get_contents($tmpFilePath);
                $stmt = $conn->prepare("INSERT INTO galeria (nombre_archivo, imagen, nombre) VALUES (:nombre_archivo, :imagen, :nombre)");
                $stmt->bindParam(':nombre_archivo', $nombre_archivo);
                $stmt->bindParam(':imagen', $imagen, PDO::PARAM_LOB);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->execute();
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
            <div id="titleInputs"></div>
            <input type="submit" class="btn btn-success" value="Subir Imágenes">
        </form>
    </div>

    <script>
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('fileInput');
        const hiddenFileInput = document.getElementById('hiddenFileInput');
        const selectFilesButton = document.getElementById('selectFiles');
        const gallery = document.getElementById('gallery');
        const titleInputs = document.getElementById('titleInputs');

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
            [...files].forEach((file, index) => {
                previewFile(file);
                addTitleInput(index, file.name);
            });
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

        function addTitleInput(index, fileName) {
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'nombre[]';
            input.classList.add('form-control');
            input.placeholder = `Título para ${fileName}`;
            titleInputs.appendChild(input);
        }
    </script>
</body>
</html>
