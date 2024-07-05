<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Subir Imagen</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
        #drop-area {
            border: 2px dashed #ccc;
            border-radius: 20px;
            width: 100%;
            padding: 20px;
            text-align: center;
        }
        #drop-area.highlight {
            border-color: purple;
        }
        .my-form {
            margin-bottom: 10px;
        }
        #gallery {
            margin-top: 10px;
        }
        #gallery img {
            width: 150px;
            margin: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Subir Imagen</h1>
        <div id="drop-area">
            <form class="my-form">
                <p>Arrastra y suelta tus imágenes aquí o</p>
                <input type="file" id="fileElem" multiple accept="image/*" onchange="handleFiles(this.files)">
                <label class="btn btn-primary" for="fileElem">Seleccionar archivos</label>
            </form>
            <progress id="progress-bar" max=100 value=0></progress>
            <div id="gallery"></div>
        </div>
    </div>

    <script>
        let dropArea = document.getElementById('drop-area');

        // Prevent default drag behaviors
        ;['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false)
        });

        // Highlight drop area when item is dragged over it
        ;['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, () => dropArea.classList.add('highlight'), false)
        });

        ;['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, () => dropArea.classList.remove('highlight'), false)
        });

        // Handle dropped files
        dropArea.addEventListener('drop', handleDrop, false);

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        function handleDrop(e) {
            let dt = e.dataTransfer;
            let files = dt.files;

            handleFiles(files);
        }

        function handleFiles(files) {
            files = [...files];
            files.forEach(uploadFile);
            files.forEach(previewFile);
        }

        function uploadFile(file) {
            let url = 'upload_image.php';
            let formData = new FormData();

            formData.append('file', file);

            fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(() => {
                progressDone();
            })
            .catch(() => { alert('Upload failed'); });
        }

        function previewFile(file) {
            let reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onloadend = function() {
                let img = document.createElement('img');
                img.src = reader.result;
                document.getElementById('gallery').appendChild(img);
            }
        }

        function progressDone() {
            let progressBar = document.getElementById('progress-bar');
            progressBar.value = 100;
        }
    </script>
</body>
</html>
