<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../home.php");
    exit();
}

require_once 'config.php';

try {
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $stmt = $conn->prepare("UPDATE eventos SET titulo = :titulo, descripcion = :descripcion, fecha_evento = :fecha_evento WHERE id = :id");
        $stmt->bindParam(':id', $_POST['id']);
        $stmt->bindParam(':titulo', $_POST['titulo']);
        $stmt->bindParam(':descripcion', $_POST['descripcion']);
        $stmt->bindParam(':fecha_evento', $_POST['fecha_evento']);
        $stmt->execute();

        // Manejo de las imágenes
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
            $imagen = $_FILES['imagen']['name'];
            $target = '../uploads/' . basename($imagen);

            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $target)) {
                // Obtener las imágenes anteriores para eliminarlas del servidor
                $stmt = $conn->prepare("SELECT imagen FROM eventos WHERE id = :id");
                $stmt->bindParam(':id', $_POST['id']);
                $stmt->execute();
                $evento = $stmt->fetch(PDO::FETCH_ASSOC);

                $imagenes = json_decode($evento['imagen'], true);
                if ($imagenes && is_array($imagenes)) {
                    foreach ($imagenes as $img) {
                        if (file_exists('../uploads/' . $img)) {
                            unlink('../uploads/' . $img);
                        }
                    }
                }

                // Actualizar las imágenes en la base de datos
                $imagenes[] = $imagen; // Añadir la nueva imagen al array
                $imagenes_json = json_encode($imagenes);

                $stmt = $conn->prepare("UPDATE eventos SET imagen = :imagen WHERE id = :id");
                $stmt->bindParam(':id', $_POST['id']);
                $stmt->bindParam(':imagen', $imagenes_json);
                $stmt->execute();
            } else {
                throw new Exception("Error al subir la nueva imagen.");
            }
        }

        $_SESSION['mensaje'] = "Evento actualizado exitosamente.";
        header("Location: list_events.php");
        exit();
    } else {
        $stmt = $conn->prepare("SELECT * FROM eventos WHERE id = :id");
        $stmt->bindParam(':id', $_GET['id']);
        $stmt->execute();
        $evento = $stmt->fetch(PDO::FETCH_ASSOC);
        $imagenes = json_decode($evento['imagen'], true);
    }
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editar Evento</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
        .image-preview {
            position: relative;
            display: inline-block;
            margin-right: 10px;
        }
        .image-preview img {
            width: 150px;
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
        <h1>Editar Evento</h1>
        <form action="edit_event.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($evento['id']); ?>">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($evento['titulo']); ?>" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?php echo htmlspecialchars($evento['descripcion']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="fecha_evento">Fecha del Evento:</label>
                <input type="date" class="form-control" id="fecha_evento" name="fecha_evento" value="<?php echo htmlspecialchars($evento['fecha_evento']); ?>" required>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen del Evento:</label>
                <input type="file" class="form-control" id="imagen" name="imagen">
                <div id="current-images">
                    <p>Imágenes actuales:</p>
                    <?php if ($imagenes && is_array($imagenes)): ?>
                        <?php foreach ($imagenes as $img): ?>
                            <div class="image-preview">
                                <img src="../uploads/<?php echo htmlspecialchars($img); ?>" alt="Imagen del evento">
                                <button class="remove-image" data-filename="<?php echo htmlspecialchars($img); ?>">X</button>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Evento</button>
            <a href="list_events.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            document.querySelectorAll('.remove-image').forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    const filename = button.getAttribute('data-filename');
                    const eventId = <?php echo json_encode($evento['id']); ?>;
                    const context = 'evento';  // Contexto especificado

                    fetch(`delete_imagen_event.php?filename=${filename}&id=${eventId}&context=${context}`)
                        .then(response => response.text())
                        .then(result => {
                            if (result.trim() === 'success') {
                                button.parentElement.remove();
                            } else {
                                alert('Error al eliminar la imagen: ' + result);
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        });

    </script>
</body>
</html>
