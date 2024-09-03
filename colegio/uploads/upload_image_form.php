<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Subir Imagen</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
        .image-preview {
            display: flex;
            flex-wrap: wrap;
        }
        .image-preview div {
            margin-right: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Subir Imagen</h1>
    <form action="upload_image.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="imagenes">Seleccionar Imágenes:</label>
            <input type="file" class="form-control" id="imagenes" name="imagenes[]" multiple required>
        </div>
        <div id="image-preview" class="image-preview"></div>
        <button type="submit" class="btn btn-success">Subir Imágenes</button>
        <a href="list_images.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script>
    document.getElementById('imagenes').addEventListener('change', function(e) {
        let preview = document.getElementById('image-preview');
        preview.innerHTML = '';
        Array.from(e.target.files).forEach(file => {
            let reader = new FileReader();
            reader.onload = function(event) {
                let div = document.createElement('div');
                div.innerHTML = `<img src="${event.target.result}" style="width: 100px; height: 100px;">
                                 <input type="text" class="form-control" name="nombres[]" placeholder="Nombre de la imagen" value="${file.name}" required>
                                 <input type="text" class="form-control" name="descripciones[]" placeholder="Descripción">`;
                preview.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    });
</script>
</body>
</html>
