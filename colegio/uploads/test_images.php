<?php
// Este archivo intentará mostrar las dos imágenes específicas

// Supongamos que los nombres de los archivos de imagen son los siguientes
$imagenBienvenida = 'nombre_de_la_imagen_para_bienvenida.jpg';
$imagenLogros = 'nombre_de_la_imagen_para_logros.jpg';

// Puedes reemplazar estos valores con los nombres de archivo que estás esperando ver
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test de Imágenes</title>
</head>
<body>
    <h1>Prueba de Carga de Imágenes</h1>
    <div>
        <h2>Imagen de Bienvenida</h2>
        <img src="uploads/<?php echo $imagenBienvenida; ?>" alt="Imagen de Bienvenida">
    </div>
    <div>
        <h2>Imagen de Logros</h2>
        <img src="uploads/<?php echo $imagenLogros; ?>" alt="Imagen de Logros">
    </div>
</body>
</html>
