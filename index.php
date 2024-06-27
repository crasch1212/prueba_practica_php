<?php
/**
 * Este script PHP maneja las peticiones HTTP relacionadas con libros en la biblioteca.
 * Utiliza enrutamiento básico para redirigir las solicitudes a métodos específicos del controlador de libros.
 */

// Incluir autoload para cargar clases automáticamente
spl_autoload_register(function ($className) {
    include 'controllers/' . $className . '.php';
});

// Crear instancia del controlador de libros
$controller = new LibrosController();

// Obtener la ruta de la solicitud actual
$uri = $_SERVER['REQUEST_URI'];
$urlParts = parse_url($uri);
$ruta = $urlParts['path'];

// Enrutamiento básico para manejar las solicitudes HTTP
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $ruta === '/biblioteca/libros') {
    // Manejar solicitud GET para listar libros
    $controller->index();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $ruta === '/biblioteca/libros') {
    // Manejar solicitud POST para crear un nuevo libro
    $controller->crearLibro();
} elseif ($_SERVER['REQUEST_METHOD'] === 'PATCH' && preg_match('/\/biblioteca\/libros\/(\d+)/', $ruta, $matches)) {
    // Manejar solicitud PATCH para actualizar un libro específico por su ID
    $idLibro = $matches[1];
    $controller->actualizarLibro($idLibro);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' && preg_match('/\/biblioteca\/libros\/(\d+)/', $ruta, $matches)) {
    // Manejar solicitud DELETE para eliminar un libro específico por su ID
    $idLibro = $matches[1];
    $controller->eliminarLibro($idLibro);
} else {
    // Manejar rutas no encontradas
    header("HTTP/1.1 404 Not Found");
    echo json_encode(array('error' => 'Ruta no encontrada'));
}
?>
