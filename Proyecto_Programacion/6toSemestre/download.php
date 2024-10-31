<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}

// Verificar si se ha especificado un archivo para descargar
if (isset($_GET['file'])) {
    $filename = basename($_GET['file']);
    $filepath = 'pdfs/' . $filename;

    // Verificar si el archivo existe y que esté dentro de la carpeta "pdfs"
    if (file_exists($filepath) && strpos(realpath($filepath), realpath('pdfs/')) === 0) {
        // Establecer las cabeceras adecuadas para la descarga
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . filesize($filepath));
        
        // Enviar el archivo al cliente
        readfile($filepath);
        exit();
    } else {
        echo "Archivo no encontrado.";
    }
} else {
    echo "No se ha especificado ningún archivo.";
}
?>