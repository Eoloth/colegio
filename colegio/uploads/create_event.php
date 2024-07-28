<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../home.php");
    exit();
}

require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Manejo de la subida de imágenes
        $imagenes = [];
        foreach ($_FILES['imagenes']['tmp_name'] as $key => $tmp_name) {
            $file_name = $_FILES['imagenes']['name'][$key];
            $file_tmp = $_FILES['imagenes']['tmp_name'][$key];
            $target = "../uploads/" . basename($file_name);

            if (move_uploaded_file($file_tmp, $target)) {
                $imagenes[] = $file_name;
            } else {
                throw new Exception("Error al subir la imagen $file_name.");
            }
        }

        // Convertir array de imágenes a JSON para almacenar en la base de datos
        $imagenes_json = json_encode($imagenes);

        $stmt = $conn->prepare("INSERT INTO eventos (titulo, descripcion, fecha_evento, fecha_publicacion, imagen) VALUES (:titulo, :descripcion, :fecha_evento, NOW(), :imagen)");
        $stmt->bindParam(':titulo', $_POST['titulo']);
        $stmt->bindParam(':descripcion', $_POST['descripcion']);
        $stmt->bindParam(':fecha_evento', $_POST['fecha_evento']);
        $stmt->bindParam(':imagen', $imagenes_json);
        $stmt->execute();

        $_SESSION['mensaje'] = "Evento creado exitosamente.";
        header("Location: list_events.php");
        exit();
    } catch (PDOException $e) {
        die("Error al conectar a la base de datos: " . $e->getMessage());
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Crear Nuevo Evento</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
        .image-preview {
            position: relative;
            display: inline-block;
            margin-right: 10px;
        }
        .remove-image {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: red;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Crear Nuevo Evento</h1>
        <form action="create_event.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="fecha_evento">Fecha del Evento:</label>
                <input type="date" class="form-control" id="fecha_evento" name="fecha_evento" required>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen del Evento:</label>
                <input type="file" class="form-control" id="imagen" name="imagen" required>
            </div>
            <div id="image-preview-container"></div>
            <button type="submit" class="btn btn-success">Crear Evento</button>
            <a href="list_events.php" class="btn btn-primary">Regresar</a>
        </form>
    </div>

    <script>
        document.getElementById('imagen').addEventListener('change', function(event) {
            const container = document.getElementById('image-preview-container');
            container.innerHTML = ''; // Clear previous images

            const files = event.target.files;
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.classList.add('image-preview');
                    
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '100px';
                    img.style.height = '100px';
                    img.style.objectFit = 'cover';

                    const button = document.createElement('button');
                    button.textContent = 'X';
                    button.classList.add('remove-image');
                    button.onclick = function() {
                        div.remove();
                    };

                    div.appendChild(img);
                    div.appendChild(button);
                    container.appendChild(div);
                };

                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
