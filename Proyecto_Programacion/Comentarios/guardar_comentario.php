<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $escuela = mysqli_real_escape_string($conexion, $_POST['escuela']);
    $semestre = mysqli_real_escape_string($conexion, $_POST['semestre']);
    $comentario = mysqli_real_escape_string($conexion, $_POST['comentario']);

    $query = "INSERT INTO comentarios (nombre, escuela, semestre, comentario) 
              VALUES ('$nombre', '$escuela', '$semestre', '$comentario')";

    if (mysqli_query($conexion, $query)) {
        header("Location: index.php");
    } else {
        echo "Error al guardar el comentario: " . mysqli_error($conexion);
    }
}

mysqli_close($conexion);
?>