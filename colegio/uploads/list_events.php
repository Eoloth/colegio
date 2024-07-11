<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.html");
    exit();
}

require_once 'config.php';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT * FROM eventos ORDER BY id DESC");
    $stmt->execute();
    $eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lista de Eventos</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
        .btn-home {
            margin-bottom: 20px;
        }
        .btn-new-event {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Lista de Eventos</h1>
        <a href="../home.php" class="btn btn-primary btn-home">Regresar al Home</a>
        <a href="create_event.php" class="btn btn-success btn-new-event">Crear Nuevo Evento</a>
        <?php if ($eventos): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Fecha del Evento</th>
                        <th>Fecha de Publicación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($eventos as $evento): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($evento['id']); ?></td>
                            <td><?php echo htmlspecialchars($evento['titulo']); ?></td>
                            <td><?php echo htmlspecialchars($evento['descripcion']); ?></td>
                            <td><?php echo htmlspecialchars($evento['fecha_evento']); ?></td>
                            <td><?php echo htmlspecialchars($evento['fecha_publicacion']); ?></td>
                            <td>
                                <a href="edit_event.php?id=<?php echo $evento['id']; ?>" class="btn btn-primary">Editar</a>
                                <a href="delete_event.php?id=<?php echo $evento['id']; ?>" class="btn btn-danger">Borrar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay eventos para mostrar.</p>
        <?php endif; ?>
    </div>
</body>
</html>
