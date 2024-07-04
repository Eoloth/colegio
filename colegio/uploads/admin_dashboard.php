<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: home.html");
    exit();
}

$host = "186.64.114.120";
$dbname = "escuel36_main";
$username = "escuela36_admin";
$password = "NVJd8f2Ae6^M";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Aquí manejas las operaciones CRUD según el formulario enviado
    // Ejemplo: Añadir un nuevo evento
    if (isset($_POST['accion']) && $_POST['accion'] == 'añadir_evento') {
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $fecha_evento = $_POST['fecha_evento'];
        $id_galeria = $_POST['id_galeria'];
        
        $stmt = $conn->prepare("INSERT INTO eventos (titulo, descripcion, fecha_evento, id_galeria) VALUES (?, ?, ?, ?)");
        $stmt->execute([$titulo, $descripcion, $fecha_evento, $id_galeria]);
    }
}

// Obtener eventos
$stmt = $conn->prepare("SELECT * FROM eventos ORDER BY fecha_evento DESC");
$stmt->execute();
$eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener galería
$stmt = $conn->prepare("SELECT * FROM galeria ORDER BY fecha_subida DESC");
$stmt->execute();
$galeria = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>

        <h2>Eventos</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Fecha del Evento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($eventos as $evento): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($evento['titulo']); ?></td>
                        <td><?php echo htmlspecialchars($evento['descripcion']); ?></td>
                        <td><?php echo htmlspecialchars($evento['fecha_evento']); ?></td>
                        <td>
                            <!-- Aquí puedes añadir botones para editar y eliminar -->
                            <form action="admin_dashboard.php" method="post" style="display:inline;">
                                <input type="hidden" name="accion" value="eliminar_evento">
                                <input type="hidden" name="id" value="<?php echo $evento['id']; ?>">
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Añadir Evento</h2>
        <form action="admin_dashboard.php" method="post">
            <input type="hidden" name="accion" value="añadir_evento">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
            </div>
            <div class="form-group">
                <label for="fecha_evento">Fecha del Evento:</label>
                <input type="date" class="form-control" id="fecha_evento" name="fecha_evento" required>
            </div>
            <div class="form-group">
                <label for="id_galeria">ID de la Foto (Galería):</label>
                <select class="form-control" id="id_galeria" name="id_galeria">
                    <?php foreach ($galeria as $foto): ?>
                        <option value="<?php echo $foto['id']; ?>"><?php echo htmlspecialchars($foto['id']); ?> - <?php echo htmlspecialchars($foto['url_foto']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Añadir Evento</button>
        </form>
    </div>
</body>
</html>
