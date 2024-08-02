<?php
require_once 'config.php';

// Conexión a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si existe la entrada para "noticias"
$sql = "SELECT * FROM home WHERE identifier = 'noticias'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    // Si no existe, insertarla
    $insert_sql = "INSERT INTO home (identifier, noticias) VALUES ('noticias', 'Título predeterminado para noticias')";
    if ($conn->query($insert_sql) === TRUE) {
        echo "Fila de noticias creada exitosamente.";
    } else {
        echo "Error al crear la fila de noticias: " . $conn->error;
    }
} else {
    echo "La fila de noticias ya existe.";
}

$conn->close();
?>
